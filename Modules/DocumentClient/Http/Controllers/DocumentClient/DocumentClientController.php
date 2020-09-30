<?php

namespace Modules\DocumentClient\Http\Controllers\DocumentClient;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\DocumentClient\Entities\DocumentClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DocumentClientController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('is-allowed')->only(['index', 'create', 'edit', 'destroy']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('document.index'), 'text' => 'Data Dokumen Klien'],
        ];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->table_headers = [
            [
                "text" => 'Nama Debitur',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_name',
            ],
            [
                "text" => 'Pekerjaan',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_profesion',
            ],
            [
                "text" => 'Tipe Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit.unit_type',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit_number',
            ],
              [
                "text" => 'Nama Cluster',
                "align" => 'center',
                "sortable" => false,
                "value" => 'cluster_name',
            ],
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit_price',
            ],
            [
                "text" => 'Tgl Pengajuan',
                "align" => 'center',
                "sortable" => false,
                "value" => 'submission_date',
            ],
        ];
        return view('documentclient::document.index', [
            'page' => $this,
        ]);
    }


    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {   
        $this->breadcrumbs[] = ['href' => route('document.index'), 'text' => 'Tambah Document Klien'];

        return view('documentclient::document.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }

     /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "booking_id" => "bail|required",
        ]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('document::show');
    }

     /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Booking $document)
    {
        $this->breadcrumbs[] = ['href' => route('document.index'), 'text' => 'Edit Dokumen'];

        return view('documentclient::document.edit',[
            'page' => $this,
            'data' => $document,
        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Booking $document)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {


            $request->merge([
                'submission_date' => $request->submission_date ? \Carbon\Carbon::parse($request->submission_date)->format('Y-m-d') : '',
            ]);

            $document
                ->document()
                ->updateOrCreate([
                    'booking_id' => $request->input('booking_id')
                ], $request->all());

            foreach ($request->file('files') ?? [] as $key => $file) {
                foreach ($file as $file_name => $input) {
                    $uploaded_file_name = $request->input('booking_id').'_'.uniqid() . '.' . $input->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs(
                        'document/'.$file_name, $input, $uploaded_file_name
                    );

                    $document->document->$file_name = $uploaded_file_name;
                    $document->document->save();
                    // $request->merge([
                    //     $file_name => $uploaded_file_name,
                    // ]);
                }
            }
            // $has_document = DocumentClient::where('booking_id', $request->booking_id)->first();

            // if ($has_document) {
            //      $data = $has_document->update($request->all());
            // }else{
            //     $data = DocumentClient::create($request->all());
            // }

            DB::commit();
            return response_json(true, null, 'Data dokumen klien berhasil disimpan.', $document);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *
     * Validation Rules for Get Table Data
     *
     */
    public function validateTableRequest($request)
    {
        return Validator::make($request->all(), [
            "page" => "bail|required|numeric|min:1",
            "search" => "bail|present|nullable",
            "paginate" => "bail|required|numeric|in:5,10,15,-1",
            "sort" => "bail|present|array",
            "sort.*[0]" => "bail|required",
            "sort.*[1]" => "bail|required|boolean",
        ]);
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableData(Request $request)
    {
        $user = \Auth::user();
        if ($user->is_admin == '1') {
            $query = Booking::with('client', 'unit', 'document','unit.point.cluster')->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sales') {
            $query = Booking::with('client', 'unit', 'document','unit.point.cluster')
                            ->whereHas('sales', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }
        

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('total_amount', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('profession', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->submission_date = $item->document ? \Carbon\Carbon::parse($item->document->submission_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->client_name = $item->client->client_name;
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->cluster_name = $item->unit->point->cluster->cluster_name ?? '';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function table(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableData($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Return Form Helper
     *
     */
    public function getHelper()
    {
        return [
            'client' => Client::select('id AS value', 'client_name AS text', 'client_number', 'client_email', 'client_address', 'client_phone_number', 'client_mobile_number','profession')->get(),
        ];
    }

    /**
     *
     * Handle incoming request for form helper
     *
     */
    public function formHelper()
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getHelper());
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $document)
    {
        $data = $document->load('unit','client', 'document');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFile(Request $request, Booking $document, $file_name)
    {
        // return response_json(true, null, 'file berhasil dihapus.', $request->all());
        DB::beginTransaction();
        try {
            $document->document->update([
                $file_name => null
            ]);

            DB::commit();
            return response_json(true, null, 'file berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

<?php

namespace Modules\DocumentClient\Http\Controllers\DocumentAdmin;

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
use Illuminate\Support\Str;
use PDF;

class DocumentAdminController extends Controller
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
            ['href' => route('document-admin.index'), 'text' => 'Data Dokumen Admin'],
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
            [
                "text" => 'Status',
                "align" => 'center',
                "sortable" => false,
                "value" => 'approval_developer',
            ],
        ];
        return view('documentclient::document-admin.index', [
            'page' => $this,
        ]);
    }


    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {   
        $this->breadcrumbs[] = ['href' => route('document-admin.index'), 'text' => 'Tambah Dokumen Admin'];

        return view('documentclient::document-admin.create', [
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
            "submission_date" => "bail|required|date_format:Y-m-d",
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
        return $request->all();
        
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = DocumentClient::create($request->all());

            DB::commit();
            return response_json(true, null, 'Data dokumen klien berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormCancelRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "reject_reason" => "bail|required",
        ],[
            "reject_reason.required" => "Alasan pembatalan harus diisi."
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function cancelDocument(Request $request, Booking $document_admin)
    {
        $validator = $this->validateFormCancelRequest($request, $document_admin->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }
        
        DB::beginTransaction();
        try {

            $request->merge(['booking_status' => 'dokumen_cancel']);
            
            $data = $document_admin->update($request->all());
            

            DB::commit();
            return response_json(true, null, 'Data dokumen berhasil dibatalkan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
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
    public function edit(Booking $document_admin)
    {
        $this->breadcrumbs[] = ['href' => route('document-admin.index'), 'text' => 'Edit Dokumen'];

        return view('documentclient::document-admin.edit',[
            'page' => $this,
            'data' => $document_admin,
        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Booking $document_admin)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

            if ($request->has('approval_developer') && $request->input('approval_developer') == 'Disetujui' && $document_admin->booking_status == 'dokumen') {
                $document_admin->booking_status = 'spr';
                $document_admin->save();
            }

            $request->merge([
                'submission_date' => $request->submission_date ? \Carbon\Carbon::parse($request->submission_date)->format('Y-m-d') : '',
            ]);

            $document_admin
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

                    $document_admin->document->$file_name = $uploaded_file_name;
                    $document_admin->document->save();
                }
            }

            DB::commit();
            return response_json(true, null, 'Data dokumen klien berhasil disimpan.', $document_admin);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFile(Request $request, Booking $document_admin, $file_name)
    {
        // return response_json(true, null, 'file berhasil dihapus.', $request->all());
        DB::beginTransaction();
        try {
            $document_admin->document->update([
                $file_name => null
            ]);

            DB::commit();
            return response_json(true, null, 'file berhasil dihapus.');
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
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function downloadPDF(Request $request, Booking $document_admin)
    {
         try {
            $data = $document_admin->load('document');

            if ($data->document) {
                if ($data->document->url_file_ktp_pemohon || $data->document->url_file_ktp_suami_istri || $data->document->url_file_kk){

                    $pdf = PDF::loadview('documentclient::document-admin.document',['data' => $data]);
                    return $pdf->download('document.pdf');

                }else{
                    return response_json(false, null, 'Dokumen tidak ditemukan.');
                }
            }
            
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
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
        $query = Booking::with('client', 'unit', 'document')->orderBy('created_at', 'DESC');

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
            $item->approval_developer = $item->document ? $item->document->approval_developer : '';
            
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
    public function data(Booking $document_admin)
    {
        $data = $document_admin->load('unit','client', 'document');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

}

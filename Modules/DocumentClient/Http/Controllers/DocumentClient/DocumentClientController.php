<?php

namespace Modules\DocumentClient\Http\Controllers\DocumentClient;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\DocumentClient\Entities\DocumentClient;
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
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('document.index'), 'text' => 'Data Dokument Klien'],
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
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Pekerjaan',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Tgl Pengajuan',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Tanggal Jatuh Tempo',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Principal',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ]
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
            "client_id" => "bail|required|string",
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
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('document::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('document::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $query = DocumentClient::with('client')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('dp_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('point', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_name = $item->client->client_name;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block;
            $item->total_amount ='Rp '.$item->total_amount;
            $item->dp_amount = 'Rp '.$item->dp_amount;
            $item->installment = 'Rp '.$item->installment;
            $item->point = $item->unit->points;
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
}

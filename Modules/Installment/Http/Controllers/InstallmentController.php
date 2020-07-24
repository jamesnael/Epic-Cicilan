<?php

namespace Modules\Installment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InstallmentController extends Controller
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
            ['href' => route('commission.index'), 'text' => 'Data Komisi'],
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
                "text" => 'ID Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_number',
            ],
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
            ],
            [
                "text" => 'No Handphone',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_mobile_number',
            ],
            [
                "text" => 'Email',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_email',
            ],
            [
                "text" => 'No.Telepon',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_phone_number',
            ]
        ];
        return view('commission::commission.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('commission.index'), 'text' => 'Tambah Komisi'];

        return view('commission::commission.create', [
            'page' => $this,
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

            if ($request->total > 100) {
                return response_json(true, null, 'Total komisi tidak boleh melebihi 100%.');
            }

            $data = Commission::create($request->all());
            DB::commit();
            
            return response_json(true, null, 'Data komisi berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

   /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Commission $commission)
    {
        $this->breadcrumbs[] = ['href' => route('commission.edit', [$commission->slug]), 'text' => 'Edit Komisi ' . $commission->category_name];

        return view('commission::commission.edit', [
            'page' => $this,
            'data' => $commission,

        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Commission $commission)
    {
        $validator = $this->validateFormRequest($request, $commission->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $commission->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data komisi berhasil disimpan.', $data);
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
    public function destroy(Commission $commission)
    {
        DB::beginTransaction();
        try {
            $commission->delete();
            DB::commit();
            return response_json(true, null, 'Data komisi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
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
        $query = Commission::query();

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('sales_commission', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('sales_commission', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('main_coordinator_commission', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('regional_coordinator_commission', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->agency_commission = $item->agency_commission . ' %';
            $item->main_coordinator_commission = $item->main_coordinator_commission . ' %';
            $item->regional_coordinator_commission = $item->regional_coordinator_commission . ' %';
            $item->sales_commission = $item->sales_commission . ' %';
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
     * Handle incoming request for specific data
     *
     */
    public function data(Commission $commission)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $commission);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "sales_commission" => "bail|nullable|numeric",
            "agency_commission" => "bail|nullable|numeric",
            "regional_coordinator_commission" => "bail|nullable|numeric",
            "main_coordinator_commission" => "bail|nullable|numeric",
        ]);
    }
}

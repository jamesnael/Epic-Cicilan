<?php

namespace Modules\SalesAgent\Http\Controllers\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
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
            ['href' => route('sales.index'), 'text' => 'Data Sales'],
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
                "text" => 'Nama Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales_name',
            ],
            [
                "text" => 'Email Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales_email',
            ],
            [
                "text" => 'Nomor Telepon',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales_phone',
            ],
            [
                "text" => 'Alamat',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales_address',
            ],
            [
                "text" => 'PPH Final',
                "align" => 'center',
                "sortable" => true,
                "value" => 'pph_final',
            ],
        ];
        return view('salesagent::sales.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('sales.index'), 'text' => 'Tambah Sales'];

        return view('salesagent::sales.create', [
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
            $data = Sales::create($request->all());
            // if (condition) {
            //     $filename = 'ktp-' . $data->slug . 'extension'
            //     Storage::disk('public')->save('sales/' . $data->slug . '/' . $filename)
            //     $data->file_ktp
            // }
            // if (condition) {
            //     $data->file_npwp
            // }
            // $data->save();
            DB::commit();
            return response_json(true, null, 'Data agensi berhasil disimpan.', $data);
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
    public function edit(Sales $sales)
    {
        $this->breadcrumbs[] = ['href' => route('sales.edit', [$sales->slug]), 'text' => 'Edit Sales ' . $sales->sales_name];

        return view('salesagent::sales.edit', [
            'page' => $this,
            'data' => $sales
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Sales $sales)
    {
        $validator = $this->validateFormRequest($request, $sales->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $sales->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data agensi berhasil disimpan.', $data);
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
    public function destroy(Sales $sales)
    {
        DB::beginTransaction();
        try {
            $sales->delete();
            DB::commit();
            return response_json(true, null, 'Data agensi berhasil dihapus.');
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
        $query = Sales::query();

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('sales_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('sales_email', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('sales_phone', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('sales_address', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('pph_final', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->pph_final = $item->pph_final . ' %';
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
    public function data(Sales $sales)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $sales);
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
            "sales_name" => "bail|required|string|max:255",
            "sales_email" => "bail|required|required|email",
            "sales_phone" => "bail|required|string|max:255",
            "sales_address" => "bail|nullable|string|max:255",
            "province" => "bail|nullable|string|max:255",
            "city" => "bail|nullable|string|max:255",
            "pph_final" => "bail|required|between:0,100",
        ], [
            // "sales_name.required" => __('salesagent::validation.required'),
            // "sales_name.max" => __('salesagent::validation.max.string'),
            // "sales_phone.required" => __('salesagent::validation.required'),
            // "sales_phone.numeric" => __('salesagent::validation.numeric'),
            // "sales_email.required" => __('salesagent::validation.required'),
            // "sales_email.email" => __('salesagent::validation.email'),
            // "sales_address.required"=> __('salesagent::validation.required'),
            // "province.required"=> __('salesagent::validation.required'),
            // "city.required"=> __('salesagent::validation.required'),
        ]);
    }
}

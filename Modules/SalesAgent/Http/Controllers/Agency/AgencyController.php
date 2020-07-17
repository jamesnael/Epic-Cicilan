<?php

namespace Modules\SalesAgent\Http\Controllers\Agency;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\Agency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
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
            ['href' => route('agencies.index'), 'text' => 'Data Agensi'],
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
                "text" => 'Nama Agensi',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_name',
            ],
            [
                "text" => 'Email Agensi',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_email',
            ],
            [
                "text" => 'Nomor Telepon',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_phone',
            ],
            [
                "text" => 'Alamat',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_address',
            ],
        ];
        return view('salesagent::agency.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('agencies.index'), 'text' => 'Tambah Agensi'];

        return view('salesagent::agency.create', [
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
            $data = Agency::create($request->all());
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
    public function edit(Agency $agency)
    {
        $this->breadcrumbs[] = ['href' => route('agencies.edit', [$agency->slug]), 'text' => 'Edit Agensi ' . $agency->agency_name];

        return view('salesagent::agency.edit', [
            'page' => $this,
            'data' => $agency
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Agency $agency)
    {
        $validator = $this->validateFormRequest($request, $agency->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $agency->update($request->all());
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
    public function destroy(Agency $agency)
    {
        DB::beginTransaction();
        try {
            $agency->delete();
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
            "params" => "bail|required",
            "params.paginate" => "bail|required|numeric|in:10,25,50,100",
            "params.query" => "bail|required",
            "params.query.generalSearch" => "bail|present|nullable",
            "params.query.formFilter" => "bail|present|array",
            "params.query.formFilter.*.column" => ["bail", "required_with_all:params.query.formFilter.*.value"],
            "params.query.formFilter.*.value" => ["bail", "required_with_all:params.query.formFilter.*.column"],
            "params.sort" => "bail|required|array|min:1",
            "params.sort.*.column" => ["bail", "required"],
            "params.sort.*.value" => "bail|required|in:asc,desc",
        ]);
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableData(Request $request)
    {
        $query = Agency::query();

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('agency_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('agency_email', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('agency_phone', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('agency_address', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            \Log::info(json_encode($sort, JSON_PRETTY_PRINT));
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        return $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function table(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        // $validator = $this->validateTableRequest($request);

        // if ($validator->fails()) {
        //     return response_json(false, 'Isian form salah', $validator->errors()->first());
        // }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableData($request));
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
            "agency_name" => "bail|required|max:255",
            "agency_email" => "bail|required|required|email",
            "agency_phone" => "bail|required|numeric",
            "agency_address" => "bail|required",
            "province" => "bail|required|max:255",
            "city" => "bail|required|max:255",
        ], [
            "agency_name.required" => __('validation.required', ['attribute' => 'nama agensi']),
            "agency_name.max" => __('validation.max.string', ['attribute' => 'nama agensi', 'max' => '255']),
            "agency_phone.required" => __('validation.required', ['attribute' => 'nomor telepon']),
            "agency_phone.numeric" => __('validation.numeric', ['attribute' => 'nomor telepon']),
            "agency_email.required" => __('validation.required', ['attribute' => 'alamat e-mail']),
            "agency_email.email" => __('validation.email', ['attribute' => 'alamat e-mail']),
            "agency_address.required"=> __('validation.required', ['attribute' => 'alamat agensi']),
            "province.required"=> __('validation.required', ['attribute' => 'provinsi']),
            "city.required"=> __('validation.required', ['attribute' => 'kota']),
        ]);
    }
}

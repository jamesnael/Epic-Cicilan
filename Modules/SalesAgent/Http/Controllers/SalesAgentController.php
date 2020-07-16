<?php

namespace Modules\SalesAgent\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\Agency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SalesAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->breadcrumbs[] = ['url' => route('salesagent.index'), 'title' => 'Data Sales Agency'];

        return view('salesagent::index', [
            'page' => $this,
        ]);
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

        if ($request->input('params')['query']['generalSearch']) {
            $generalSearch = $request->input('params')['query']['generalSearch'];

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('agency_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('params')['query']['formFilter'] as $search_key => $search) {
            $query->where($search['column'], 'LIKE', '%' . $search['value'] . '%');
        }

        foreach ($request->input('params')['sort'] as $sort_key => $sort) {
            $query->orderBy($sort['column'], $sort['value']);
        }

        return $query->paginate($request->input('params')['paginate']);
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function table(Request $request)
    {
        $request->merge(['params' => json_decode($request->input('params'), true)]);

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
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['url' => route('salesagent.index'), 'title' => 'Data Sales Agency'];
        $this->breadcrumbs[] = ['url' => route('salesagent.index'), 'title' => 'Tambah Sales Agency'];

        return view('salesagent::create', [
            'page' => $this,
        ]);
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
            "agency_name.required" => __('validation.required', ['attribute' => 'nama agen']),
            "agency_name.max" => __('validation.max.string', ['attribute' => 'nama agen', 'max' => '255']),
            "agency_phone.required" => __('validation.required', ['attribute' => 'nomor telepon']),
            "agency_phone.numeric" => __('validation.numeric', ['attribute' => 'nomor telepon']),
            "agency_email.required" => __('validation.required', ['attribute' => 'alamat e-mail']),
            "agency_email.email" => __('validation.email', ['attribute' => 'alamat e-mail']),
            "agency_address.required"=> __('validation.required', ['attribute' => 'alamat agen']),
            "province.required"=> __('validation.required', ['attribute' => 'provinsi']),
            "city.required"=> __('validation.required', ['attribute' => 'kota']),
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
            return response_json(true, null, 'Data agen berhasil disimpan.', $data);
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
        return view('salesagent::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Agency $salesagent)
    {
        $this->breadcrumbs[] = ['url' => route('salesagent.index'), 'title' => 'Data Sales Agency'];
        $this->breadcrumbs[] = ['url' => route('salesagent.edit', [$salesagent->slug]), 'title' => 'Edit Sales Agency ' . $salesagent->agency_name];

        return view('salesagent::edit', [
            'page' => $this,
            'data' => $salesagent
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Agency $salesagent)
    {
        $validator = $this->validateFormRequest($request, $salesagent->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $salesagent->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data agen berhasil disimpan.', $data);
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
    public function destroy(Agency $salesagent)
    {
        DB::beginTransaction();
        try {
            $salesagent->delete();
            DB::commit();
            return response_json(true, null, 'Data agen berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

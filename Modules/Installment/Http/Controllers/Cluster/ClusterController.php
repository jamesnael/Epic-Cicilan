<?php

namespace Modules\Installment\Http\Controllers\Cluster;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Cluster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClusterController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('is-allowed')->only(['index', 'create', 'edit', 'delete']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('cluster.index'), 'text' => 'Data Cluster'],
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
                "text" => 'Nama Cluster',
                "align" => 'center',
                "sortable" => false,
                "value" => 'cluster_name',
            ],
        ];
        return view('installment::cluster.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('cluster.index'), 'text' => 'Tambah Cluster'];

        return view('installment::cluster.create', [
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
            $data = Cluster::create($request->all());
            DB::commit();
            return response_json(true, null, 'Data cluster berhasil disimpan.', $data);
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
    public function edit(Cluster $cluster)
    {
        $this->breadcrumbs[] = ['href' => route('cluster.edit', [$cluster->slug]), 'text' => 'Edit Cluster ' . $cluster->cluster_name];

        return view('installment::cluster.edit', [
            'page' => $this,
            'data' => $cluster,

        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Cluster $cluster)
    {
        $validator = $this->validateFormRequest($request, $cluster->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $cluster->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data cluster berhasil disimpan.', $data);
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
    public function delete(Cluster $cluster)
    {
        DB::beginTransaction();
        try {
            $cluster->delete();
            DB::commit();
            return response_json(true, null, 'Data kluster berhasil dihapus.');
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
        $query = Cluster::orderBy('created_at', 'DESC');


        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('cluster_name', 'LIKE', '%' . $generalSearch . '%');
                });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {

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
    public function data(Cluster $cluster)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $cluster);
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
            "cluster_name" => "bail|required|string|max:255",
           
        ]);
    }

}

<?php

namespace Modules\Installment\Http\Controllers\TipeProgram;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\TipeProgram;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TipeProgramController extends Controller
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
            ['href' => route('tipe-program.index'), 'text' => 'Data Tipe Program'],
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
                "text" => 'Tipe Program',
                "align" => 'center',
                "sortable" => false,
                "value" => 'nama_program',
            ],
            [
                "text" => 'Harga Termasuk',
                "align" => 'left',
                "sortable" => false,
                "value" => 'harga_termasuk',
            ],
            [
                "text" => 'Harga Tidak Termasuk',
                "align" => 'left',
                "sortable" => false,
                "value" => 'harga_tidak_termasuk',
            ],
            [
                "text" => 'Gimmick',
                "align" => 'center',
                "sortable" => false,
                "value" => 'gimmick',
            ],
            [
                "text" => 'Keterangan',
                "align" => 'center',
                "sortable" => false,
                "value" => 'keterangan',
            ]
        ];
        return view('installment::tipe_program.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('tipe-program.index'), 'text' => 'Tambah Tipe Program'];

        return view('installment::tipe_program.create', [
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
            $data = TipeProgram::create($request->all());
            DB::commit();
            
            return response_json(true, null, 'Data tipe program berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

   /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Responsec
     */
    public function edit(TipeProgram $tipe_program)
    {
        $this->breadcrumbs[] = ['href' => route('tipe-program.edit', [$tipe_program->slug]), 'text' => 'Edit Tipe Program ' . $tipe_program->nama_program];

        return view('installment::tipe_program.edit', [
            'page' => $this,
            'data' => $tipe_program,

        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, TipeProgram $tipe_program)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $tipe_program->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data tipe program berhasil disimpan.', $data);
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
    public function destroy(TipeProgram $tipe_program)
    {
        DB::beginTransaction();
        try {
            $tipe_program->delete();
            DB::commit();
            return response_json(true, null, 'Data tipe program berhasil dihapus.');
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
        $query = TipeProgram::orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('nama_program', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('harga_termasuk', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('harga_tidak_termasuk', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('gimmick', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('keterangan', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

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
    public function data(TipeProgram $tipe_program)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $tipe_program);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request)
    {
        return Validator::make($request->all(), [
            "nama_program" => "bail|required|string|max:255",
            "harga_termasuk" => "bail|nullable|array",
            "harga_tidak_termasuk" => "bail|nullable|array",
            "gimmick" => "bail|nullable|string|max:255",
            "keterangan" => "bail|nullable|string",
        ]);
    }
}

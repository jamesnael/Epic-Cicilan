<?php

namespace Modules\Installment\Http\Controllers\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Unit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class UnitController extends Controller
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
            ['href' => route('unit.index'), 'text' => 'Data Unit'],
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
                "text" => 'Tipe Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_type',
            ],
            [
                "text" => 'No Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Blok',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_block',
            ],
            [
                "text" => 'Luas Tanah',
                "align" => 'center',
                "sortable" => true,
                "value" => 'surface_area',
            ],
            [
                "text" => 'Luas Bangunan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'building_area',
            ],
            
        ];
        return view('installment::unit.index', [
            'page' => $this,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('unit.index'), 'text' => 'Tambah Unit'];

        return view('installment::unit.create', [
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

            $data = Unit::create($request->all());
            DB::commit();
            
            return response_json(true, null, 'Data unit berhasil disimpan.', $data);
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
    public function edit(Unit $unit)
    {
        $this->breadcrumbs[] = ['href' => route('unit.edit', [$unit->slug]), 'text' => 'Edit Klien ' . $unit->unit_number];

        return view('installment::unit.edit', [
            'page' => $this,
            'data' => $unit,

        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Unit $unit)
    {
        $validator = $this->validateFormRequest($request, $unit->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $unit->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data unit berhasil disimpan.', $data);
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
    public function destroy(Unit $unit)
    {
        DB::beginTransaction();
        try {
            $unit->delete();
            DB::commit();
            return response_json(true, null, 'Data unit berhasil dihapus.');
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
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "unit_type" => "bail|required|string|max:255",
            "unit_number" => "bail|required|string|max:255",
            "unit_block" => "bail|required|string|max:255",
            "surface_area" => "bail|required|numeric",
            "building_area" => "bail|required|numeric",
            "points" => "bail|required|numeric",
            "electrical_power" => "bail|required|numeric",
            "utj" => "bail|required|numeric",
            "closing_fee" => "bail|required|numeric",
            "available" => "bail|nullable",
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
        $query = Unit::query();

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('unit_type', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('unit_number', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('unit_block', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('points', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('surface_area', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('building_area', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('closing_fee', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->surface_area = $item->surface_area . ' m2';
            $item->building_area = $item->building_area . ' m2';
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
    public function data(Unit $unit)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $unit);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

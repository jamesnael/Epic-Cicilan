<?php

namespace Modules\RewardPoint\Http\Controllers\RewardPoint;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\RewardPoint\Entities\RewardCategory;
use Modules\RewardPoint\Entities\RewardPoint;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RewardPointController extends Controller
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
            ['href' => route('users.index'), 'text' => 'Data Reward'],
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
                "text" => 'Kategori Reward',
                "align" => 'center',
                "sortable" => true,
                "value" => 'category.category_name',
            ],
            [
                "text" => 'Nama Reward',
                "align" => 'center',
                "sortable" => true,
                "value" => 'reward_name',
            ],
            [
                "text" => 'Redeem Point Koordinator Utama',
                "align" => 'center',
                "sortable" => true,
                "value" => 'redeem_point_main_coordinator',
            ],
            [
                "text" => 'Redeem Point Koordinator Wilayah',
                "align" => 'center',
                "sortable" => true,
                "value" => 'redeem_point_regional_coordinator',
            ],
            [
                "text" => 'Redeem Point Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'redeem_point_agency',
            ],
            [
                "text" => 'Redeem Point Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => 'redeem_point_sales',
            ],
            [
                "text" => 'Deskripsi',
                "align" => 'center',
                "sortable" => true,
                "value" => 'description',
            ],
        ];
        return view('rewardpoint::reward-point.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('reward-point.index'), 'text' => 'Tambah Reward Point'];

        return view('rewardpoint::reward-point.create', [
            'page' => $this,
        ])->with($this->getHelper());
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
            $data = RewardPoint::create($request->all());
            DB::commit();
            return response_json(true, null, 'Data reward berhasil disimpan.', $data);
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
    public function edit(RewardPoint $reward_point)
    {
        $this->breadcrumbs[] = ['href' => route('reward-point.edit', [$reward_point->slug]), 'text' => 'Edit Reward Point' . $reward_point->reward_name];

        return view('rewardpoint::reward-point.edit', [
            'page' => $this,
            'data' => $reward_point,

        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, RewardPoint $reward_point)
    {
        $validator = $this->validateFormRequest($request, $reward_point->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $reward_point->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data reward berhasil disimpan.', $data);
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
    public function destroy(RewardPoint $reward_point)
    {
        DB::beginTransaction();
        try {
            $reward_point->delete();
            DB::commit();
            return response_json(true, null, 'Data reward berhasil dihapus.');
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
        $query = RewardPoint::with('category');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('reward_categories.category_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('reward_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('redeem_point', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('kuota', 'LIKE', '%' . $generalSearch . '%');
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
    public function data(RewardPoint $reward_point)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $reward_point);
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
            "category_reward_id" => "bail|required|string|max:255",
            "reward_name" => "bail|required|string|max:255",
            "description" => "bail|nullable",
        ]);
    }

     /**
     *
     * Return Form Helper
     *
     */
    public function getHelper()
    {
        return [
            'category' => RewardCategory::select('id AS value', 'category_name AS text')->get()
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

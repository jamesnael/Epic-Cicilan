<?php

namespace Modules\RewardPoint\Http\Controllers\TukarPoint;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\RewardPoint\Entities\RewardCategory;
use Modules\RewardPoint\Entities\ExchangePointSales;
use Modules\RewardPoint\Entities\RewardPoint;
use Modules\SalesAgent\Entities\Sales;
use Modules\SalesAgent\Entities\Agency;
use Modules\SalesAgent\Entities\RegionalCoordinator;
use Modules\SalesAgent\Entities\MainCoordinator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TukarPointController extends Controller
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
            ['href' => route('tukar-point.index'), 'text' => 'Tukar Point'],
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
                "value" => 'user.full_name',
            ],
            [
                "text" => 'Nama Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency.agency_name',
            ],
            [
                "text" => 'Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => 'regional_coordinator.full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sisa_point',
            ],
        ];

        $this->table_headers_agent = [
            [
                "text" => 'Nama Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_name',
            ],
            [
                "text" => 'Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => 'regional_coordinator.full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sisa_point',
            ],
        ];

        $this->table_headers_korwil = [
            [
                "text" => 'Nama Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => 'full_name',
            ],
            [
                "text" => 'Korut',
                "align" => 'center',
                "sortable" => true,
                "value" => 'main_coordinator.full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sisa_point',
            ],
        ];

        $this->table_headers_korut = [
            [
                "text" => 'Nama Koordinator Utama',
                "align" => 'center',
                "sortable" => true,
                "value" => 'full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sisa_point',
            ],
        ];

        return view('rewardpoint::TukarPoint.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point.index'), 'text' => 'Tambah Tukar Point'];

        return view('rewardpoint::TukarPoint.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function editSales($id)
    {
        $this->table_headers = [
            [
                "text" => 'Category Reward',
                "align" => 'center',
                "sortable" => true,
                "value" => 'reward_point.category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => true,
                "value" => 'reward_point.reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'exchange_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales.total_point',
            ],
        ];
        return view('rewardpoint::TukarPoint.history-sales', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    public function editAgent($id)
    {
        $this->table_headers = [
            [
                "text" => 'Category Reward',
                "align" => 'center',
                "sortable" => true,
                "value" => 'category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => true,
                "value" => 'reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
        ];
        return view('rewardpoint::TukarPoint.history-agent', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    public function editKorwil($id)
    {
        $this->table_headers = [
            [
                "text" => 'Category Reward',
                "align" => 'center',
                "sortable" => true,
                "value" => 'category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => true,
                "value" => 'reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
        ];
        return view('rewardpoint::TukarPoint.history-korwil', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    public function editKorut($id)
    {
        $this->table_headers = [
            [
                "text" => 'Category Reward',
                "align" => 'center',
                "sortable" => true,
                "value" => 'category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => true,
                "value" => 'reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_point',
            ],
        ];
        return view('rewardpoint::TukarPoint.history-korut', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, RewardPoint $tukar_point)
    {
        $validator = $this->validateFormRequest($request, $tukar_point->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $tukar_point->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data reward berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
    public function getTableDataSales(Request $request)
    {
        $query = Sales::with('regional_coordinator', 'main_coordinator', 'agency', 'user', 'point', 'booking')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('users.full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableSales(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataSales($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataAgent(Request $request)
    {
        $query = Agency::with('regional_coordinator', 'point')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableAgent(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataAgent($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataKorwil(Request $request)
    {
        $query = RegionalCoordinator::with('main_coordinator', 'agency')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorwil(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorwil($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataKorut(Request $request)
    {
        $query = MainCoordinator::with('regional_coordinators', 'point')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorut(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorut($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

     public function getTableDataSalesHistory(Request $request)
    {
        $query = ExchangePointSales::with('sales_point', 'reward_point', 'reward_point.category', 'sales_point.sales')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                // $subquery->where('users.full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableSalesHistory(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataSalesHistory($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataAgentHistory(Request $request)
    {
        $query = Agency::with('regional_coordinator', 'point')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableAgentHistory(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataAgentHistory($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataKorwilHistory(Request $request)
    {
        $query = RegionalCoordinator::with('main_coordinator', 'agency')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorwilHistory(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorwilHistory($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataKorutHistory(Request $request)
    {
        $query = MainCoordinator::with('regional_coordinators', 'point')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorutHistory(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorutHistory($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

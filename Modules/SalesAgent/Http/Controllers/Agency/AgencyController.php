<?php

namespace Modules\SalesAgent\Http\Controllers\Agency;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\Agency;
use Modules\SalesAgent\Entities\RegionalCoordinator;
use Modules\Commission\Entities\Commission;
use Modules\SalesAgent\Entities\MainCoordinator;
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
            ['href' => route('agencies.index'), 'text' => 'Data Sub Agent'],
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
                "text" => 'Koordinator Wilayah',
                "align" => 'center',
                "sortable" => true,
                "value" => 'regional_coordinator.full_name',
            ],
            [
                "text" => 'Nama Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_name',
            ],
            [
                "text" => 'Email Sub Agent',
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
            [
                "text" => 'PPH Final',
                "align" => 'center',
                "sortable" => true,
                "value" => 'pph_final',
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
        $this->breadcrumbs[] = ['href' => route('agencies.index'), 'text' => 'Tambah Sub Agent'];

        return view('salesagent::agency.create', [
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
             $request->merge([
                'id_agency_commision' => $request->id_agency_commission,
                'id_sales_commission' => $request->id_agency_commission,
                'id_regional_coordinator_commission' => $request->id_agency_commission,
                'id_main_coordinator_commission' => $request->id_agency_commission,
            ]);

            $data = Agency::create($request->all());
            DB::commit();
            return response_json(true, null, 'Data sub agent berhasil disimpan.', $data);
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
        $this->breadcrumbs[] = ['href' => route('agencies.edit', [$agency->slug]), 'text' => 'Edit Sub Agent ' . $agency->agency_name];

        return view('salesagent::agency.edit', [
            'page' => $this,
            'data' => $agency
        ])->with($this->getHelper());
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
            $request->merge([
                'id_agency_commision' => $request->id_agency_commission,
                'id_sales_commission' => $request->id_agency_commission,
                'id_regional_coordinator_commission' => $request->id_agency_commission,
                'id_main_coordinator_commission' => $request->id_agency_commission,
            ]);
            
            $data = $agency->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data sub agent berhasil disimpan.', $data);
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
            return response_json(true, null, 'Data sub agent berhasil dihapus.');
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
        $query = Agency::with('regional_coordinator');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('agency_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('agency_email', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('agency_phone', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('agency_address', 'LIKE', '%' . $generalSearch . '%');
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
    public function data(Agency $agency)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $agency);
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
            "agency_name" => "bail|required|string|max:255",
            "agency_email" => "bail|required|required|email",
            "agency_phone" => "bail|required|string|max:255",
            "agency_address" => "bail|nullable|string|max:255",
            "province" => "bail|nullable|string|max:255",
            "city" => "bail|nullable|string|max:255",
            "pph_final" => "bail|required|between:0,100",
        ], [
            // "agency_name.required" => __('salesagent::validation.required'),
            // "agency_name.max" => __('salesagent::validation.max.string'),
            // "agency_phone.required" => __('salesagent::validation.required'),
            // "agency_phone.numeric" => __('salesagent::validation.numeric'),
            // "agency_email.required" => __('salesagent::validation.required'),
            // "agency_email.email" => __('salesagent::validation.email'),
            // "agency_address.required"=> __('salesagent::validation.required'),
            // "province.required"=> __('salesagent::validation.required'),
            // "city.required"=> __('salesagent::validation.required'),
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
            'agency' => Agency::select('id AS value', 'agency_name AS text','regional_coordinator_id')->get(),
            'main_coordinator' => MainCoordinator::select('id AS value', 'full_name AS text')->get(),
            'regional_coordinator' => RegionalCoordinator::select('id AS value', 'full_name AS text')->get(),
            'regional_coordinator_commission' => Commission::select('id AS value', 'regional_coordinator_commission AS text')->get(),
            'main_coordinator_commission' => Commission::select('id AS value', 'main_coordinator_commission AS text')->get(),
            'agency_commission' => Commission::select('id AS value', 'agency_commission AS text','sales_commission','agency_commission','main_coordinator_commission', 'regional_coordinator_commission')->get(),
            'sales_commission' => Commission::select('id AS value', 'sales_commission AS text', 'agency_commission', 'main_coordinator_commission', 'regional_coordinator_commission')->get()
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

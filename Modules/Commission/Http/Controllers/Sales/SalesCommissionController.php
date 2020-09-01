<?php

namespace Modules\Commission\Http\Controllers\Sales;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Commission\Entities\Commission;
use Modules\Installment\Entities\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SalesCommissionController extends Controller
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
            ['href' => route('salescommission.index'), 'text' => 'Data Komisi Penjualan'],
        ];
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
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
                "text" => 'Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_name',
            ],
            [
                "text" => 'Koordinator Wilayah',
                "align" => 'center',
                "sortable" => true,
                "value" => 'korwil_name',
            ],
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
            ],
            [
                "text" => 'Tanggal Transaksi',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Data Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Harga Pricelist',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Type Komisi',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Komisi Koordinator Utama',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Komisi Bruto Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Total Komisi(PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Komisi Bruto Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Total Komisi Sub Agent (PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Pencairan 1 (50%)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Pencairan 2 (50%)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
        ];
        return view('commission::salescommission.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Tambah Komisi'];

        return view('commission::salescommission.create', [
            'page' => $this,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('commission::show');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Booking $salescommission)
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Edit Komisi Sales'];

        return view('commission::salescommission.edit',[
            'page' => $this,
            'data' => $salescommission,
        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Booking $salescommission)
    {
        //
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
        $query = Booking::with('client', 'unit', 'document', 'sales')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                // $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('dp_amount', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('point', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->sales_name = $item->sales->user->full_name;
            $item->agency_name = $item->sales->agency ? $item->sales->agency->agency_name : '';
            $item->korwil_name = $item->sales->regional_coordinator ? $item->sales->regional_coordinator->full_name : '';
            $item->korut_name = $item->sales->main_coordinator ? $item->sales->main_coordinator->full_name : '';
            $item->client_name = $item->client->client_name;
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            
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
    public function data(Booking $salescommission)
    {
        $data = $salescommission->load('unit','client','sales','sales.user','sales.main_coordinator', 'sales.agency', 'sales.regional_coordinator');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Return Form Helper
     *
     */
    public function getHelper()
    {
        return [
            'pph_21' => json_decode(option('pph_21', json_encode([]))),
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

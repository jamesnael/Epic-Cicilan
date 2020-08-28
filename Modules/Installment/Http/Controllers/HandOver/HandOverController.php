<?php

namespace Modules\Installment\Http\Controllers\HandOver;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HandOverController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('handover.index'), 'text' => 'Data Hand Over Unit'],
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
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'No. Handphone',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Harga Unit',
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
                "text" => 'Tgl AJB',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Schedule Tandatangan',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Dokumen Awal',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
        ];
        return view('installment::handover.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('handover.index'), 'text' => 'Tambah Schedule Hand Over Unit'];

        return view('installment::handover.create', [
            'page' => $this,
        ])->with($this->getHelper());
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
        return view('installment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->breadcrumbs[] = ['href' => route('handover.index'), 'text' => 'Edit Handover Unit'];

        return view('installment::handover.edit',[
            'page' => $this,
            'data' => $handover,
        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Booking $handover)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "booking_id" => "bail|required",
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
        $query = Booking::with('client', 'unit', 'handover', 'sales')->orderBy('created_at', 'DESC');

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
            $item->unit_name            = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price           = 'Rp '.format_money($item->total_amount);
            $item->payment_method       = $item->payment_method;
            $item->received_date        = $item->handover ? ($item->handover->received_date) != null ? \Carbon\Carbon::parse($item->handover->received_date)->locale('id')->translatedFormat('d F Y'): '' : '';
            $item->client_name          = $item->client->client_name;
            $item->client_mobile_number = $item->client->client_mobile_number;
            $item->sales_name           = $item->sales->user->full_name;
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
     * Return Form Helper
     *
     */
    public function getHelper()
    {
        return [
            'client' => Client::select('id AS value', 'client_name AS text', 'client_number', 'client_email', 'client_address', 'client_phone_number', 'client_mobile_number','profession')->get(),
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
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $handover)
    {
        $data = $handover->load('unit','client', 'handover','sales.user');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

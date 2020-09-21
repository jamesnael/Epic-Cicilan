<?php

namespace Modules\Installment\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Modules\RewardPoint\Entities\Point;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CancelBookingController extends Controller
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
            ['href' => route('booking.index'), 'text' => 'Data Cancel Booking'],
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
                "text" => 'Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
            ],
            [
                "text" => 'Tipe Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit.unit_type',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'total_amount',
            ],
            [
                "text" => 'DP',
                "align" => 'center',
                "sortable" => true,
                "value" => 'dp_amount',
            ],
            [
                "text" => 'Cicilan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'installment',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'payment_type',
            ],
            [
                "text" => 'Tanggal Jatuh Tempo',
                "align" => 'center',
                "sortable" => true,
                "value" => 'due_date',
            ],
            [
                "text" => 'Principal',
                "align" => 'center',
                "sortable" => true,
                "value" => 'principal',
            ],
            [
                "text" => 'Status',
                "align" => 'center',
                "sortable" => true,
                "value" => 'status',
            ]
        ];
        return view('installment::cancel-booking.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('installment::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('installment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Responsec
     */
    public function edit(Booking $booking)
    {
        $table_headers = [
            [
                "text" => '#',
                "align" => 'center',
                "sortable" => false,
                "value" => 'table_index',
            ],
            [
                "text" => 'Pembayaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment',
            ],
            [
                "text" => 'Jatuh Tempo',
                "align" => 'center',
                "sortable" => false,
                "value" => 'due_date',
            ],
            [
                "text" => 'Total Angsuran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'installment',
            ],
            [
                "text" => 'Cara Pembayaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_method',
            ],
            [
                "text" => 'Tanggal Pembayaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_date',
            ],
            [
                "text" => 'Denda',
                "align" => 'center',
                "sortable" => false,
                "value" => 'fine',
            ],
            [
                "text" => 'Sisa Angsuran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'credit',
            ]
        ];
        $this->breadcrumbs[] = ['href' => route('cancel-booking.edit', [$booking->slug]), 'text' => 'Detail Cancel Booking ' . ''];

        return view('installment::cancel-booking.edit', [
            'page' => $this,
            'data' => $booking,
            'table_headers' => $table_headers,

        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
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
        $query = Booking::has('payments')->with('client','unit','payments')->whereIn('booking_status', ['akad_cancel', 'ppjb_cancel','cicilan_cancel', 'spr_cancel','dokumen_cancel'])->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('dp_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('point', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_name = $item->client->client_name;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block;
            $item->total_amount ='Rp '.format_money($item->total_amount);
            $item->dp_amount = 'Rp '.format_money($item->dp_amount);
            $item->installment = 'Rp '.format_money($item->installment);
            $item->principal = 'Rp '.format_money($item->principal);
            $item->point = $item->unit->points;

            if ($item->booking_status == 'cicilan_cancel') {
                $item->status = "Cancel di Cicilan";
            }elseif($item->booking_status == 'ppjb_cancel'){
                $item->status = "Cancel di PPJB";
            }elseif($item->booking_status == 'akad_cancel'){
                $item->status = "Cancel di Akad KPR";
            }elseif($item->booking_status == 'dokumen_cancel'){
                $item->status = "Cancel di Dokumen";
            }else{
                $item->status = "Cancel di SPR";
            }

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
            'sales' => Sales::with('user','agency', 'main_coordinator', 'regional_coordinator')->get()->transform(function($item){
                        $item->value = $item->id;
                        $item->text = $item->user->full_name;
                        $item->agency_name = $item->agency->agency_name ?? '';
                        $item->regional_coordinator = $item->regional_coordinator->full_name ?? '';
                        $item->main_coordinator = $item->main_coordinator->full_name ?? '';

                        return $item->only(['value', 'text', 'agency_name', 'regional_coordinator', 'main_coordinator', 'main_coordinator_id','regional_coordinator_id', 'agency_id']);
                    }),
            'client' => Client::select('id AS value', 'client_name AS text', 'client_number', 'client_email', 'client_address', 'client_phone_number', 'client_mobile_number')->get(),
            'unit' => Point::select('id AS value', 'building_type AS text', 'closing_fee', 'point')->get(),
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
    public function data(Booking $booking)
    {
        $data = $booking->load('unit','client','sales','sales.user','sales.main_coordinator', 'sales.agency', 'sales.regional_coordinator');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

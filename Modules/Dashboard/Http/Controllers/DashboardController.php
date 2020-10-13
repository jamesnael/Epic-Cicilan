<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DocumentClient\Entities\DocumentClient;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\BookingPayment;
use Modules\Installment\Entities\AkteJualBeli;
use Modules\Installment\Entities\AkadKpr;
use Modules\Installment\Entities\PPJB;
use Modules\Installment\Entities\Handover;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('dashboard.index'), 'text' => 'Dashboard'],
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
                "sortable" => false,
                "value" => 'client_name',
            ],
            [
                "text" => 'Tipe Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit_type',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'total_amount',
            ],
            [
                "text" => 'DP',
                "align" => 'center',
                "sortable" => false,
                "value" => 'dp_amount',
            ],
            [
                "text" => 'Cicilan',
                "align" => 'center',
                "sortable" => false,
                "value" => 'installment',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_type',
            ],
            [
                "text" => 'Tanggal Jatuh Tempo',
                "align" => 'center',
                "sortable" => false,
                "value" => 'due_date',
            ]
        ];

        $document = Booking::bookingStatus('dokumen')->whereDoesntHave('document')
                    ->orWhereHas('document', function($subquery){
                            $subquery->where('approval_developer', '!=', 'Disetujui');
                    })->count();
        $akad_kpr = Booking::has('payments')->has('ppjb')
                            ->doesntHave('unpaid_payments')->kprKpa()
                            ->bookingStatus('akad')->count();

        $ajb = Booking::has('payments')->doesntHave('unpaid_payments')->bookingStatus('ajb_handover')->count();
        $handover = Booking::bookingStatus('ajb_handover')->with('handover')
                            ->whereDoesntHave('handover', function($subquery) {
                                $subquery->where('approval_client_status', '=', 'Approved');
                                $subquery->where('approval_developer_status', '=', 'Approved');
                                $subquery->where('approval_notaris_status', '=', 'Approved');
                                $subquery->where('handover_doc_sign_name', '!=', '');
                            })->count();
        
        $now = \Carbon\Carbon::now()->format('m');
        $year_now = \Carbon\Carbon::now()->format('Y');

        $installment_pending = BookingPayment::whereMonth('due_date', $now)
                                            ->whereYear('due_date', $year_now)
                                            ->whereNull('payment_date')
                                            ->where('payment_status', 'Unpaid')
                                            ->whereHas('booking', function($subquery) {
                                                 $subquery->whereIn('booking_status',['cicilan','cicilan_sp3k']);
                                            })
                                            ->count();

        $installment_paid = BookingPayment::whereMonth('due_date', '<=', $now)
                                          ->whereNotNull('payment_date')
                                          ->where('payment_status', 'Paid')
                                          ->whereHas('booking', function($subquery) {
                                                 $subquery->whereIn('booking_status',['cicilan','cicilan_sp3k']);
                                            })
                                          ->count();

        $unpaid = BookingPayment::whereMonth('due_date','<=', $now)
                                 ->whereNull('payment_date')
                                 ->where('payment_status', 'Unpaid')
                                 ->whereHas('booking', function($subquery) {
                                     $subquery->whereIn('booking_status',['cicilan','cicilan_sp3k']);
                                 })
                                 ->sum('installment');

        $paid = BookingPayment::whereMonth('due_date','<=', $now)
                                ->whereNotNull('payment_date')
                                ->where('payment_status', 'Paid')
                                ->whereHas('booking', function($subquery) {
                                     $subquery->whereIn('booking_status',['cicilan','cicilan_sp3k']);
                                })
                                ->sum('total_paid');

        $ajb_schedule = AkteJualBeli::with('booking', 'booking.unit', 'booking.client')->whereNotNull('ajb_date')->whereNotNull('ajb_time')->get();
        $collection_ajb = collect($ajb_schedule)->transform(function($item) {
            $item->color = 'green';
            $item->name = 'AJB';
            $item->start = $item->ajb_date .' '. $item->ajb_time; 
            $item->end = '';
            $item->timed = true;
            $item->unit = $item->booking->unit->unit_type .'/'. $item->booking->unit->unit_block .'/'. $item->booking->unit->unit_number;
            $item->client = $item->booking->client->client_name;
            return $item;
        });

        $akad = AkadKpr::with('booking', 'booking.unit', 'booking.client')->whereNotNull('akad_date')->whereNotNull('akad_time')->get();
        $collection_akad = collect($akad)->transform(function($item) {
            $item->color = 'cyan';
            $item->name = 'Akad KPR';
            $item->start = $item->akad_date .' '. $item->akad_time; 
            $item->end = '';
            $item->timed = true;
            $item->unit = $item->booking->unit->unit_type .'/'. $item->booking->unit->unit_block .'/'. $item->booking->unit->unit_number;
            $item->client = $item->booking->client->client_name;
            return $item;
        });
        $ppjb = PPJB::with('booking', 'booking.unit','booking.client')->whereNotNull('ppjb_date')->whereNotNull('ppjb_time')->get();
        $collection_ppjb = collect($ppjb)->transform(function($item) {
            $item->color = 'deep-purple';
            $item->name = 'PPJB';
            $item->start = $item->ppjb_date .' '. $item->ppjb_time;
            $item->end = '';
            $item->timed = true;
            $item->unit = $item->booking->unit->unit_type .'/'. $item->booking->unit->unit_block .'/'. $item->booking->unit->unit_number;
            $item->client = $item->booking->client->client_name;
            return $item;
        });

        $handover_schedule = Handover::with('booking', 'booking.unit','booking.client')->whereNotNull('handover_date')->whereNotNull('time')->get();
        $collection_handover = collect($handover_schedule)->transform(function($item) {
            $item->color = 'deep-purple';
            $item->name = 'Handover';
            $item->start = $item->handover_date .' '. $item->time; 
            $item->end = '';
            $item->timed = true;
            $item->unit = $item->booking->unit->unit_type .'/'. $item->booking->unit->unit_block .'/'. $item->booking->unit->unit_number;
            $item->client = $item->booking->client->client_name;
            return $item;
        });

        $collection = collect([
            'AJB' => $collection_ajb,
            'Akad' => $collection_akad,
            'ppjb' => $collection_ppjb,
            'handover' => $collection_handover,
        ]);

        $collect_calendar = $collection->flatten(1);

        $event_calendar = $collect_calendar->values()->all();


        return view('dashboard::index',[
            'page' => $this,
            'document' => $document,
            'akad_kpr' => $akad_kpr,
            'ajb' => $ajb,
            'handover' => $handover,
            'installment_pending' => $installment_pending,
            'installment_paid' => $installment_paid,
            'unpaid' => $unpaid,
            'paid' => $paid,
            'events' => $event_calendar,
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
        $now = \Carbon\Carbon::now()->format('m');
        $query = Booking::has('payments')->with('client','unit','payments')
        ->whereHas('payments', function($subquery) use($now){
            $subquery->whereMonth('due_date', $now);
            $subquery->whereNull('payment_date');
            $subquery->where('payment_status', 'Unpaid');

        })
        ->orderBy('created_at', 'DESC');

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
            $item->unit_number = $item->unit->unit_block .'/'. $item->unit->unit_number;
            $item->total_amount ='Rp '.format_money($item->total_amount);
            $item->dp_amount = 'Rp '.format_money($item->dp_amount);
            $item->installment = 'Rp '.format_money($item->installment);
            $item->principal = 'Rp '.format_money($item->principal);
            $item->unit_type = $item->unit->unit_type;
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
     * Query for get data for table
     *
     */
    public function getPaidTableData(Request $request)
    {
        $now = \Carbon\Carbon::now()->format('m');
        $query = Booking::has('payments')->with('client','unit','payments')
        ->whereHas('payments', function($subquery) use($now){
            $subquery->whereMonth('due_date', $now)
                     ->whereNotNull('payment_date')
                     ->where('payment_status', 'Paid');

        })
        ->orderBy('created_at', 'DESC');

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
            $item->unit_type = $item->unit->unit_type;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tablePaid(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getPaidTableData($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DocumentClient\Entities\DocumentClient;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\BookingPayment;

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
                "text" => 'Nama Klien',
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
                "text" => 'Cicilan',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Tgl Jatuh Tempo',
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
                "text" => 'Status',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
        ];

        $document = DocumentClient::where('approval_developer', 'Pending')->count();
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
        
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        $installment_pending = BookingPayment::where('due_date', $now)
                                             ->whereNull('payment_date')
                                             ->where('payment_status', 'Unpaid')
                                             ->count();

        $installment_paid = BookingPayment::where('due_date', '<=', $now)
                                          ->whereNotNull('payment_date')
                                          ->where('payment_status', 'Paid')
                                          ->count();

        $unpaid = BookingPayment::where('due_date','<=', $now)
                                 ->whereNull('payment_date')
                                 ->where('payment_status', 'Unpaid')
                                 ->sum('total_paid');

        $paid = BookingPayment::where('due_date','<=', $now)
                                     ->whereNotNull('payment_date')
                                     ->where('payment_status', 'Paid')
                                     ->sum('total_paid');


        return view('dashboard::index',[
            'page' => $this,
            'document' => $document,
            'akad_kpr' => $akad_kpr,
            'ajb' => $ajb,
            'handover' => $handover,
            'installment_pending' => $installment_pending,
            'installment_paid' => $installment_paid,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('dashboard::create');
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
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('dashboard::edit');
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
}

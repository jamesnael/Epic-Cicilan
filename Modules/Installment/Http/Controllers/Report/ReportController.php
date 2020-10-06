<?php

namespace Modules\Installment\Http\Controllers\Report;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Exports\InstallmentReport;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\PPJB;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('report.index'), 'text' => 'Laporan'],
        ];
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('installment::report.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('installment::report.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

    function convertDateIn($string)
    {
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
     
        $tanggal = explode(" ", $string)[0];
        $bulan = sprintf('%02d', array_search(explode(" ", $string)[1], $bulanIndo));
        $tahun = explode(" ", $string)[2];
     
        return $tahun . "-" . $bulan . "-" . $tanggal;
    }

    public function store(Request $request)
    {
        $from_date  = $this->convertDateIn($request->from_date);
        $until_date = $this->convertDateIn($request->until_date);
        $date_now   = \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y');

        if ($request->nama_laporan == "Pembayaran Cicilan")
        {
            // Status All
            if ($request->status == "All") {
                // Sales Status
                if (!empty($request->user_name)) {
                    $data = Booking::with('client','unit','payments','sales', 'agency', 'regional_coordinator', 'sales.user')->where('sales_id', $request->user_name)->whereBetween('created_at', [$from_date, $until_date])->orderBy('created_at', 'DESC')->get();
                } else {
                    $data = Booking::with('client','unit','payments','sales', 'agency', 'regional_coordinator', 'sales.user')->whereBetween('created_at', [$from_date, $until_date])->orderBy('created_at', 'DESC')->get();
                }

            // Status Lunas
            } elseif ($request->status == "Lunas") {
                // Sales Status
                if (!empty($request->user_name)) {
                    $data = Booking::doesnthave('unpaid_payments')->with('client','unit','payments','sales', 'agency', 'regional_coordinator', 'sales.user')->where('sales_id', $request->user_name)->whereBetween('created_at', [$from_date, $until_date])->orderBy('created_at', 'DESC')->get();
                } else {
                    $data = Booking::doesnthave('unpaid_payments')->with('client','unit','payments','sales', 'agency', 'regional_coordinator', 'sales.user')->whereBetween('created_at', [$from_date, $until_date])->orderBy('created_at', 'DESC')->get();
                }

            // Status Belum Lunas
            } elseif ($request->status == "Belum Lunas") {
                // Sales Status
                if (!empty($request->user_name)) {
                    $data = Booking::has('unpaid_payments')->with('client','unit','payments','sales', 'agency', 'regional_coordinator', 'sales.user')->where('sales_id', $request->user_name)->whereBetween('created_at', [$from_date, $until_date])->orderBy('created_at', 'DESC')->get();
                } else {
                    $data = Booking::has('unpaid_payments')->with('client','unit','payments','sales', 'agency', 'regional_coordinator', 'sales.user')->whereBetween('created_at', [$from_date, $until_date])->orderBy('created_at', 'DESC')->get();
                }
            }

            $max_installment = $data->max('installment_time');
            // return view('installment::report.report', ['data' => $data, 'from_date' => $from_date, 'until_date' => $until_date , 'max_installment' => $max_installment]);
            return (new InstallmentReport($data, $from_date, $until_date, $max_installment))->download('Laporan Pembayaran Cicilan - '. $date_now. '.xlsx');
        } else {
            return response_json(false, 'Error!!', 'Laporan hanya untuk Pemebayaran Cicilan untuk sementara');
        }
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
        return view('installment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
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

    //Helper
    public function getHelper()
    {
        return [
            'sales' => Sales::with('user','agency', 'main_coordinator', 'regional_coordinator')->get()->transform(function($item){
                $item->value = $item->id;
                $item->text = $item->user->full_name;
                $item->agency_name = $item->agency->agency_name ?? '';
                $item->regional_coordinator = $item->regional_coordinator->full_name ?? '';
                $item->main_coordinator = $item->main_coordinator->full_name ?? '';
                return $item->only(['value', 'text', 'agency_name', 'regional_coordinator', 'main_coordinator']);
            }),
            'client' => Client::select('id AS value', 'client_name AS text', 'client_number', 'client_email', 'client_address', 'client_phone_number', 'client_mobile_number')->get(),
        ];
    }
}

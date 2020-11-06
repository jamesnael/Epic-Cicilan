<?php

namespace Modules\Installment\Http\Controllers\Installment;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Modules\Installment\Entities\BookingPayment;
use Modules\Core\Entities\PaymentMethod;
use PDF;

class InstallmentUnitController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'])->except(['data']);
        $this->middleware('is-allowed')->only(['index', 'create', 'edit', 'destroy']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('installment.index'), 'text' => 'Data Pembayaran Cicilan'],
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
                "text" => 'ID Klien',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_number',
            ],
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_name',
            ],
            [
                "text" => 'Tipe Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit.unit_type',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Nama Cluster',
                "align" => 'center',
                "sortable" => false,
                "value" => 'cluster_name',
            ],
     
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'total_amount',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_type',
            ],
            [
                "text" => 'Cicilan Per Bulan',
                "align" => 'center',
                "sortable" => false,
                "value" => 'installment',
            ],
            [
                "text" => 'Tgl Jatuh Tempo',
                "align" => 'center',
                "sortable" => false,
                "value" => 'due_date',
            ],
            [
                "text" => 'Status',
                "align" => 'center',
                "sortable" => false,
                "value" => 'status',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sales_name',
            ],
        ];

        $this->table_headers_lunas = [
            [
                "text" => 'ID Klien',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_number',
            ],
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_name',
            ],
            [
                "text" => 'Tipe Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit.unit_type',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Nama Cluster',
                "align" => 'center',
                "sortable" => false,
                "value" => 'cluster_name',
            ],
     
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'total_amount',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_type',
            ],
            [
                "text" => 'Cicilan Per Bulan',
                "align" => 'center',
                "sortable" => false,
                "value" => 'installment',
            ],
            [
                "text" => 'Tgl Jatuh Tempo',
                "align" => 'center',
                "sortable" => false,
                "value" => 'due_date',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sales_name',
            ],
        ];
        return view('installment::installment-unit.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Booking $installment_unit)
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
            ],
            [
                "text" => 'Aksi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'actions',
            ],
        ];
        
        $this->breadcrumbs[] = ['href' => route('installment-unit.index'), 'text' => 'Detail Cicilan'];

        return view('installment::installment-unit.edit',[
            'page' => $this,
            'data' => $installment_unit,
            'table_headers' => $table_headers,
        ])->with($this->getHelper());
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Responsec
     */
    public function editLunas(Booking $installment_unit)
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
        $this->breadcrumbs[] = ['href' => route('installment-unit.index', [$installment_unit->slug]), 'text' => 'Detail Booking ' . ''];

        return view('installment::installment-unit.show', [
            'page' => $this,
            'data' => $installment_unit,
            'table_headers' => $table_headers,

        ])->with($this->getHelper());
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
                        return $item->only(['value', 'text', 'agency_name', 'regional_coordinator', 'main_coordinator']);
                    }),
            'client' => Client::select('id AS value', 'client_name AS text', 'client_number', 'client_email', 'client_address', 'client_phone_number', 'client_mobile_number')->get(),
            'payment_method' => PaymentMethod::select('id AS value', 'name AS text')->get(),
        ];
    }

    /**
     *
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $installment_unit)
    {
        $data = $installment_unit->load('unit','client','sales','payments','sales.user','sales.main_coordinator', 'sales.agency', 'sales.regional_coordinator');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
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
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $value)
    {
        return Validator::make($request->all(), [
            "total_paid" => "bail|required|numeric|size:".$value,
            "payment_date" => "bail|required",
            "payment_method" => "bail|required",
            "description" => "bail|nullable",
        ],[
            "total_paid.size" => "Jumlah pembayaran tidak sesuai."
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function payment(Request $request, Booking $installment_unit, BookingPayment $payment)
    {
        $validator = $this->validateFormRequest($request, $payment->installment + ($payment->fine * $payment->number_of_delays));

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'payment_status' => 'Paid',
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'total_paid' => $request->total_paid,
                'description' => $request->description,
            ]);
        
            $booking = $payment->booking;

            if (count($booking->akad_kredit_payments) == 1) {
                if (count($booking->unpaid_payments) == 0) {

                    if ($booking->booking_status == 'cicilan') {
                        $booking->booking_status = $booking->payment_type == 'KPR/KPA' ? 'akad' : 'ajb_handover';
                        $booking->save();
                    }else{
                        $booking->booking_status = 'ajb_handover';
                        $booking->save();
                    }

                }
            }else{
                if (count($booking->unpaid_payments) == 0) {

                    if ($booking->booking_status == 'cicilan') {
                        $booking->booking_status = $booking->payment_type == 'KPR/KPA' ? 'akad' : 'ajb_handover';
                        $booking->save();
                    }else{
                        $booking->booking_status = 'ajb_handover';
                        $booking->save();
                    }

                }
            }
            activity()
                 ->performedOn($installment_unit)
                 ->causedBy(\Auth::user())
                 ->log(' Pembayaran cicilan berhasil di buat');

            DB::commit();
            return response_json(true, null, 'Data pembayaran cicilan berhasil disimpan.', $payment);
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
        $user = \Auth::user();

        if ($user->is_admin == '1' || $user->status == 'koordinator_utama') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster')
                            ->whereIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'koordinator_wilayah') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster','regional_coordinator')
                            ->whereIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->whereHas('regional_coordinator', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sub_agent') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster','agency')
                            ->whereIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->whereHas('agency', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sales') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster','sales')
                            ->whereIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->whereHas('sales', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }else{
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster')
                            ->whereIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->orderBy('created_at', 'DESC');
        }


        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('point', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('client_number', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_type', 'LIKE', '%'.$generalSearch.'%');
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->whereIn('booking_status',['cicilan','cicilan_sp3k'])->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            date_default_timezone_set('Asia/Jakarta');
            $now      = \Carbon\Carbon::now()->format('m');
            $year_now = \Carbon\Carbon::now()->format('Y');
            $date_now = \Carbon\Carbon::now()->format('Y-m-d');
            $payments = BookingPayment::where('booking_id', $item->id)->where('payment_status', 'Unpaid')->whereNotIn('payment', ['UTJ + NUP', 'Akad Kredit'])->first();
            if ($payments) {
                $count_due_date = \Carbon\Carbon::parse(date('Y-m-d'))->diffInDays(\Carbon\Carbon::parse($payments->due_date),false);
                if ($count_due_date < 30)
                {
                    if ($payments->notification_mail_sp1 == 1) {
                        $status = 'SP 1';
                    } else if ($payments->notification_mail_sp2 == 1 && $payments->notification_mail_sp1 == 1) {
                        $status = 'SP 2';
                    } else if ($payments->notification_mail_sp3 == 1 && $payments->notification_mail_sp2 == 1 && $payments->notification_mail_sp1 == 1) {
                        $status = 'SP 3';
                    } else {
                        $late_payment = \Carbon\Carbon::parse($payments->due_date)->diffInDays(\Carbon\Carbon::now()->format('Y-m-d'),false);
                        if ($late_payment > 0) {
                            $status = "Telat bayar";
                        } else {
                            $status = "Belum dibayar";
                        }
                    }
                } else {
                    $status = "Sudah dibayar";
                }
            } else {
                $status = "Sudah dibayar";
            }
            $item->status = $status;
            $item->client_number = $item->client->client_number;
            $item->client_name = $item->client->client_name;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block;
            $item->total_amount ='Rp '.format_money($item->total_amount);
            $item->payment_type = $item->payment_type;
            $item->dp_amount = 'Rp '.format_money($item->dp_amount);
            $item->installment = 'Rp '.format_money($item->installment);
            $item->sales_name = $item->sales->user->full_name;
            $item->cluster_name = $item->unit->point->cluster->cluster_name ?? '';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormCancelRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "reject_reason" => "bail|required",
        ],[
            "reject_reason.required" => "Alasan pembatalan harus diisi."
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function cancelInstallment(Request $request, Booking $installment_unit)
    {
        $validator = $this->validateFormCancelRequest($request);
        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }
        
        DB::beginTransaction();
        try {

            $request->merge(['booking_status' => 'cicilan_cancel']);
            
            $data = $installment_unit->update($request->all());
            

            DB::commit();
            return response_json(true, null, 'Data cicilan berhasil dibatalkan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
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
    public function getTableDataLunas(Request $request)
    {
        $user = \Auth::user();

        if ($user->is_admin == '1' || $user->status == 'koordinator_utama') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster')
                            ->doesntHave('unpaid_payments')
                            ->whereNotIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'koordinator_wilayah') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster','regional_coordinator')
                            ->doesntHave('unpaid_payments')
                            ->whereNotIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->whereHas('regional_coordinator', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sub_agent') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster','agency')
                            ->doesntHave('unpaid_payments')
                            ->whereNotIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->whereHas('agency', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sales') {
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster','sales')
                            ->doesntHave('unpaid_payments')
                            ->whereNotIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->whereHas('sales', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }else{
            $query = Booking::with('client','unit','payments','sales.user','unit.point.cluster')
                            ->doesntHave('unpaid_payments')
                            ->whereNotIn('booking_status',['cicilan','cicilan_sp3k'])
                            ->orderBy('created_at', 'DESC');
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('point', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('client_number', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_type', 'LIKE', '%'.$generalSearch.'%');
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->whereNotIn('booking_status',['cicilan','cicilan_sp3k'])->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_number = $item->client->client_number;
            $item->client_name = $item->client->client_name;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block;
            $item->total_amount ='Rp '.format_money($item->total_amount);
            $item->payment_type = $item->payment_type;
            $item->dp_amount = 'Rp '.format_money($item->dp_amount);
            $item->installment = 'Rp '.format_money($item->installment);
            $item->sales_name = $item->sales->user->full_name;
            $item->cluster_name = $item->unit->point->cluster->cluster_name ?? '';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableLunas(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataLunas($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function print_receipt(BookingPayment $installment_unit)
    {
        // return view('installment::installment-unit.receipt', ['data' => $installment_unit]);
        $date = \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y');
        $pdf  = PDF::loadView('installment::installment-unit.receipt', ['data' => $installment_unit])->setPaper('a5', 'landscape')->setWarnings(false);
        return $pdf->download('Payment Receipt ' . $installment_unit->booking->client->client_name . '.pdf');
    }
}

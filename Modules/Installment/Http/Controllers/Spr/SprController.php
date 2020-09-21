<?php

namespace Modules\Installment\Http\Controllers\Spr;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\Installment\Entities\Spr;
use Modules\RewardPoint\Entities\RecordPoint;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PDF;

class SprController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('is-allowed')->only(['index', 'create', 'edit', 'destroy']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('spr.index'), 'text' => 'Data SPR'],
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
                "value" => 'unit_name',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales_name',
            ],
            [
                "text" => 'Tanggal Cetak',
                "align" => 'center',
                "sortable" => true,
                "value" => 'print_date',
            ],
            [
                "text" => 'Tanggal Kirim',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sent_date',
            ],
            [
                "text" => 'Tanggal Terima',
                "align" => 'center',
                "sortable" => true,
                "value" => 'received_date',
            ],
            [
                "text" => 'Status',
                "align" => 'center',
                "sortable" => true,
                "value" => 'status',
            ],
        ];

        $this->table_headers_2 = [
            [
                "text" => 'Nama Klien',
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
                "value" => 'unit_name',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales_name',
            ],
            [
                "text" => 'Tanggal Cetak',
                "align" => 'center',
                "sortable" => true,
                "value" => 'print_date',
            ],
            [
                "text" => 'Tanggal Kirim',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sent_date',
            ],
            [
                "text" => 'Tanggal Terima',
                "align" => 'center',
                "sortable" => true,
                "value" => 'received_date',
            ],
            [
                "text" => 'Status',
                "align" => 'center',
                "sortable" => true,
                "value" => 'status',
            ],
        ];
        return view('installment::spr.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('spr.index'), 'text' => 'Tambah SPR'];

        return view('installment::spr.create', [
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
    public function edit(Booking $spr)
    {
        $this->breadcrumbs[] = ['href' => route('spr.index'), 'text' => 'Edit SPR'];

        return view('installment::spr.edit',[
            'page' => $this,
            'data' => $spr,
        ])->with($this->getHelper());
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function print(Booking $spr)
    {
        // return view('installment::spr.print', ['data' => $spr]);
        $date = date('d F Y');
        $pdf  = PDF::loadView('installment::spr.print', ['data' => $spr, 'date' => $date])->setPaper('a4', 'portrait');
        return $pdf->download('Surat Pemesanan Unit ' . $spr->client->client_name . '.pdf');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Booking $spr)
    {
        $validator = $this->validateFormRequest($request);
        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        if ($request->sent_date == 'null') {
            $sent_date = null;
        } else {
            $sent_date = $request->sent_date;
        }

        if ($request->received_date == 'null') {
            $received_date = null;
        } else {
            $received_date = $request->received_date;
        }
        DB::beginTransaction();
        try {
            if ($request->has('approval_status') && $request->input('approval_status') == 'Approved' && $spr->booking_status == 'spr') {
                $spr->booking_status = 'ppjb';
                $spr->save();

                //Insert Point
                $record = RecordPoint::Create([
                    'booking_id'   => $request->booking_id,
                    'point_status' => 'F',
                ]);
            }

            $has_spr = Spr::where('booking_id', $request->booking_id)->first();

            if ($has_spr) {
                 $data = $has_spr->update([
                    'booking_id'      => $request->booking_id,
                    'print_date'      => $request->print_date,
                    'approval_status' => $request->approval_status ? $request->approval_status : 'Pending',
                    'sent_date'       => $sent_date,
                    'received_date'   => $received_date,
                 ]);
            }else{
                $data = Spr::create([
                    'booking_id'      => $request->booking_id,
                    'print_date'      => $request->print_date,
                    'approval_status' => $request->approval_status ? $request->approval_status : 'Pending',
                    'sent_date'       => $sent_date,
                    'received_date'   => $received_date,
                ]);
            }

            DB::commit();
            return response_json(true, null, 'Data Surat Pemesanan Rumah berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
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

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "booking_id" => "bail|required",
        ]);
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
    public function cancelSpr(Request $request, Booking $spr)
    {
        $validator = $this->validateFormCancelRequest($request);
        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $request->merge(['booking_status' => 'spr_cancel']);
            
            $data = $spr->update($request->all());
            

            DB::commit();
            return response_json(true, null, 'Data Surat Pemesanan Rumah berhasil dibatalkan.', $data);
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
        $query = Booking::with('client', 'unit', 'spr', 'sales', 'sales.user')->bookingStatus('spr')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->whereHas('client', function($subquery) use ($generalSearch) {
                $subquery->where('client_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch) {
                $subquery->where('unit_type', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('unit_number', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('unit_block', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('sales.user', function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('spr', function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('print_date', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('sent_date', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('received_date', 'LIKE', '%' . $check_date . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }
        $data = $query->bookingStatus('spr')->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->print_date    = $item->spr ? \Carbon\Carbon::parse($item->spr->print_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->sent_date     = $item->spr ? ($item->spr->sent_date) != null ? \Carbon\Carbon::parse($item->spr->sent_date)->locale('id')->translatedFormat('d F Y') : '' : '';
            $item->unit_name     = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->received_date = $item->spr ? ($item->spr->received_date) != null ? \Carbon\Carbon::parse($item->spr->received_date)->locale('id')->translatedFormat('d F Y'): '' : '';
            $item->client_name   = $item->client->client_name;
            $item->sales_name    = $item->sales->user->full_name;

            //Status Condition
            if ($item->spr){
                if ($item->spr->print_date != null)
                {
                    if ($item->spr->print_date){
                        $item->status = "Dicetak";
                    }
                    if ($item->spr->sent_date){
                        $item->status = "Dikirim";
                    }
                    if ($item->spr->received_date){
                        $item->status = "Diterima";
                    }
                    if ($item->spr->approval_status == "Approved"){
                        $item->status = "Dokumen sesuai";
                    }
                }
            } else {
                $item->status = "Belum dicetak";
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
     * Query for get data for table
     *
     */
    public function getTableApprovedData(Request $request)
    {
        $query = Booking::with('client', 'unit', 'spr', 'sales', 'sales.user');
        $query->whereHas('spr', function($subquery) {
            $subquery->where('approval_status', 'Approved');
        });
        $query->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->whereHas('client', function($subquery) use ($generalSearch) {
                $subquery->where('client_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch) {
                $subquery->where('unit_type', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('unit_number', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('unit_block', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('sales.user', function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('spr', function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('print_date', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('sent_date', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('received_date', 'LIKE', '%' . $check_date . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }
        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->print_date    = $item->spr ? \Carbon\Carbon::parse($item->spr->print_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->sent_date     = $item->spr ? ($item->spr->sent_date) != null ? \Carbon\Carbon::parse($item->spr->sent_date)->locale('id')->translatedFormat('d F Y') : '' : '';
            $item->unit_name     = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->received_date = $item->spr ? ($item->spr->received_date) != null ? \Carbon\Carbon::parse($item->spr->received_date)->locale('id')->translatedFormat('d F Y'): '' : '';
            $item->client_name   = $item->client->client_name;
            $item->sales_name    = $item->sales->user->full_name;

            //Status Condition
            if ($item->spr){
                if ($item->spr->print_date != null)
                {
                    if ($item->spr->print_date){
                        $item->status = "Dicetak";
                    }
                    if ($item->spr->sent_date){
                        $item->status = "Dikirim";
                    }
                    if ($item->spr->received_date){
                        $item->status = "Diterima";
                    }
                    if ($item->spr->approval_status == "Approved"){
                        $item->status = "Dokumen sesuai";
                    }
                }
            } else {
                $item->status = "Belum dicetak";
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
    public function tableApproved(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableApprovedData($request));
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
    public function data(Booking $spr)
    {
        $data = $spr->load('unit','client', 'spr','sales.user');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

}

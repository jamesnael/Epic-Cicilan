<?php

namespace Modules\Installment\Http\Controllers\HandOver;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\HandOver;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Modules\SalesAgent\Entities\Agency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Installment\Entities\BookingPayment;
use Illuminate\Support\Facades\Notification;
use Modules\Installment\Notifications\ReminderHandover;

class HandOverController extends Controller
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
            ['href' => route('handover.index'), 'text' => 'Data Serah Terima Unit'],
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
                "sortable" => false,
                "value" => 'client_name',
            ],
            [
                "text" => 'No. Handphone',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_mobile_number',
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
                "value" => 'unit_name',
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
                "value" => 'unit_price',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_method',
            ],
            [
                "text" => 'Tgl AJB',
                "align" => 'center',
                "sortable" => false,
                "value" => 'ajb_date',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sales_name',
            ],
            [
                "text" => 'Sub Agent',
                "align" => 'center',
                "sortable" => false,
                "value" => 'agency_name',
            ],
        ];
        $this->table_headers_2 = [
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_name',
            ],
            [
                "text" => 'No. Handphone',
                "align" => 'center',
                "sortable" => false,
                "value" => 'client_mobile_number',
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
                "value" => 'unit_name',
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
                "value" => 'unit_price',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_method',
            ],
            [
                "text" => 'Tgl AJB',
                "align" => 'center',
                "sortable" => false,
                "value" => 'ajb_date',
            ],
            [
                "text" => 'Nomor BAST',
                "align" => 'center',
                "sortable" => false,
                "value" => 'handover.no_bast',
            ],
            [
                "text" => 'Nama Petugas',
                "align" => 'center',
                "sortable" => false,
                "value" => 'handover.nama_petugas',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sales_name',
            ],
            [
                "text" => 'Sub Agent',
                "align" => 'center',
                "sortable" => false,
                "value" => 'agency_name',
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
        $this->breadcrumbs[] = ['href' => route('handover.index'), 'text' => 'Tambah Schedule Serah Terima Unit'];

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
    public function edit(Booking $handover)
    {
        $this->breadcrumbs[] = ['href' => route('handover.index'), 'text' => 'Input Jadwal Serah Terima Unit'];

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
        $validator = $this->validateFormRequest($request);
        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($request->hasFile('file_upload')) {
                $file_name = 'serah-terima-' . uniqid() . '.' . $request->file('file_upload')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('handover/handover_doc_file_names', $request->file('file_upload'), $file_name
                );
                $request->merge([
                    'handover_doc_file_name' => $file_name,
                ]);
            }

            if ($request->hasFile('sign_upload')) {
                $file_name = 'signed_serah-terima-' . uniqid() . '.' . $request->file('sign_upload')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('handover/handover_doc_sign_names', $request->file('sign_upload'), $file_name
                );
                $request->merge([
                    'handover_doc_sign_name' => $file_name,
                ]);

                Notification::route('mail', $handover->client->client_email)
                            ->notify(new ReminderHandover($handover));
            }
            $has_handover = HandOver::where('booking_id', $request->booking_id)->first();
            if ($has_handover) {
                $data = $has_handover->update($request->all());
                 activity()
                 ->performedOn($handover)
                 ->causedBy(\Auth::user())
                 ->log('Handover berhasil diubah');
            }else{
                $data = HandOver::create($request->all());
                 activity()
                 ->performedOn($handover)
                 ->causedBy(\Auth::user())
                 ->log('Handover baru berhasil dibuat');
            }

            DB::commit();
            return response_json(true, null, 'Data Handover berhasil disimpan.', $data);
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
        // $query = Booking::has('ajb')->bookingStatus('ajb_handover')->with('client', 'unit', 'handover', 'sales', 'ajb', 'payments');
        $query = Booking::bookingStatus('ajb_handover')->with('client', 'unit', 'handover', 'sales', 'ajb', 'payments','unit.point.cluster');
        $query->whereDoesntHave('handover', function($subquery) {
            $subquery->where('approval_client_status', '=', 'Disetujui');
            $subquery->where('approval_developer_status', '=', 'Disetujui');
            $subquery->where('approval_notaris_status', '=', 'Disetujui');
            $subquery->where('handover_doc_sign_name', '!=', '');
        });
        $query->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('client_mobile_number', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
            });

            $query->orWhereHas('ajb', function($subquery) use ($generalSearch){
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                } 

                $subquery->where('ajb_date', 'LIKE', '%'.$check_date.'%');
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }
        $data = $query->bookingStatus('ajb_handover')->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->unit_name            = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price           = 'Rp '.format_money($item->total_amount);
            $item->payment_method       = $item->payment_method;
            $item->ajb_date             = $item->ajb ? ($item->ajb->ajb_date) != null ? \Carbon\Carbon::parse($item->ajb->ajb_date)->locale('id')->translatedFormat('d F Y'): '' : '';
            $item->client_name          = $item->client->client_name;
            $item->agency_name          = $item->sales->agency ? $item->sales->agency->agency_name : '';
            $item->client_mobile_number = $item->client->client_mobile_number;
            $item->sales_name           = $item->sales->user->full_name;
            $item->cluster_name         = $item->unit->point->cluster->cluster_name ?? '';
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

    public function getTableDataApproved(Request $request)
    {
        // $query = Booking::has('ajb')->bookingStatus('ajb_handover')->with('client', 'unit', 'handover', 'sales', 'ajb', 'payments');
        $query = Booking::bookingStatus('ajb_handover')->with('client', 'unit', 'handover', 'sales', 'ajb', 'payments','unit.point.cluster');
        $query->whereHas('handover', function($subquery) {
            $subquery->where('approval_client_status', 'Disetujui');
            $subquery->where('approval_developer_status', 'Disetujui');
            $subquery->where('approval_notaris_status', 'Disetujui');
            $subquery->where('handover_doc_sign_name', '!=', '');
        });
        $query->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('client_mobile_number', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
            });

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
            });

            $query->orWhereHas('ajb', function($subquery) use ($generalSearch){
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                } 

                $subquery->where('ajb_date', 'LIKE', '%'.$check_date.'%');
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }
        $data = $query->bookingStatus('ajb_handover')->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->unit_name            = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price           = 'Rp '.format_money($item->total_amount);
            $item->payment_method       = $item->payment_method;
            $item->ajb_date             = $item->ajb ? ($item->ajb->ajb_date) != null ? \Carbon\Carbon::parse($item->ajb->ajb_date)->locale('id')->translatedFormat('d F Y'): '' : '';
            $item->client_name          = $item->client->client_name;
            $item->agency_name          = $item->sales->agency ? $item->sales->agency->agency_name : '';
            $item->client_mobile_number = $item->client->client_mobile_number;
            $item->sales_name           = $item->sales->user->full_name;
            $item->cluster_name         = $item->unit->point->cluster->cluster_name ?? '';
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
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataApproved($request));
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
        $data = $handover->load('unit', 'client', 'handover', 'sales.agency', 'sales.user', 'sales.main_coordinator' , 'sales.regional_coordinator','payments', 'ajb');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

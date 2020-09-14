<?php

namespace Modules\Installment\Http\Controllers\Akad;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\Installment\Entities\AkadKpr;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AkadController extends Controller
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
            ['href' => route('akad.index'), 'text' => 'Data Akad'],
        ];
    }

    /**
     * Instantiate a new controller instance.
     *
     * @return void
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
                "text" => 'Data Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_price',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'payment_method',
            ],
            [
                "text" => 'Sales',
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
                "text" => 'Approval Pembeli',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_client',
            ],
            [
                "text" => 'Approval Bank',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_bank',
            ],
            [
                "text" => 'Approval Developer',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_developer',
            ],
        ];

        $this->table_headers_approved = [
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
            ],
            [
                "text" => 'Data Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Harga Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_price',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'payment_method',
            ],
            [
                "text" => 'Sales',
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
                "text" => 'Approval Pembeli',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_client',
            ],
            [
                "text" => 'Approval Bank',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_bank',
            ],
            [
                "text" => 'Approval Developer',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_developer',
            ],
        ];

        return view('installment::akad.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Booking $akad)
    {
        $this->breadcrumbs[] = ['href' => route('document.index'), 'text' => 'Edit Akad'];

        return view('installment::akad.edit',[
            'page' => $this,
            'data' => $akad,
        ])->with($this->getHelper());
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "booking_id" => "bail|required|exists:Modules\Installment\Entities\Booking,id",
            "akad_date" => "bail|required",
            "akad_time" => "bail|required",
            "dokumen_awal" => "bail|nullable",
            "location" => "bail|required|string|max:255",
            "address" => "bail|nullable|string|max:255",
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Booking $akad)
    {
        // return $request->hasFile('dokumen_awal');
        $validator = $this->validateFormRequest($request, $akad->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

            if ($request->hasFile('dokumen_awal')) {
                $file_name = 'akad_kpr_awal-' . uniqid() . '.' . $request->file('dokumen_awal')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('akad_kpr/dokumen_awal', $request->file('dokumen_awal'), $file_name
                );

                $request->merge([
                    'akad_doc_file_name' => $file_name,
                ]);
            }

            if ($request->hasFile('dokumen_akhir')) {
                $file_name_akhir = 'akad_kpr_akhir-' . uniqid() . '.' . $request->file('dokumen_akhir')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('akad_kpr/dokumen_akhir', $request->file('dokumen_akhir'), $file_name_akhir
                );

                $request->merge([
                    'akad_doc_sign_file_name' => $file_name_akhir,
                ]);
            }

            if ($akad->akad_kpr) {
                $data = AkadKpr::where('booking_id', $request->booking_id)->update($request->only(['booking_id', 'akad_date', 'akad_time', 'location', 'address','akad_doc_file_name','akad_doc_sign_file_name', 'approval_client_status', 'approval_notaris_status', 'approval_developer_status']));
            }else{
                $data = AkadKpr::create($request->all());
            }

            if ($request->input('approval_client_status') == 'Approved' && $request->input('approval_notaris_status') == 'Approved' && $request->input('approval_developer_status') == 'Approved' && $request->has('akad_doc_sign_file_name')) {
                $akad->booking_status = 'ajb_handover';
                $akad->save();
            }


            DB::commit();
            return response_json(true, null, 'Data Akad KPR berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $akad)
    {
        $data = $akad->load('unit','client', 'sales.agency', 'sales.main_coordinator', 'sales.regional_coordinator', 'sales.user','akad_kpr','ppjb');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

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
        $query = Booking::has('payments')->has('ppjb')->doesntHave('unpaid_payments')->kprKpa()->bookingStatus('akad')->with('client', 'unit', 'sales', 'akad_kpr','payments','ppjb');

        $query->whereHas('akad_kpr', function($subquery) {
            $subquery->where('akad_doc_sign_file_name', NULL);
        })->orderBy('created_at', 'DESC');


        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
            });


            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_type', 'LIKE', '%'.$generalSearch.'%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->has('payments')->has('ppjb')->doesntHave('unpaid_payments')->kprKpa()->bookingStatus('akad')->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_name = $item->client->client_name;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->sales_name = $item->sales->user->full_name ?? '';
            $item->agency_name = $item->sales->agency->agency_name ?? '';
            $item->approved_client = $item->akad_kpr->approval_client_status ?? '';
            $item->approved_bank = $item->akad_kpr->approval_notaris_status ?? '';
            $item->approved_developer = $item->akad_kpr->approval_developer_status ?? '';
            $item->sisa_tunggakan = $item->sisa_tunggakan;
            
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
    public function getTableDataApproved(Request $request)
    {
        $query = Booking::has('payments')->doesntHave('unpaid_payments')->kprKpa()->bookingStatus('ajb_handover')->with('client', 'unit', 'sales', 'ajb');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
            });


            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
            });

            $query->orWhereHas('unit', function($subquery) use ($generalSearch){
                $subquery->where('unit_number', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_block', 'LIKE', '%'.$generalSearch.'%');
                $subquery->orWhere('unit_type', 'LIKE', '%'.$generalSearch.'%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->has('payments')->doesntHave('unpaid_payments')->bookingStatus('ajb_handover')->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_name = $item->client->client_name;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->sales_name = $item->sales->user->full_name ?? '';
            $item->agency_name = $item->sales->agency->agency_name ?? '';
            $item->approved_client = $item->akad_kpr->approval_client_status ?? '';
            $item->approved_bank = $item->akad_kpr->approval_notaris_status ?? '';
            $item->approved_developer = $item->akad_kpr->approval_developer_status ?? '';
            $item->sisa_tunggakan = $item->sisa_tunggakan;
            
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
}

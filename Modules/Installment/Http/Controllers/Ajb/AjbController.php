<?php

namespace Modules\Installment\Http\Controllers\Ajb;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\Installment\Entities\AkteJualBeli;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AjbController extends Controller
{
    public function __construct()
    {
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('ajb.index'), 'text' => 'Data AJB'],
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
                "text" => 'No. Handphone',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_phone_number',
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
                "text" => 'Approved Pembeli',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_client',
            ],
            [
                "text" => 'Approved Developer',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_developer',
            ],
            [
                "text" => 'Approved Notaris',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approved_bank',
            ],
        ];
        return view('installment::ajb.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Booking $ajb)
    {
        $this->breadcrumbs[] = ['href' => route('document.index'), 'text' => 'Edit AJB'];

        return view('installment::ajb.edit',[
            'page' => $this,
            'data' => $ajb,
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
            "ajb_date" => "bail|required",
            "ajb_time" => "bail|required",
            "dokumen_awal" => "bail|nullable|image",
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
    public function update(Request $request, Booking $ajb)
    {
        $validator = $this->validateFormRequest($request, $ajb->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

            if ($request->hasFile('dokumen_awal')) {
                $file_name = 'ajb_awal-' . uniqid() . '.' . $request->file('dokumen_awal')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('ajb/dokumen_awal', $request->file('dokumen_awal'), $file_name
                );

                $request->merge([
                    'ajb_doc_file_name' => $file_name,
                ]);
            }

            if ($request->hasFile('dokumen_akhir')) {
                $file_name_akhir = 'ajb_akhir-' . uniqid() . '.' . $request->file('dokumen_akhir')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('ajb/dokumen_akhir', $request->file('dokumen_akhir'), $file_name_akhir
                );

                $request->merge([
                    'ajb_doc_sign_file_name' => $file_name_akhir,
                ]);
            }

            if ($ajb->ajb) {
                $data = AkteJualBeli::where('booking_id', $request->booking_id)->update($request->only(['booking_id', 'ajb_date', 'ajb_time', 'location', 'address','ajb_doc_file_name','ajb_doc_sign_file_name', 'approval_client_status', 'approval_notaris_status', 'approval_developer_status']));
            }else{
                $data = AkteJualBeli::create($request->all());
            }


            DB::commit();
            return response_json(true, null, 'Data AJB berhasil disimpan.', $data);
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
    public function data(Booking $ajb)
    {
        $data = $ajb->load('unit','client', 'sales.agency', 'sales.main_coordinator', 'sales.regional_coordinator', 'sales.user','ajb');
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
        $query = Booking::has('payments')->doesntHave('unpaid_payments')->with('client', 'unit', 'sales', 'ajb')->orderBy('created_at', 'DESC');

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
            $item->client_name = $item->client->client_name;
            $item->client_phone_number = $item->client->client_phone_number;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->sales_name = $item->sales->user->full_name ?? '';
            $item->agency_name = $item->sales->agency->agency_name ?? '';
            $item->approved_client = $item->ajb->approval_client_status ?? '';
            $item->approved_bank = $item->ajb->approval_notaris_status ?? '';
            $item->approved_developer = $item->ajb->approval_developer_status ?? '';
            
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
}

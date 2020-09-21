<?php

namespace Modules\Installment\Http\Controllers\PPJB;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\PPJB;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PPJBController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('is-allowed')->only(['index', 'create', 'edit', 'destroy']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('PPJB.index'), 'text' => 'Daftar PPJB'],
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
                "value" => 'unit_price',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => true,
                "value" => 'payment_method',
            ],
            [
                "text" => 'Tanggal Pengajuan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'ppjb_date',
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
                "text" => 'Tanggal Tanda tangan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'ppjb_sign_date',
            ],
            [
                "text" => 'Approved Pembeli',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approval_client_status',
            ],
            [
                "text" => 'Approved Developer',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approval_developer_status',
            ],
            [
                "text" => 'Approved Notaris',
                "align" => 'center',
                "sortable" => true,
                "value" => 'approval_notaris_status',
            ],
        ];
        return view('installment::PPJB.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('PPJB.index'), 'text' => 'Input Jadwal PPJB'];

        return view('installment::PPJB.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
     
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
     * @return Response
     */
    

    public function edit(Booking $PPJB)
    {
        $this->breadcrumbs[] = ['href' => route('PPJB.index'), 'text' => 'Edit PPJB'];

        return view('installment::PPJB.edit',[
            'page' => $this,
            'data' => $PPJB,
        ])->with($this->getHelper());
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Booking $PPJB)
    { 

        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

              if ($request->hasFile('file_upload')) {
                $file_name_doc = 'ppjbDocument-'.uniqid().'.'.$request->file('file_upload')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('ppjb/suratPPJBAwal', $request->file('file_upload'), $file_name_doc
                );
                $request->merge([
                    'ppjb_doc_file_name' => $file_name_doc,
                ]);
          }
           
           if ($request->hasFile('sign_upload')) {
                $file_name_doc_sign = 'ppjbDocumentSigned-'.uniqid().'.'.$request->file('sign_upload')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('ppjb/suratPPJBSigned', $request->file('sign_upload'), $file_name_doc_sign
                );
                 $request->merge([
                    'ppjb_doc_sign_file_name' => $file_name_doc_sign,
                ]);
          }



            if ($request->has('approval_client_status') && $request->input('approval_client_status') == 'Approved'
                && $request->has('approval_developer_status') && $request->input('approval_developer_status') == 'Approved'
                && $request->has('approval_notaris_status') && $request->input('approval_notaris_status') == 'Approved') {
                $PPJB->booking_status = 'cicilan';
                $PPJB->save();
            }

            $request->merge([
                'ppjb_sign_date' => $request->ppjb_sign_date ? \Carbon\Carbon::parse($request->ppjb_sign_date)->format('Y-m-d') : '',
                'ppjb_date' => $request->ppjb_date ? \Carbon\Carbon::parse($request->ppjb_date)->format('Y-m-d') : '',
           
            ]);            


             $has_ppjb = PPJB::where('booking_id', $request->booking_id)->first();
            if ($has_ppjb) {
                $data = $has_ppjb->update($request->all());
            }else{
                $data = PPJB::create($request->all());
            }

           


            DB::commit();
            return response_json(true, null, 'Data PPJB berhasil disimpan.', $has_ppjb);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }


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
    public function cancelPpjb(Request $request, Booking $PPJB)
    {
        $validator = $this->validateFormCancelRequest($request);
        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }
        
        DB::beginTransaction();
        try {

            $request->merge(['booking_status' => 'ppjb_cancel']);
            
            $data = $PPJB->update($request->all());
            

            DB::commit();
            return response_json(true, null, 'Data PPJB berhasil dibatalkan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
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
        $query = Booking::has('ppjb')->with('client', 'unit', 'document','sales','sales.agency', 'ppjb');
        $query->whereHas('ppjb', function($subquery){ 
            $subquery->where('approval_client_status', '!=', 'Pending');
            $subquery->where('approval_developer_status', '!=', 'Pending');
            $subquery->where('approval_notaris_status', '!=', 'Pending');
            $subquery->where('ppjb_doc_sign_file_name', '!=', '');

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

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('agency', function($subquery2) use ($generalSearch){
                    $subquery2->where('agency_name', 'LIKE', '%'.$generalSearch.'%');
                });
            });

            $query->orWhereHas('document', function($subquery) use ($generalSearch){
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('submission_date', 'LIKE', '%' . $check_date . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_name = $item->client->client_name;
            $item->sales_name = $item->sales->user->full_name;
            $item->agency_name = $item->sales->agency->agency_name ?? '';
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->ppjb_sign_date = $item->ppjb ? \Carbon\Carbon::parse($item->ppjb->ppjb_sign_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->ppjb_date = $item->document ? \Carbon\Carbon::parse($item->document->submission_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->approval_notaris_status = $item->ppjb->approval_notaris_status ?? 'Pending' ;
            $item->approval_developer_status = $item->ppjb->approval_developer_status ?? 'Pending' ;
            $item->approval_client_status = $item->ppjb->approval_client_status ?? 'Pending' ;
            $item->ppjb_doc_file_name = $item->ppjb->ppjb_doc_file_name ?? '' ;
            return $item;
        });
        return $data;
    }

    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "booking_id" => "bail|required",
        ]);
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


  public function getTableDataPending(Request $request)
    {
        $query = Booking::has('spr')->with('client', 'unit', 'document','sales','sales.agency', 'ppjb')->bookingStatus('ppjb')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('payment_type', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('client', function($subquery) use ($generalSearch){
                $subquery->where('client_name', 'LIKE', '%'.$generalSearch.'%');
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

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('agency', function($subquery2) use ($generalSearch){
                    $subquery2->where('agency_name', 'LIKE', '%'.$generalSearch.'%');
                });
            });

            $query->orWhereHas('document', function($subquery) use ($generalSearch){
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('submission_date', 'LIKE', '%' . $check_date . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->bookingStatus('ppjb')->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_name = $item->client->client_name;
            $item->sales_name = $item->sales->user->full_name;
            $item->agency_name = $item->sales->agency->agency_name ?? '';
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->ppjb_sign_date = $item->ppjb ? \Carbon\Carbon::parse($item->ppjb->ppjb_sign_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->ppjb_date = $item->document ? \Carbon\Carbon::parse($item->document->submission_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->approval_notaris_status = $item->ppjb->approval_notaris_status ?? 'Pending' ;
            $item->approval_developer_status = $item->ppjb->approval_developer_status ?? 'Pending' ;
            $item->approval_client_status = $item->ppjb->approval_client_status ?? 'Pending' ;
            $item->ppjb_doc_file_name = $item->ppjb->ppjb_doc_file_name ?? '' ;
            return $item;
        });
        return $data;
    }



    public function pendingtable(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataPending($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }



    public function data(Booking $PPJB)
    {
        $data = $PPJB->load('unit','client','sales.user','sales.agency','document','ppjb');
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
                            $item->agency_name = $item->sales->agency->agency_name ?? '';
                            $item->regional_coordinator = $item->regional_coordinator->full_name ?? '';
                            $item->main_coordinator = $item->main_coordinator->full_name ?? '';
                            return $item->only(['value', 'text', 'agency_name', 'regional_coordinator', 'main_coordinator']);
                        }),
                'client' => Client::select('id AS value', 'client_name AS text', 'client_number', 'client_email', 'client_address', 'client_phone_number', 'client_mobile_number')->get(),
            ];
    }


}

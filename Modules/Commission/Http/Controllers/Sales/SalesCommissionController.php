<?php

namespace Modules\Commission\Http\Controllers\Sales;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Commission\Entities\Commission;
use Modules\Installment\Entities\Booking;
use Modules\RewardPoint\Entities\RecordPoint;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SalesCommissionController extends Controller
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
            ['href' => route('salescommission.index'), 'text' => 'Data Komisi Penjualan'],
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
                "text" => 'Nama Sales',
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
                "text" => 'Data Unit',
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
                "text" => 'Harga Pricelist',
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
                "text" => 'Komisi Bruto Sub Agent',
                "align" => 'center',
                "sortable" => false,
                "value" => 'bruto',
            ],
            [
                "text" => 'Total Komisi Sub Agent (PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'final',
            ],
            [
                "text" => 'Pencairan 1 (50%)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_status_1',
            ],
            [
                "text" => 'Pencairan 2 (50%)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_status_2',
            ],

        ];

        $this->table_headers_korwil = [
            [
                "text" => 'Nama Sales',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sales_name',
            ],
            [
                "text" => 'Koordinator Wilayah',
                "align" => 'center',
                "sortable" => false,
                "value" => 'korwil_name',
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
                "text" => 'Data Unit',
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
                "text" => 'Harga Pricelist',
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
                "text" => 'Komisi Bruto Koordinator Wilayah',
                "align" => 'center',
                "sortable" => false,
                "value" => 'bruto',
            ],
            [
                "text" => 'Total Komisi Koordinator Wilayah (PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'final',
            ],
            [
                "text" => 'Pencairan 1 (50%)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_status_1',
            ],
            [
                "text" => 'Pencairan 2 (50%)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_status_2',
            ],
            [
                "text" => 'Aksi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'actions',
            ],
        ];

        $this->table_headers_korut = [
            [
                "text" => 'Nama Sales',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sales_name',
            ],
            [
                "text" => 'Koordinator Utama',
                "align" => 'center',
                "sortable" => false,
                "value" => 'korut_name',
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
                "text" => 'Data Unit',
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
                "text" => 'Harga Pricelist',
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
                "text" => 'Komisi Bruto Koordinator Utama',
                "align" => 'center',
                "sortable" => false,
                "value" => 'bruto',
            ],
            [
                "text" => 'Total Komisi Koordinator Utama (PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'final',
            ],
            [
                "text" => 'Pencairan 1 (50%)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_status_1',
            ],
            [
                "text" => 'Pencairan 2 (50%)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_status_2',
            ],
            [
                "text" => 'Aksi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'actions',
            ],
        ];

        $this->table_headers_closingfee = [
            [
                "text" => 'Nama Sales',
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
            [
                "text" => 'Koordinator Wilayah',
                "align" => 'center',
                "sortable" => false,
                "value" => 'korut_name',
            ],
            [
                "text" => 'Koordinator Utama',
                "align" => 'center',
                "sortable" => false,
                "value" => 'korut_name',
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
                "text" => 'Data Unit',
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
                "text" => 'Harga Pricelist',
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
                "text" => 'Closing Fee Sales',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_sales',
            ],
            [
                "text" => 'Closing Fee Sub Agent',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_agent',
            ],
            [
                "text" => 'Closing Fee Koordinator Wilayah',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_korwil',
            ],
            [
                "text" => 'Closing Fee Koordinator Utama',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_korut',
            ],
            [
                "text" => 'Aksi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'actions',
            ],
        ];
        return view('commission::salescommission.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Tambah Komisi'];

        return view('commission::salescommission.create', [
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
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('commission::show');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Booking $salescommission)
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Edit Komisi Sub Agent'];

        return view('commission::salescommission.edit',[
            'page' => $this,
            'data' => $salescommission,
        ])->with($this->getHelper());
    }

     /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function editKorwil(Booking $salescommission)
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Edit Komisi Koordinator Wilayah'];

        return view('commission::salescommission.edit-korwil',[
            'page' => $this,
            'data' => $salescommission,
        ])->with($this->getHelper());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function editKorut(Booking $salescommission)
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Edit Komisi Koordinator Utama'];

        return view('commission::salescommission.edit-korut',[
            'page' => $this,
            'data' => $salescommission,
        ])->with($this->getHelper());
    }

     /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function editClosingFee(Booking $salescommission)
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Edit Komisi Sales'];

        return view('commission::salescommission.edit-closingfee',[
            'page' => $this,
            'data' => $salescommission,
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
            "closing_fee" => "bail|nullable|numeric",
            "agency_commission" => "bail|nullable|numeric",
            "closing_fee_sales" => "bail|nullable|numeric",
            "closing_fee_korwil" => "bail|nullable|numeric",
            "closing_fee_korut" => "bail|nullable|numeric",
            "closing_fee_agency" => "bail|nullable|numeric",
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Booking $salescommission)
    {
        $validator = $this->validateFormRequest($request, $salescommission->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

            if ($request->input('commission_1') && $request->input('payment_date_1')) {
                $salescommission->komisi_status = 'Pembayaran 1';
                $salescommission->save();

            }

            if ($request->input('commission_2') && $request->input('payment_date_2')) {
                
                //Update Status Point
                $point = RecordPoint::where('booking_id', $request->input('booking_id'))->first();
                if($point){
                    $point->point_status = 'T';
                    $point->save();
                }
                
                $salescommission->komisi_status = 'Pembayaran 2';
                $salescommission->save();

            }

            if ($request->input('closing_fee_sales') && $request->input('sales_payment_date') && $request->input('closing_fee_agency') && $request->input('agency_payment_date') && $request->input('closing_fee_korwil') && $request->input('korwil_payment_date') && $request->input('korut_name') && $request->input('korut_payment_date')) {

                //Update Status Point
                $point = RecordPoint::where('booking_id', $request->input('booking_id'))->first();
                if($point){
                    if($point->point_status == 'F'){
                        $point->point_status = 'T';
                        $point->save();
                    }
                }

                $salescommission->komisi_status = 'Closing Fee';
                $salescommission->save();

            }

            $data = $salescommission
                    ->commission()
                    ->updateOrCreate([
                        'booking_id' => $request->input('booking_id')
                    ], $request->all());

            if ($request->hasFile('payment_proof1')) {
                $file_name = 'komisi-agent-1-' . uniqid() . '.' . $request->file('payment_proof1')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('payment_proof1'), $file_name
                );

                $data->payment_proof_1 = $file_name;
            }

            if ($request->hasFile('payment_proof2')) {
                $file_name = 'komisi-agen-2-' . uniqid() . '.' . $request->file('payment_proof2')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('payment_proof2'), $file_name
                );

                 $data->payment_proof_2 = $file_name;
            }

            if ($request->hasFile('korwil_payment_proof1')) {
                $file_name = 'komisi-korwil-1-' . uniqid() . '.' . $request->file('korwil_payment_proof1')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('korwil_payment_proof1'), $file_name
                );

                $data->korwil_payment_proof_1 = $file_name;
            }

            if ($request->hasFile('korwil_payment_proof2')) {
                $file_name = 'komisi-korwil-2-' . uniqid() . '.' . $request->file('korwil_payment_proof2')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('korwil_payment_proof2'), $file_name
                );

                 $data->korwil_payment_proof_2 = $file_name;
            }

            if ($request->hasFile('korut_payment_proof1')) {
                $file_name = 'komisi-korut-1-' . uniqid() . '.' . $request->file('korut_payment_proof1')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('korut_payment_proof1'), $file_name
                );

                $data->korut_payment_proof_1 = $file_name;
            }

            if ($request->hasFile('korut_payment_proof2')) {
                $file_name = 'komisi-korut-2-' . uniqid() . '.' . $request->file('korut_payment_proof2')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('korut_payment_proof2'), $file_name
                );

                 $data->korut_payment_proof_2 = $file_name;
            }

            if ($request->hasFile('sales_evidence_cf')) {
                $file_name = 'sales-closing-fee-' . uniqid() . '.' . $request->file('sales_evidence_cf')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('sales_evidence_cf'), $file_name
                );

                $data->sales_evidence = $file_name;
            }

            if ($request->hasFile('agency_evidence_cf')) {
                $file_name = 'agent-closing-fee-' . uniqid() . '.' . $request->file('agency_evidence_cf')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('agency_evidence_cf'), $file_name
                );

                $data->agency_evidence = $file_name;
            }

            if ($request->hasFile('korwil_evidence_cf')) {
                $file_name = 'korwil-evidence-fee-' . uniqid() . '.' . $request->file('korwil_evidence_cf')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('korwil_evidence_cf'), $file_name
                );

                $data->korwil_evidence = $file_name;
            }

            if ($request->hasFile('korut_evidence_cf')) {
                $file_name = 'korut-evidence-fee-' . uniqid() . '.' . $request->file('korut_evidence_cf')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('Komisi', $request->file('korut_evidence_cf'), $file_name
                );

                $data->korut_evidence = $file_name;
            }

            $data->save();

            DB::commit();
            return response_json(true, null, 'Data komisi sales berhasil disimpan.', $data);
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
        if ($user->is_admin == '1') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission')->whereNotIn('booking_status', ['dokumen','spr'])->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sub_agent') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission','agency')
                            ->whereNotIn('booking_status', ['dokumen','spr'])
                            ->whereHas('agency', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }
        // $query = Booking::with('client', 'unit', 'document', 'sales','commission')->whereNotIn('booking_status', ['dokumen','spr'])->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('total_amount', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });

                $subquery->orWhereHas('agency', function($subquery2) use ($generalSearch){
                    $subquery2->where('agency_name', 'LIKE', '%'.$generalSearch.'%');
                });
                
                $subquery->orWhereHas('regional_coordinator', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
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

        $data = $query->whereNotIn('booking_status', ['dokumen','spr', 'ppjb'])->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));

        $data->getCollection()->transform(function($item) {
            $item->sales_name = $item->sales->user->full_name;
            $item->agency_name = $item->sales->agency ? $item->sales->agency->agency_name : '';
            $item->korwil_name = $item->sales->regional_coordinator ? $item->sales->regional_coordinator->full_name : '';
            $item->korut_name = $item->sales->main_coordinator ? $item->sales->main_coordinator->full_name : '';
            $item->client_name = $item->client->client_name;
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->ppn = $item->sales->agency->ppn;
            $item->pph_21 = $item->sales->agency->pph_21;
            $item->pph_23 = $item->sales->agency->pph_23;
            $item->pph_final = $item->sales->agency->pph_final;
            $item->commission_agent = $item->sales->agency->agency_commission;
            $item->cluster_name = $item->unit->point->cluster->cluster_name ?? '';

            $item->komisi_bruto = (round($item->total_amount / 1.1, 0) * $item->commission_agent) /100;
            $item->komisi_final = $item->komisi_bruto - (($item->komisi_bruto * $item->pph_final) /100) - 
                                                        (($item->komisi_bruto * $item->pph_21) /100) - 
                                                        (($item->komisi_bruto * $item->ppn) /100) - 
                                                        (($item->komisi_bruto * $item->pph_23) /100);

            $item->bruto ='Rp '.format_money($item->komisi_bruto); 
            $item->final ='Rp '.format_money($item->komisi_final); 
            
            $item->payment_date_1 = $item->commission ? $item->commission->payment_date_1 : '';
            $item->payment_proof_1 = $item->commission ? $item->commission->payment_proof_1 : '';
            $item->payment_date_2 = $item->commission ? $item->commission->payment_date_2 : '';
            $item->payment_proof_2 = $item->commission ? $item->commission->payment_proof_2 : '';

            if ($item->payment_date_1 && $item->payment_proof_1) {
                $item->payment_status_1 = "Sudah Bayar";
            }else{
                $item->payment_status_1 = "Belum Bayar";

            }

            if ($item->payment_date_2 && $item->payment_proof_2) {
                $item->payment_status_2 = "Sudah Bayar";
            }else{
                $item->payment_status_2 = "Belum Bayar";

            }

            $item->payment_1 = 'Rp '.format_money($item->komisi_final / 2);
            $item->payment_2 = 'Rp '.format_money($item->komisi_final / 2);

             
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
    public function getTableDataKorwil(Request $request)
    {
        $user = \Auth::user();
        if ($user->is_admin == '1') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission')->whereNotIn('booking_status', ['dokumen','spr'])->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'koordinator_wilayah') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission','regional_coordinator')
                            ->whereNotIn('booking_status', ['dokumen','spr'])
                            ->whereHas('regional_coordinator', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('total_amount', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });

                $subquery->orWhereHas('agency', function($subquery2) use ($generalSearch){
                    $subquery2->where('agency_name', 'LIKE', '%'.$generalSearch.'%');
                });
                
                $subquery->orWhereHas('regional_coordinator', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
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

        $data = $query->whereNotIn('booking_status', ['dokumen','spr', 'ppjb'])->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));

        $data->getCollection()->transform(function($item) {
            $item->sales_name = $item->sales->user->full_name;
            $item->agency_name = $item->sales->agency ? $item->sales->agency->agency_name : '';
            $item->korwil_name = $item->sales->regional_coordinator ? $item->sales->regional_coordinator->full_name : '';
            $item->korut_name = $item->sales->main_coordinator ? $item->sales->main_coordinator->full_name : '';
            $item->client_name = $item->client->client_name;
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->ppn = $item->sales->regional_coordinator->ppn;
            $item->pph_21 = $item->sales->regional_coordinator->pph_21;
            $item->pph_23 = $item->sales->regional_coordinator->pph_23;
            $item->pph_final = $item->sales->regional_coordinator->pph_final;
            $item->commission_korwil = $item->sales->agency->regional_coordinator_commission;
            $item->cluster_name = $item->unit->point->cluster->cluster_name ?? '';

            $item->komisi_bruto = (round($item->total_amount / 1.1, 0) * $item->commission_korwil) /100;
            $item->komisi_final = $item->komisi_bruto - (($item->komisi_bruto * $item->pph_final) /100) - 
                                                        (($item->komisi_bruto * $item->pph_21) /100) - 
                                                        (($item->komisi_bruto * $item->ppn) /100) - 
                                                        (($item->komisi_bruto * $item->pph_23) /100);

            $item->bruto ='Rp '.format_money($item->komisi_bruto); 
            $item->final ='Rp '.format_money($item->komisi_final); 
            

            $item->payment_date_1 = $item->commission ? $item->commission->korwil_payment_date_1 : '';
            $item->payment_proof_1 = $item->commission ? $item->commission->korwil_payment_proof_1 : '';
            $item->payment_date_2 = $item->commission ? $item->commission->korwil_payment_date_2 : '';
            $item->payment_proof_2 = $item->commission ? $item->commission->korwil_payment_proof_2 : '';

            if ($item->payment_date_1 && $item->payment_proof_1) {
                $item->payment_status_1 = "Sudah Bayar";
            }else{
                $item->payment_status_1 = "Belum Bayar";

            }

            if ($item->payment_date_2 && $item->payment_proof_2) {
                $item->payment_status_2 = "Sudah Bayar";
            }else{
                $item->payment_status_2 = "Belum Bayar";

            }

            $item->payment_1 = 'Rp '.format_money($item->komisi_final / 2);
            $item->payment_2 = 'Rp '.format_money($item->komisi_final / 2);

             
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorwil(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorwil($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

     /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataKorut(Request $request)
    {
        $user = \Auth::user();
        if ($user->is_admin == '1') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission')->whereNotIn('booking_status', ['dokumen','spr'])->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'koordinator_utama') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission', 'main_coordinator')
                            ->whereNotIn('booking_status', ['dokumen','spr'])
                            ->whereHas('main_coordinator', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('total_amount', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });

                $subquery->orWhereHas('agency', function($subquery2) use ($generalSearch){
                    $subquery2->where('agency_name', 'LIKE', '%'.$generalSearch.'%');
                });
                
                $subquery->orWhereHas('regional_coordinator', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
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

        $data = $query->whereNotIn('booking_status', ['dokumen','spr', 'ppjb'])->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));

        $data->getCollection()->transform(function($item) {
            $item->sales_name = $item->sales->user->full_name;
            $item->agency_name = $item->sales->agency ? $item->sales->agency->agency_name : '';
            $item->korwil_name = $item->sales->regional_coordinator ? $item->sales->regional_coordinator->full_name : '';
            $item->korut_name = $item->sales->main_coordinator ? $item->sales->main_coordinator->full_name : '';
            $item->client_name = $item->client->client_name;
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->ppn = $item->sales->main_coordinator->ppn;
            $item->pph_21 = $item->sales->main_coordinator->pph_21;
            $item->pph_23 = $item->sales->main_coordinator->pph_23;
            $item->pph_final = $item->sales->main_coordinator->pph_final;
            $item->commission_korut = $item->sales->agency->main_coordinator_commission;
            $item->cluster_name = $item->unit->point->cluster->cluster_name ?? '';

            $item->komisi_bruto = (round($item->total_amount / 1.1, 0) * $item->commission_korut) /100;
            $item->komisi_final = $item->komisi_bruto - (($item->komisi_bruto * $item->pph_final) /100) - 
                                                        (($item->komisi_bruto * $item->pph_21) /100) - 
                                                        (($item->komisi_bruto * $item->ppn) /100) - 
                                                        (($item->komisi_bruto * $item->pph_23) /100);

            $item->bruto ='Rp '.format_money($item->komisi_bruto); 
            $item->final ='Rp '.format_money($item->komisi_final); 
            

            $item->payment_date_1 = $item->commission ? $item->commission->korut_payment_date_1 : '';
            $item->payment_proof_1 = $item->commission ? $item->commission->korut_payment_proof_1 : '';
            $item->payment_date_2 = $item->commission ? $item->commission->korut_payment_date_2 : '';
            $item->payment_proof_2 = $item->commission ? $item->commission->korut_payment_proof_2 : '';

            if ($item->payment_date_1 && $item->payment_proof_1) {
                $item->payment_status_1 = "Sudah Bayar";
            }else{
                $item->payment_status_1 = "Belum Bayar";

            }

            if ($item->payment_date_2 && $item->payment_proof_2) {
                $item->payment_status_2 = "Sudah Bayar";
            }else{
                $item->payment_status_2 = "Belum Bayar";

            }

            $item->payment_1 = 'Rp '.format_money($item->komisi_final / 2);
            $item->payment_2 = 'Rp '.format_money($item->komisi_final / 2);

             
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorut(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorut($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataClosingFee(Request $request)
    {
        $user = \Auth::user();
        if ($user->is_admin == '1') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission')->whereNotIn('booking_status', ['dokumen','spr'])->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sales') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission')
                            ->whereNotIn('booking_status', ['dokumen','spr'])
                            ->whereHas('sales', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'koordinator_wilayah') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission','regional_coordinator')
                            ->whereNotIn('booking_status', ['dokumen','spr'])
                            ->whereHas('regional_coordinator', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }elseif ($user->status == 'sub_agent') {
            $query = Booking::with('client', 'unit', 'document', 'sales','commission','agency')
                            ->whereNotIn('booking_status', ['dokumen','spr'])
                            ->whereHas('agency', function($subquery) use ($user){
                                $subquery->where('user_id', $user->id);
                            })->orderBy('created_at', 'DESC');
        }else{
            $query = Booking::with('client', 'unit', 'document', 'sales','commission')->whereNotIn('booking_status', ['dokumen','spr'])->orderBy('created_at', 'DESC');
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('total_amount', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('sales', function($subquery) use ($generalSearch){
                $subquery->whereHas('user', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });

                $subquery->orWhereHas('agency', function($subquery2) use ($generalSearch){
                    $subquery2->where('agency_name', 'LIKE', '%'.$generalSearch.'%');
                });
                
                $subquery->orWhereHas('regional_coordinator', function($subquery2) use ($generalSearch){
                    $subquery2->where('full_name', 'LIKE', '%'.$generalSearch.'%');
                });
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

        $data = $query->whereNotIn('booking_status', ['dokumen','spr', 'ppjb'])->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));

        $data->getCollection()->transform(function($item) {
            $item->sales_name = $item->sales->user->full_name;
            $item->agency_name = $item->sales->agency ? $item->sales->agency->agency_name : '';
            $item->korwil_name = $item->sales->regional_coordinator ? $item->sales->regional_coordinator->full_name : '';
            $item->korut_name = $item->sales->main_coordinator ? $item->sales->main_coordinator->full_name : '';
            $item->client_name = $item->client->client_name;
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            $item->cluster_name = $item->unit->point->cluster->cluster_name ?? '';


            $item->payment_korut_date = $item->commission ? $item->commission->korut_payment_date : '';
            $item->payment_korut_evidence = $item->commission ? $item->commission->korut_evidence : '';
            $item->payment_korwil_date = $item->commission ? $item->commission->korwil_payment_date : '';
            $item->payment_korwil_evidence = $item->commission ? $item->commission->korwil_evidence : '';
            $item->payment_agency_date = $item->commission ? $item->commission->agency_payment_date : '';
            $item->payment_agency_evidence = $item->commission ? $item->commission->agency_evidence : '';
            $item->payment_sales_date = $item->commission ? $item->commission->sales_payment_date : '';
            $item->payment_sales_evidence = $item->commission ? $item->commission->sales_evidence : '';


            if ($item->payment_korut_date && $item->payment_korut_evidence) {
                $item->payment_korut = "Sudah Bayar";
            }else{
                $item->payment_korut = "Belum Bayar";
            }

            if ($item->payment_korwil_date && $item->payment_korwil_evidence) {
                $item->payment_korwil = "Sudah Bayar";
            }else{
                $item->payment_korwil = "Belum Bayar";
            }

            if ($item->payment_agency_date && $item->payment_agency_evidence) {
                $item->payment_agent = "Sudah Bayar";
            }else{
                $item->payment_agent = "Belum Bayar";
            }

            if ($item->payment_sales_date && $item->payment_sales_evidence) {
                $item->payment_sales = "Sudah Bayar";
            }else{
                $item->payment_sales = "Belum Bayar";
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
    public function tableClosingFee(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataClosingFee($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $salescommission)
    {
        $data = $salescommission->load('unit','client','sales','commission','sales.user','sales.main_coordinator', 'sales.agency', 'sales.regional_coordinator');
        $data->total_amount = round($data->total_amount / 1.1, 0);
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
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
            'pph_21' => json_decode(option('pph_21', json_encode([]))),
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
}

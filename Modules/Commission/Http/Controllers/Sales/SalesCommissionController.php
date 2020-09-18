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
                "text" => 'Koordinator Wilayah',
                "align" => 'center',
                "sortable" => true,
                "value" => 'korwil_name',
            ],
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
            ],
            // [
            //     "text" => 'Tanggal Transaksi',
            //     "align" => 'center',
            //     "sortable" => true,
            //     "value" => '',
            // ],
            [
                "text" => 'Tipe Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit.unit_type',
            ],
            [
                "text" => 'Data Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => 'unit_number',
            ],
            [
                "text" => 'Harga Pricelist',
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
            // [
            //     "text" => 'Type Komisi',
            //     "align" => 'center',
            //     "sortable" => true,
            //     "value" => '',
            // ],
            // [
            //     "text" => 'Komisi Koordinator Utama',
            //     "align" => 'center',
            //     "sortable" => true,
            //     "value" => '',
            // ],
            // [
            //     "text" => 'Komisi Bruto Korwil',
            //     "align" => 'center',
            //     "sortable" => true,
            //     "value" => '',
            // ],
            // [
            //     "text" => 'Total Komisi(PPH Final + PPH 21)',
            //     "align" => 'center',
            //     "sortable" => true,
            //     "value" => '',
            // ],
            [
                "text" => 'Komisi Bruto Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'bruto',
            ],
            [
                "text" => 'Total Komisi Sub Agent (PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => true,
                "value" => 'final',
            ],
            [
                "text" => 'Pencairan 1 (50%)',
                "align" => 'center',
                "sortable" => true,
                "value" => 'payment_status_1',
            ],
            [
                "text" => 'Pencairan 2 (50%)',
                "align" => 'center',
                "sortable" => true,
                "value" => 'payment_status_2',
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
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Edit Komisi Sales'];

        return view('commission::salescommission.edit',[
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
        $query = Booking::with('client', 'unit', 'document', 'sales','commission')->whereNotIn('booking_status', ['dokumen','spr'])->orderBy('created_at', 'DESC');

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

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

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
            $item->pph_21 = $this->getHelper()['pph_21'];
            $item->pph_final = $item->sales->agency->pph_final;
            $item->commission_agent = $item->sales->agency->agency_commission;

            $item->komisi_bruto = ($item->total_amount * $item->commission_agent) /100;
            $item->komisi_final = $item->komisi_bruto - (($item->komisi_bruto * $item->pph_final) /100) - (($item->komisi_bruto * $item->pph_21) /100);
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
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $salescommission)
    {
        $data = $salescommission->load('unit','client','sales','commission','sales.user','sales.main_coordinator', 'sales.agency', 'sales.regional_coordinator');
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

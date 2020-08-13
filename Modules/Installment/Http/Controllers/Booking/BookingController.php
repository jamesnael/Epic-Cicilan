<?php

namespace Modules\Installment\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('booking.index'), 'text' => 'Data Booking'],
        ];

        $this->helper = new BookingHelper;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->table_headers = [
            [
                "text" => 'Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
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
                "value" => 'total_amount',
            ],
            [
                "text" => 'DP',
                "align" => 'center',
                "sortable" => true,
                "value" => 'dp_amount',
            ],
            [
                "text" => 'Cicilan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'installment',
            ],
            [
                "text" => 'Tanggal Jatuh Tempo',
                "align" => 'center',
                "sortable" => true,
                "value" => 'due_date',
            ],
            [
                "text" => 'Principal',
                "align" => 'center',
                "sortable" => true,
                "value" => 'principal',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => true,
                "value" => 'point',
            ]
        ];
        return view('installment::booking.index', [
            'page' => $this,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {   
        $this->breadcrumbs[] = ['href' => route('booking.index'), 'text' => 'Tambah Booking'];

        return view('installment::booking.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $unit = Unit::create($request->all());
            
            $request->merge(['unit_id' => $unit->id]);
            $booking = Booking::create($request->all());

            $data = $this->helper->saveBookingPayments($booking);

            DB::commit();
            return response_json(true, null, 'Data booking berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('installment::bookingshow');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Responsec
     */
    public function edit(Booking $booking)
    {
        $this->breadcrumbs[] = ['href' => route('booking.edit', [$booking->slug]), 'text' => 'Edit Booking ' . ''];

        return view('installment::booking.edit', [
            'page' => $this,
            'data' => $booking,

        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Booking $booking)
    {
        $validator = $this->validateFormRequest($request, $booking->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

            $unit = Unit::where('id', $booking->unit_id)->first();
            $unit->update($request->all());

            $booking->update($request->all());
            $data = $this->helper->saveBookingPayments($booking);

            DB::commit();
            return response_json(true, null, 'Data booking berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        DB::beginTransaction();
        try {
            $unit = Unit::where('id', $booking->unit_id)->first();
            $unit->delete();

            $booking->payments()->delete();
            $booking->delete();

            DB::commit();
            return response_json(true, null, 'Data booking berhasil dihapus.');
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
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "unit_type" => "bail|required",
            "unit_block" => "bail|required",
            "unit_number" => "bail|required",
            "surface_area" => "bail|required|numeric",
            "building_area" => "bail|required|numeric",
            "utj" => "bail|required",
            "electrical_power" => "bail|required|numeric",
            "points" => "bail|required|numeric",
            "closing_fee" => "bail|required",
            "client_id" => "bail|nullable|exists:Modules\Installment\Entities\Client,id",
            "total_amount" => "bail|required|numeric",
            "ppn" => "bail|required|numeric",
            "payment_type" => "bail|required|string|max:255",
            "payment_method" => "bail|required|string|max:255",
            "dp_amount" => "bail|required|numeric",
            "first_payment" => "bail|required",
            "principal" => "bail|required",
            "installment" => "bail|required|numeric",
            "installment_time" => "bail|required",
            "due_date" => "bail|required",
            "credits" => "bail|required|numeric",
            "payment_method_utj" => "bail|required|string|max:255",
            "bank_name" => "bail|required|string|max:255",
            "card_number" => "bail|required|string|max:255",
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
        $query = Booking::with('client','unit')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('dp_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('point', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->client_name = $item->client->client_name;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block;
            $item->total_amount ='Rp '.$item->total_amount;
            $item->dp_amount = 'Rp '.$item->dp_amount;
            $item->installment = 'Rp '.$item->installment;
            $item->point = $item->unit->points;
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
    public function data(Booking $booking)
    {
        $data = $booking->load('unit','client','sales','sales.user','sales.main_coordinator', 'sales.agency', 'sales.regional_coordinator');
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

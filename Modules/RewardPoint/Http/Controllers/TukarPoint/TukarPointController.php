<?php

namespace Modules\RewardPoint\Http\Controllers\TukarPoint;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AppUser\Entities\User;
use Modules\RewardPoint\Entities\RewardCategory;
use Modules\RewardPoint\Entities\RewardPoint;
use Modules\RewardPoint\Entities\SalesPoint;
use Modules\RewardPoint\Entities\ExchangePointSales;
use Modules\RewardPoint\Entities\ExchangePointSubAgent;
use Modules\RewardPoint\Entities\ExchangePointKoorUmum;
use Modules\RewardPoint\Entities\ExchangePointKoorWilayah;
use Modules\RewardPoint\Entities\RecordPoint;
use Modules\RewardPoint\Notifications\NotifyExchangePoint;
use Modules\SalesAgent\Entities\Sales;
use Modules\SalesAgent\Entities\Agency;
use Modules\SalesAgent\Entities\RegionalCoordinator;
use Modules\SalesAgent\Entities\MainCoordinator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Modules\RewardPoint\Notifications\PenukaranPoint;
use PDF;

class TukarPointController extends Controller
{
     /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('is-allowed')->only(['index', 'table', 'data', 'createSales', 'edit', 'destroy']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('tukar-point.index'), 'text' => 'Tukar Point'],
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
                "text" => 'Nama Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => 'user.full_name',
            ],
            [
                "text" => 'Nama Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency.agency_name',
            ],
            [
                "text" => 'Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => 'regional_coordinator.full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Point Yang Telah Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchanged_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sisa_point',
            ],
        ];

        $this->table_headers_agent = [
            [
                "text" => 'Nama Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => 'agency_name',
            ],
            [
                "text" => 'Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => 'regional_coordinator.full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Point Yang Telah Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchanged_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sisa_point',
            ],
        ];

        $this->table_headers_korwil = [
            [
                "text" => 'Nama Koordinator Wilayah',
                "align" => 'center',
                "sortable" => true,
                "value" => 'full_name',
            ],
            [
                "text" => 'Koordinator Utama',
                "align" => 'center',
                "sortable" => true,
                "value" => 'main_coordinator.full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Point Yang Telah Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchanged_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sisa_point',
            ],
        ];

        $this->table_headers_korut = [
            [
                "text" => 'Nama Koordinator Utama',
                "align" => 'center',
                "sortable" => true,
                "value" => 'full_name',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'total_point',
            ],
            [
                "text" => 'Point Bisa Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'allowed_point',
            ],
            [
                "text" => 'Point Yang Telah Ditukar',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchanged_point',
            ],
            [
                "text" => 'Sisa Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'sisa_point',
            ],
        ];

        return view('rewardpoint::TukarPoint.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function createSales()
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point.index'), 'text' => 'Tambah Tukar Point'];

        return view('rewardpoint::TukarPoint.create-sales', [
            'page' => $this,
        ])->with($this->getHelper());
    }


    public function createAgent()
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point.index'), 'text' => 'Tambah Tukar Point'];

        return view('rewardpoint::TukarPoint.create-agency', [
            'page' => $this,
        ])->with($this->getHelper());
    }

    public function createKorwil()
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point.index'), 'text' => 'Tambah Tukar Point'];

        return view('rewardpoint::TukarPoint.create-korwil', [
            'page' => $this,
        ])->with($this->getHelper());
    }

    public function createKorut()
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point.index'), 'text' => 'Tambah Tukar Point'];

        return view('rewardpoint::TukarPoint.create-korut', [
            'page' => $this,
        ])->with($this->getHelper());
    }


    public function data(RewardPoint $tukar_point)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $tukar_point);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function cancelSales($id)
    {
        DB::beginTransaction();
        try {
            $exchange_sales = ExchangePointSales::findOrFail($id);
            $exchange_sales->delete();
            DB::commit();

            //Log Activity
            activity()
                ->causedBy(\Auth::user())
                ->withProperties(['tukar point' => $exchange_sales])
                ->log('Data penukaran point berhasil dicancel');

            return response_json(true, null, 'Penukaran point berhasil dicancel.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Data berikut telah di cancel sebelumnya.');
        }
    }

    public function cancelAgent($id)
    {
        DB::beginTransaction();
        try {
            $exchange_agent = ExchangePointSubAgent::findOrFail($id);
            $exchange_agent->delete();
            DB::commit();

            //Log Activity
            activity()
                ->causedBy(\Auth::user())
                ->withProperties(['tukar point' => $exchange_agent])
                ->log('Data penukaran point berhasil dicancel');

            return response_json(true, null, 'Penukaran point berhasil dicancel.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Data berikut telah di cancel sebelumnya.');
        }
    }

    public function cancelKorwil($id)
    {
        DB::beginTransaction();
        try {
            $exchange_korwil = ExchangePointKoorWilayah::findOrFail($id);
            $exchange_korwil->delete();
            DB::commit();

            //Log Activity
            activity()
                ->causedBy(\Auth::user())
                ->withProperties(['tukar point' => $exchange_korwil])
                ->log('Data penukaran point berhasil dicancel');

            return response_json(true, null, 'Penukaran point berhasil dicancel.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Data berikut telah di cancel sebelumnya.');
        }
    }

    public function cancelKorut($id)
    {
        DB::beginTransaction();
        try {
            $exchange_korut = ExchangePointKoorUmum::findOrFail($id);
            $exchange_korut->delete();
            DB::commit();

            //Log Activity
            activity()
                ->causedBy(\Auth::user())
                ->withProperties(['tukar point' => $exchange_korut])
                ->log('Data penukaran point berhasil dicancel');

            return response_json(true, null, 'Penukaran point berhasil dicancel.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Data berikut telah di cancel sebelumnya.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function historySales($id)
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point-sales.history', $id), 'text' => 'History'];
        $this->table_headers = [
            [
                "text" => 'Tanggal Penukaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            // [
            //     "text" => 'Tanggal Cancel',
            //     "align" => 'center',
            //     "sortable" => false,
            //     "value" => 'deleted_date',
            // ],
            [
                "text" => 'Category Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchange_point',
            ],
        ];

        $this->table_headers_sales_get_point = [
            [
                "text" => 'Tanggal Closing',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            [
                "text" => 'Nama Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'units',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'booking.unit.points',
            ],
            [
                "text" => 'Status Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'status',
            ],
            [
                "text" => 'Tanggal Pelunasan Komisi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'updated_date',
            ],
        ];

        $this->id = $id;
        return view('rewardpoint::TukarPoint.history-sales', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    public function historyAgent($id)
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point-agent.history', $id), 'text' => 'History'];
        $this->table_headers = [
            [
                "text" => 'Tanggal Penukaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            // [
            //     "text" => 'Tanggal Cancel',
            //     "align" => 'center',
            //     "sortable" => false,
            //     "value" => 'deleted_date',
            // ],
            [
                "text" => 'Category Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchange_point',
            ],

        ];

        $this->table_headers_agent_get_point = [
            [
                "text" => 'Tanggal Closing',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            [
                "text" => 'Nama Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'units',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'booking.unit.points',
            ],
            [
                "text" => 'Status Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'status',
            ],
            [
                "text" => 'Tanggal Pelunasan Komisi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'updated_date',
            ],
        ];
        $this->id = $id;
        return view('rewardpoint::TukarPoint.history-agent', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    public function historyKorwil($id)
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point-korwil.history', $id), 'text' => 'History'];
        $this->table_headers = [
            [
                "text" => 'Tanggal Penukaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            // [
            //     "text" => 'Tanggal Cancel',
            //     "align" => 'center',
            //     "sortable" => false,
            //     "value" => 'deleted_date',
            // ],
            [
                "text" => 'Category Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchange_point',
            ],
        ];

        $this->table_headers_korwil_get_point = [
            [
                "text" => 'Tanggal Closing',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            [
                "text" => 'Nama Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'units',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'booking.unit.points',
            ],
            [
                "text" => 'Status Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'status',
            ],
            [
                "text" => 'Tanggal Pelunasan Komisi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'updated_date',
            ],
        ];

        $this->id = $id;
        return view('rewardpoint::TukarPoint.history-korwil', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    public function historyKorut($id)
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point-korut.history', $id), 'text' => 'History'];
        $this->table_headers = [
            [
                "text" => 'Tanggal Penukaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            // [
            //     "text" => 'Tanggal Cancel',
            //     "align" => 'center',
            //     "sortable" => false,
            //     "value" => 'deleted_date',
            // ],
            [
                "text" => 'Category Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.category.category_name',
            ],
            [
                "text" => 'Rewards',
                "align" => 'center',
                "sortable" => false,
                "value" => 'reward_point.reward_name',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'exchange_point',
            ],
        ];

        $this->table_headers_korut_get_point = [
            [
                "text" => 'Tanggal Closing',
                "align" => 'center',
                "sortable" => false,
                "value" => 'date',
            ],
            [
                "text" => 'Nama Unit',
                "align" => 'center',
                "sortable" => false,
                "value" => 'units',
            ],
            [
                "text" => 'Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'booking.unit.points',
            ],
            [
                "text" => 'Status Point',
                "align" => 'center',
                "sortable" => false,
                "value" => 'status',
            ],
            [
                "text" => 'Tanggal Pelunasan Komisi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'updated_date',
            ],
        ];

        $this->id = $id;
        return view('rewardpoint::TukarPoint.history-korut', [
            'page' => $this,

        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, RewardPoint $tukar_point)
    {
        $validator = $this->validateFormRequest($request, $tukar_point->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $tukar_point->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data reward berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function store(Request $request)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            // Sales Condition
            if ($request->has('level') && $request->input('level') == 'Sales') {
                $data = ExchangePointSales::create([
                    'sales_id'        => $request->user_name,
                    'reward_point_id' => $request->reward_point_id,
                    'exchange_point'  => $request->redeem_point,
                ]);

                //Email Notification
                Notification::route('mail', $data->sales->user->email)
                            ->notify(new PenukaranPoint($data->sales->user->full_name, $data->exchange_point, $data->reward_point->reward_name, $data->created_at));
            }

            // Agent Condition
            if ($request->has('level') && $request->input('level') == 'Agent') {
                $data = ExchangePointSubAgent::create([
                    'agency_id'       => $request->user_name,
                    'reward_point_id' => $request->reward_point_id,
                    'exchange_point'  => $request->redeem_point,
                ]);

                //Email Notification
                Notification::route('mail', $data->agency->agency_email)
                            ->notify(new PenukaranPoint($data->agency->agency_name, $data->exchange_point, $data->reward_point->reward_name, $data->created_at));
            }

            // Korwil Condition
            if ($request->has('level') && $request->input('level') == 'Korwil') {
                $data = ExchangePointKoorWilayah::create([
                    'regional_coordinator_id' => $request->user_name,
                    'reward_point_id'         => $request->reward_point_id,
                    'exchange_point'          => $request->redeem_point,
                ]);

                //Email Notification
                Notification::route('mail', $data->regional_coordinator->email)
                            ->notify(new PenukaranPoint($data->regional_coordinator->full_name, $data->exchange_point, $data->reward_point->reward_name, $data->created_at));
            }

            // Korut Condition
            if ($request->has('level') && $request->input('level') == 'Korut') {
                $data = ExchangePointKoorUmum::create([
                    'main_coordinator_id' => $request->user_name,
                    'reward_point_id'     => $request->reward_point_id,
                    'exchange_point'      => $request->redeem_point,
                ]);

                //Email Notification
                Notification::route('mail', $data->main_coordinator->email)
                            ->notify(new PenukaranPoint($data->main_coordinator->full_name, $data->exchange_point, $data->reward_point->reward_name, $data->created_at));
            }
            //Log Activity
            activity()
             ->performedOn($data)
             ->causedBy(\Auth::user())
             ->log('Penukaran point berhasil dilakukan');

            DB::commit();
            return response_json(true, null, 'Tukar point berhasil dilakukan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "reward_point_id" => "bail|required",
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getHelper()
    {
        return [
            'category' => RewardCategory::select('id AS value', 'category_name AS text')->get(),
            'reward_name_sales' => RewardPoint::select('id AS value', 'reward_name AS text', 'redeem_point_sales','redeem_point_agency','redeem_point_regional_coordinator','redeem_point_main_coordinator','category_reward_id','status')->where('status', 'Aktif')->whereNotNull('redeem_point_sales')->get(),
            'reward_name_agency' => RewardPoint::select('id AS value', 'reward_name AS text', 'redeem_point_sales','redeem_point_agency','redeem_point_regional_coordinator','redeem_point_main_coordinator','category_reward_id','status')->where('status', 'Aktif')->whereNotNull('redeem_point_agency')->get(),
            'reward_name_regional_coordinator' => RewardPoint::select('id AS value', 'reward_name AS text', 'redeem_point_sales','redeem_point_agency','redeem_point_regional_coordinator','redeem_point_main_coordinator','category_reward_id','status')->where('status', 'Aktif')->whereNotNull('redeem_point_regional_coordinator')->get(),
            'reward_name_main_coordinator' => RewardPoint::select('id AS value', 'reward_name AS text', 'redeem_point_sales','redeem_point_agency','redeem_point_regional_coordinator','redeem_point_main_coordinator','category_reward_id','status')->where('status', 'Aktif')->whereNotNull('redeem_point_main_coordinator')->get(),
                                    



            'sales_name' => Sales::with('user','agency', 'main_coordinator', 'regional_coordinator','booking')->get()->transform(function($item){
                $item->value         = $item->id;
                $item->text          = $item->user->full_name;
                $item->agency_name   = $item->agency->agency_name ?? '';
                $item->total_point   = $item->total_point ?? '';
                $item->allowed_point = $item->allowed_point ?? '';
                $item->sisa_point    = $item->allowed_point - $item->exchanged_point;

                return $item;
            }),
            'agency_name' => Agency::with('booking','regional_coordinator')->get()->transform(function($item){
                $item->value         = $item->id;
                $item->text          = $item->agency_name;
                $item->regional      = $item->regional_coordinator->full_name ?? '';
                $item->total_point   = $item->total_point ?? '';
                $item->allowed_point = $item->allowed_point ?? '';
                $item->sisa_point    = $item->allowed_point - $item->exchanged_point;

                return $item;
            }),
            'korwil_name' => RegionalCoordinator::with('booking','main_coordinator')->get()->transform(function($item){
                $item->value         = $item->id;
                $item->text          = $item->full_name;
                $item->maincoor      = $item->main_coordinator->full_name ?? '';
                $item->total_point   = $item->total_point ?? '';
                $item->allowed_point = $item->allowed_point ?? '';
                $item->sisa_point    = $item->allowed_point - $item->exchanged_point;

                return $item;
            }),

            'korut_name' => MainCoordinator::with('booking')->get()->transform(function($item){
                $item->value         = $item->id;
                $item->text          = $item->full_name;
                $item->total_point   = $item->total_point ?? '';
                $item->allowed_point = $item->allowed_point ?? '';
                $item->sisa_point    = $item->allowed_point - $item->exchanged_point;

                return $item;
            })
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
    public function getTableDataSales(Request $request)
    {
        if (\Auth::user()->is_admin){
            $query = Sales::with('regional_coordinator', 'main_coordinator', 'agency', 'user', 'point', 'booking');
        } else {
            $query = Sales::with('regional_coordinator', 'main_coordinator', 'agency', 'user', 'point', 'booking')->where('id', \Auth::user()->sales->id);
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->whereHas('user', function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('agency', function($subquery) use ($generalSearch) {
                $subquery->where('agency_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('regional_coordinator', function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        if ($request->input('sort') == []) {
            $query->orderBy('created_at', 'DESC');
        } else {
            foreach ($request->input('sort') as $sort_key => $sort) {
                if ($sort[0] == "user.full_name") {
                    $query->join('users', 'users.id', '=', 'sales.user_id')
                    ->select('sales.*', 'users.full_name as sales_name')
                    ->orderBy('sales_name', $sort[1] ? 'desc' : 'asc');
                } elseif ($sort[0] == "agency.agency_name"){
                    $query->join('agencies', 'agencies.id', '=', 'sales.agency_id')
                    ->select('sales.*', 'agencies.agency_name as agencys_name')
                    ->orderBy('agencys_name', $sort[1] ? 'desc' : 'asc');
                } elseif ($sort[0] == "regional_coordinator.full_name"){
                    $query->join('regional_coordinators', 'regional_coordinators.id', '=', 'sales.regional_coordinator_id')
                    ->select('sales.*', 'regional_coordinators.full_name as korwil_name')
                    ->orderBy('korwil_name', $sort[1] ? 'desc' : 'asc');
                }
            }
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableSales(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataSales($request));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataAgent(Request $request)
    {
        if (\Auth::user()->is_admin){
            $query = Agency::with('regional_coordinator', 'point');
        } else {
            $query = Agency::with('regional_coordinator', 'point')->where('id', \Auth::user()->agency->id);
        }
        
        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('agency_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('regional_coordinator', function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        if ($request->input('sort') == []) {
            $query->orderBy('created_at', 'DESC');
        } else {
            foreach ($request->input('sort') as $sort_key => $sort) {
                if ($sort[0] == "agency_name"){
                    $query->orderBy('agency_name', $sort[1] ? 'desc' : 'asc');
                } elseif ($sort[0] == "regional_coordinator.full_name"){
                    $query->join('regional_coordinators', 'regional_coordinators.id', '=', 'agencies.regional_coordinator_id')
                    ->select('agencies.*', 'regional_coordinators.full_name as korwil_name')
                    ->orderBy('korwil_name', $sort[1] ? 'desc' : 'asc');
                }
            }
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableAgent(Request $request)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataAgent($request));
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
        if (\Auth::user()->is_admin){
            $query = RegionalCoordinator::with('main_coordinator', 'agency');
        } else {
            $query = RegionalCoordinator::with('main_coordinator', 'agency')->where('id', \Auth::user()->regional_coordinator->id);
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('main_coordinator', function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        if ($request->input('sort') == []) {
            $query->orderBy('created_at', 'DESC');
        } else {
            foreach ($request->input('sort') as $sort_key => $sort) {
                if ($sort[0] == "full_name"){
                    $query->orderBy('full_name', $sort[1] ? 'desc' : 'asc');
                } elseif ($sort[0] == "main_coordinator.full_name"){
                    $query->join('main_coordinators', 'main_coordinators.id', '=', 'regional_coordinators.main_coordinator_id')
                    ->select('regional_coordinators.*', 'main_coordinators.full_name as korut_name')
                    ->orderBy('korut_name', $sort[1] ? 'desc' : 'asc');
                }
            }
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
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
        if (\Auth::user()->is_admin){
            $query = MainCoordinator::with('regional_coordinators', 'point');
        } else {
            $query = MainCoordinator::with('regional_coordinators', 'point')->where('id', \Auth::user()->main_coordinator->id);
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        if ($request->input('sort') == []) {
            $query->orderBy('created_at', 'DESC');
        } else {
            foreach ($request->input('sort') as $sort_key => $sort) {
                if ($sort[0] == "full_name"){
                    $query->orderBy('full_name', $sort[1] ? 'desc' : 'asc');
                }
            }
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->closing_fee = 'Rp '.format_money($item->closing_fee);
            $item->sisa_point = $item->allowed_point - $item->exchanged_point;
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

    public function getTableDataSalesHistory(Request $request, $id)
    {
        $query = ExchangePointSales::with('sales', 'reward_point', 'reward_point.category')->where('sales_id', $id)->withTrashed()->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('deleted_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('reward_point' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('reward_name', 'LIKE', '%' . $generalSearch . '%')->where('sales_id', $id);
            });

            $query->orWhereHas('reward_point.category' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('category_name', 'LIKE', '%' . $generalSearch . '%')->where('sales_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->allowed_point   = $item->sales ? $item->sales->allowed_point : 0;
            $item->exchanged_point = $item->sales ? $item->sales->exchanged_point : 0;
            $item->sisa_point      = $item->allowed_point - $item->exchanged_point;
            $item->date            = date('d F Y', strtotime($item->created_at));
            $item->deleted_date    = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableSalesHistory(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataSalesHistory($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function getTableDataSalesHistoryGetPoint(Request $request, $id)
    {
        $query = RecordPoint::with('booking', 'booking.sales', 'booking.sales.user', 'booking.unit')->join('bookings', 'bookings.id', '=', 'record_points.booking_id')->where('bookings.sales_id', $id)->select('*','record_points.created_at AS created_date', 'record_points.updated_at AS updated_date')->orderBy('record_points.created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('record_points.created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('record_points.updated_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('booking.unit' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('unit_type', 'LIKE', '%' . $generalSearch . '%')->where('bookings.sales_id', $id);
                $subquery->orWhere('unit_number', 'LIKE', '%' . $generalSearch . '%')->where('bookings.sales_id', $id);
                $subquery->orWhere('unit_block', 'LIKE', '%' . $generalSearch . '%')->where('bookings.sales_id', $id);
                $subquery->orWhere('points', 'LIKE', '%' . $generalSearch . '%')->where('bookings.sales_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->date         = date('d F Y', strtotime($item->created_date));
            $item->units        = $item->booking->unit->unit_type . ' ' . $item->booking->unit->unit_number . '/' . $item->booking->unit->unit_block;
            $item->updated_date = ($item->point_status == 'T') ? date('d F Y', strtotime($item->updated_date)): '-';
            $item->deleted_date = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            $item->status       = ($item->point_status == 'T') ? 'Dapat digunakan' : 'Belum dapat digunakan';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableSalesHistoryGetPoint(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataSalesHistoryGetPoint($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataAgentHistory(Request $request, $id)
    {
        $query = ExchangePointSubAgent::with('agency', 'reward_point', 'reward_point.category')->where('agency_id', $id)->withTrashed()->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('deleted_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('reward_point' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('reward_name', 'LIKE', '%' . $generalSearch . '%')->where('agency_id', $id);
            });

            $query->orWhereHas('reward_point.category' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('category_name', 'LIKE', '%' . $generalSearch . '%')->where('agency_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->allowed_point   = $item->agency ? $item->agency->allowed_point : 0;
            $item->exchanged_point = $item->agency ? $item->agency->exchanged_point : 0;
            $item->sisa_point      = $item->allowed_point - $item->exchanged_point;
            $item->date            = date('d F Y', strtotime($item->created_at));
            $item->deleted_date    = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableAgentHistory(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataAgentHistory($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function getTableDataAgentHistoryGetPoint(Request $request, $id)
    {
        $query = RecordPoint::with('booking', 'booking.agency', 'booking.unit')->join('bookings', 'bookings.id', '=', 'record_points.booking_id')->where('bookings.agent_id', $id)->select('*','record_points.created_at AS created_date', 'record_points.updated_at AS updated_date')->orderBy('record_points.created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('record_points.created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('record_points.updated_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('booking.unit' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('unit_type', 'LIKE', '%' . $generalSearch . '%')->where('bookings.agent_id', $id);
                $subquery->orWhere('unit_number', 'LIKE', '%' . $generalSearch . '%')->where('bookings.agent_id', $id);
                $subquery->orWhere('unit_block', 'LIKE', '%' . $generalSearch . '%')->where('bookings.agent_id', $id);
                $subquery->orWhere('points', 'LIKE', '%' . $generalSearch . '%')->where('bookings.agent_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->date         = date('d F Y', strtotime($item->created_date));
            $item->units        = $item->booking->unit->unit_type . ' ' . $item->booking->unit->unit_number . '/' . $item->booking->unit->unit_block;
            $item->updated_date = ($item->point_status == 'T') ? date('d F Y', strtotime($item->updated_date)): '-';
            $item->deleted_date = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            $item->status       = ($item->point_status == 'T') ? 'Dapat digunakan' : 'Belum dapat digunakan';

            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableAgentHistoryGetPoint(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataAgentHistoryGetPoint($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataKorwilHistory(Request $request, $id)
    {
        $query = ExchangePointKoorWilayah::with('regional_coordinator', 'reward_point', 'reward_point.category')->where('regional_coordinator_id', $id)->withTrashed()->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('deleted_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('reward_point' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('reward_name', 'LIKE', '%' . $generalSearch . '%')->where('regional_coordinator_id', $id);
            });

            $query->orWhereHas('reward_point.category' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('category_name', 'LIKE', '%' . $generalSearch . '%')->where('regional_coordinator_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->allowed_point   = $item->regional_coordinator ? $item->regional_coordinator->allowed_point : 0;
            $item->exchanged_point = $item->regional_coordinator ? $item->regional_coordinator->exchanged_point : 0;
            $item->sisa_point      = $item->allowed_point - $item->exchanged_point;
            $item->date            = date('d F Y', strtotime($item->created_at));
            $item->deleted_date    = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorwilHistory(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorwilHistory($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function getTableDataKorwilHistoryGetPoint(Request $request, $id)
    {
        $query = RecordPoint::with('booking', 'booking.regional_coordinator', 'booking.unit')->join('bookings', 'bookings.id', '=', 'record_points.booking_id')->where('bookings.regional_coor_id', $id)->select('*','record_points.created_at AS created_date', 'record_points.updated_at AS updated_date')->orderBy('record_points.created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('record_points.created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('record_points.updated_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('booking.unit' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('unit_type', 'LIKE', '%' . $generalSearch . '%')->where('bookings.regional_coor_id', $id);
                $subquery->orWhere('unit_number', 'LIKE', '%' . $generalSearch . '%')->where('bookings.regional_coor_id', $id);
                $subquery->orWhere('unit_block', 'LIKE', '%' . $generalSearch . '%')->where('bookings.regional_coor_id', $id);
                $subquery->orWhere('points', 'LIKE', '%' . $generalSearch . '%')->where('bookings.regional_coor_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->date         = date('d F Y', strtotime($item->created_date));
            $item->units        = $item->booking->unit->unit_type . ' ' . $item->booking->unit->unit_number . '/' . $item->booking->unit->unit_block;
            $item->updated_date = ($item->point_status == 'T') ? date('d F Y', strtotime($item->updated_date)): '-';
            $item->deleted_date = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            $item->status       = ($item->point_status == 'T') ? 'Dapat digunakan' : 'Belum dapat digunakan';

            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorwilHistoryGetPoint(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorwilHistoryGetPoint($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Query for get data for table
     *
     */
    public function getTableDataKorutHistory(Request $request, $id)
    {
        $query = ExchangePointKoorUmum::with('main_coordinator', 'reward_point', 'reward_point.category')->where('main_coordinator_id', $id)->withTrashed()->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('deleted_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('reward_point' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('reward_name', 'LIKE', '%' . $generalSearch . '%')->where('main_coordinator_id', $id);
            });

            $query->orWhereHas('reward_point.category' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('category_name', 'LIKE', '%' . $generalSearch . '%')->where('main_coordinator_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->allowed_point   = $item->main_coordinator ? $item->main_coordinator->allowed_point : 0;
            $item->exchanged_point = $item->main_coordinator ? $item->main_coordinator->exchanged_point : 0;
            $item->sisa_point      = $item->allowed_point - $item->exchanged_point;
            $item->date            = date('d F Y', strtotime($item->created_at));
            $item->deleted_date    = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorutHistory(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorutHistory($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function getTableDataKorutHistoryGetPoint(Request $request, $id)
    {
        $query = RecordPoint::with('booking', 'booking.main_coordinator', 'booking.unit')->join('bookings', 'bookings.id', '=', 'record_points.booking_id')->where('bookings.main_coor_id', $id)->select('*','record_points.created_at AS created_date', 'record_points.updated_at AS updated_date')->orderBy('record_points.created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                //Check if Search is Date
                try {
                    $check_date = \Carbon\Carbon::parse($generalSearch)->locale('id')->translatedFormat('y-m-d');
                } catch (\Exception $e){
                    $check_date = $generalSearch;
                }

                $subquery->where('record_points.created_at', 'LIKE', '%' . $check_date . '%');
                $subquery->orWhere('record_points.updated_at', 'LIKE', '%' . $check_date . '%');
            });

            $query->orWhereHas('booking.unit' ,function($subquery) use ($generalSearch, $id) {
                $subquery->where('unit_type', 'LIKE', '%' . $generalSearch . '%')->where('bookings.main_coor_id', $id);
                $subquery->orWhere('unit_number', 'LIKE', '%' . $generalSearch . '%')->where('bookings.main_coor_id', $id);
                $subquery->orWhere('unit_block', 'LIKE', '%' . $generalSearch . '%')->where('bookings.main_coor_id', $id);
                $subquery->orWhere('points', 'LIKE', '%' . $generalSearch . '%')->where('bookings.main_coor_id', $id);
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->date         = date('d F Y', strtotime($item->created_date));
            $item->units        = $item->booking->unit->unit_type . ' ' . $item->booking->unit->unit_number . '/' . $item->booking->unit->unit_block;
            $item->updated_date = ($item->point_status == 'T') ? date('d F Y', strtotime($item->updated_date)): '-';
            $item->deleted_date = $item->deleted_at ? date('d F Y', strtotime($item->deleted_at)) : '-';
            $item->status       = ($item->point_status == 'T') ? 'Dapat digunakan' : 'Belum dapat digunakan';

            return $item;
        });
        return $data;
    }

    /**
     *
     * Handle incoming request for table data
     *
     */
    public function tableKorutHistoryGetPoint(Request $request, $id)
    {
        $request->merge(['sort' => json_decode($request->input('sort'), true)]);

        $validator = $this->validateTableRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getTableDataKorutHistoryGetPoint($request, $id));
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    public function print_sales($id)
    {
        $record = ExchangePointSales::with('sales', 'reward_point', 'reward_point.category', 'sales.user')->where('id', $id)->orderBy('created_at', 'DESC')->first();
        $date = date('d F Y');
        $name = $record->sales->user->full_name;
        $pdf  = PDF::loadView('rewardpoint::TukarPoint.pdf.history-point', ['record' => $record, 'date' => $date, 'name' => $name])->setPaper('a4', 'portrait');
        return $pdf->download('History Penukaran Point ' . $date . '.pdf');
    }

    public function print_agent($id)
    {
        $record = ExchangePointSubAgent::with('agency', 'reward_point', 'reward_point.category')->where('id', $id)->orderBy('created_at', 'DESC')->first();
        $date = date('d F Y');
        $name = $record->agency->agency_name;
        $pdf  = PDF::loadView('rewardpoint::TukarPoint.pdf.history-point', ['record' => $record, 'date' => $date, 'name' => $name])->setPaper('a4', 'portrait');
        return $pdf->download('History Penukaran Point ' . $date . '.pdf');
    }

    public function print_korwil($id)
    {
        $record = ExchangePointKoorWilayah::with('regional_coordinator', 'reward_point', 'reward_point.category')->where('id', $id)->orderBy('created_at', 'DESC')->first();
        $date = date('d F Y');
        $name = $record->regional_coordinator->full_name;
        $pdf  = PDF::loadView('rewardpoint::TukarPoint.pdf.history-point', ['record' => $record, 'date' => $date, 'name' => $name])->setPaper('a4', 'portrait');
        return $pdf->download('History Penukaran Point ' . $date . '.pdf');
    }

    public function print_korut($id)
    {
        $record = ExchangePointKoorUmum::with('main_coordinator', 'reward_point', 'reward_point.category')->where('id', $id)->orderBy('created_at', 'DESC')->first();
        $date = date('d F Y');
        $name = $record->main_coordinator->full_name;
        $pdf  = PDF::loadView('rewardpoint::TukarPoint.pdf.history-point', ['record' => $record, 'date' => $date, 'name' => $name])->setPaper('a4', 'portrait');
        return $pdf->download('History Penukaran Point ' . $date . '.pdf');
    }
}

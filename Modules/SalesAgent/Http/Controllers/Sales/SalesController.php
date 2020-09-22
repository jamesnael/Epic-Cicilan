<?php

namespace Modules\SalesAgent\Http\Controllers\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\Sales;
use Modules\Commission\Entities\Commission;
use Modules\SalesAgent\Entities\Agency;
use Modules\SalesAgent\Entities\MainCoordinator;
use Modules\SalesAgent\Entities\RegionalCoordinator;
use Modules\AppUser\Entities\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class SalesController extends Controller
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
            ['href' => route('sales.index'), 'text' => 'Data Sales'],
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
                "text" => 'Koordinator Utama',
                "align" => 'center',
                "sortable" => false,
                "value" => 'main_coordinator_name',
            ],
            [
                "text" => 'Nama User',
                "align" => 'center',
                "sortable" => false,
                "value" => 'full_name',
            ],
            [
                "text" => 'Nama Sub Agent',
                "align" => 'center',
                "sortable" => false,
                "value" => 'agency_name',
            ],
            [
                "text" => 'Email',
                "align" => 'center',
                "sortable" => false,
                "value" => 'email',
            ],
            [
                "text" => 'Nomor HP',
                "align" => 'center',
                "sortable" => false,
                "value" => 'phone_number',
            ]
        ];
        return view('salesagent::sales.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('sales.index'), 'text' => 'Tambah Sales'];

        return view('salesagent::sales.create', [
            'page' => $this
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

            $user = User::create($request->only(['full_name','email','password','phone_number','address','province','city']));
            
            $request->merge([
                'user_id' => $user->id
            ]);

            $data = Sales::create($request->all());

            // $data = Sales::create([
            //     'user_id' => $user->id,
            //     'agency_id' => $request->agency_id,
            //     'sales_nip' => $request->sales_nip
            // ]);

            if ($request->hasFile('file_ktp')) {
                $file_name = 'ktp-' . uniqid() . '.' . $request->file('file_ktp')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('sales/ktp', $request->file('file_ktp'), $file_name
                );
                $data->file_ktp = $file_name;

            }

            // if ($request->hasFile('file_npwp')) {
            //     $file_name = 'npwp-' . uniqid() . '.' . $request->file('file_npwp')->getClientOriginalExtension();
            //     Storage::disk('public')->putFileAs('sales/npwp', $request->file('file_npwp'), $file_name
            //     );
            //     $data->file_npwp = $file_name;
            // }

            $data->save();

            DB::commit();
            return response_json(true, null, 'Data sales berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(User $sales)
    {
        $this->breadcrumbs[] = ['href' => route('sales.edit', [$sales->slug]), 'text' => 'Edit Sales'];

        return view('salesagent::sales.edit', [
            'page' => $this,
            'data' => $sales,
        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, User $sales)
    {
        $validator = $this->validateFormRequest($request, $sales->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $sales->update($request->only(['full_name','email','password','phone_number','address','province','city']));
            $data = $sales->sales;
            
            $data->update($request->all());

            if ($request->hasFile('file_ktp')) {
                $file_name = 'ktp-' . uniqid() . '.' . $request->file('file_ktp')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('sales/ktp', $request->file('file_ktp'), $file_name
                );
                $data->file_ktp = $file_name;

            }

            if ($request->hasFile('file_npwp')) {
                $file_name = 'npwp-' . uniqid() . '.' . $request->file('file_npwp')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('sales/npwp', $request->file('file_npwp'), $file_name
                );
                $data->file_npwp = $file_name;
            }

            $data->save();
            DB::commit();
            return response_json(true, null, 'Data sales berhasil disimpan.', $data);
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
    public function destroy(User $sales)
    {
        DB::beginTransaction();
        try {
            $sales->sales->delete();
            $sales->delete();
            DB::commit();
            return response_json(true, null, 'Data sales berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
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
            'agency' => Agency::select('id AS value', 'agency_name AS text','regional_coordinator_id')->get(),
            'main_coordinator' => MainCoordinator::select('id AS value', 'full_name AS text')->get(),
            'regional_coordinator' => RegionalCoordinator::select('id AS value', 'full_name AS text', 'main_coordinator_id')->get(),
            'regional_coordinator_commission' => Commission::select('id AS value', 'regional_coordinator_commission AS text')->get(),
            'main_coordinator_commission' => Commission::select('id AS value', 'main_coordinator_commission AS text')->get(),
            'agency_commission' => Commission::select('id AS value', 'agency_commission AS text')->get(),
            'sales_commission' => Commission::select('id AS value', 'sales_commission AS text', 'agency_commission', 'main_coordinator_commission', 'regional_coordinator_commission')->get()
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
    public function getTableData(Request $request)
    {
        $query = User::has('sales')->with('sales.agency', 'sales.main_coordinator');
        // select(
        //     'users.slug',
        //     'users.full_name',
        //     'users.email',
        //     'users.phone_number',
        //     'agencies.agency_name',
        //     'main_coordinators.full_name AS main_coordinator_name'
        // );

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%')
                ->orWhere('email', 'LIKE', '%' . $generalSearch . '%')
                ->orWhere('phone_number', 'LIKE', '%' . $generalSearch . '%')
                ->orWhereHas('sales.agency', function(Builder $subquery) use ($generalSearch) {
                    $subquery->where('agency_name', 'LIKE', '%' . $generalSearch . '%');
                })
                ->orWhereHas('sales.main_coordinator', function(Builder $subquery) use ($generalSearch) {
                    $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
                });
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));

        $data->getCollection()->transform(function($item) {
            $item->agency_name = $item->sales->agency->agency_name;
            $item->main_coordinator_name = $item->sales->main_coordinator->full_name;
            return $item;
        });

        return $data;

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     if ($sort[0] == 'agency_name') {
        //         $query->orderBy('agencies.agency_name', $sort[1] ? 'desc' : 'asc');
        //     } else {
        //         $query->orderBy('users.'.$sort[0], $sort[1] ? 'desc' : 'asc');
        //     }
        // }
        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
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
    public function data(User $sales)
    {
        $data = [
            'agency_id' => $sales->sales->agency_id,
            'main_coordinator_id' => $sales->sales->main_coordinator_id,
            'regional_coordinator_id' => $sales->sales->regional_coordinator_id,
            'sales_commission' => $sales->sales->sales_commission,
            'agency_commission' => $sales->sales->agency_commission,
            'regional_coordinator_commission' => $sales->sales->regional_coordinator_commission,
            'main_coordinator_commission' => $sales->sales->main_coordinator_commission,
            'sales_nip' => $sales->sales->sales_nip,
            'no_ktp' => $sales->sales->no_ktp,
            'status' => $sales->sales->status,
            'file_ktp' => $sales->sales->file_ktp,
            'url_file_ktp' => $sales->sales->url_file_ktp,
            // 'file_npwp' => $sales->sales->file_npwp,
            // 'url_file_npwp' => $sales->sales->url_file_npwp,
            'full_name' => $sales->full_name,
            'email' => $sales->email,
            'phone_number' => $sales->phone_number,
            'address' => $sales->address,
            'province' => $sales->province,
            'city' => $sales->city,
            'role_id' => $sales->role_id,
        ];
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
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
            "agency_id" => "bail|required|exists:Modules\SalesAgent\Entities\Agency,id",
            "sales_nip" => "bail|nullable|string|max:255",
            "file_ktp" => "bail|nullable|image",
            "file_npwp" => "bail|nullable|image",
            "full_name" => "bail|required|string|max:255",
            "email" => "bail|required|email|unique:Modules\AppUser\Entities\User,email,$id,id,deleted_at,NULL",
            "phone_number" => "bail|required|string|max:255",
            "address" => "bail|nullable|string|max:255",
            "province" => "bail|nullable|string|max:255",
            "city" => "bail|nullable|string|max:255",
        ]);
    }

}

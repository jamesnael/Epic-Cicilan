<?php

namespace Modules\SalesAgent\Http\Controllers\RegionalCoordinator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\RegionalCoordinator;
use Modules\SalesAgent\Entities\MainCoordinator;
use Modules\AppUser\Entities\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegionalCoordinatorController extends Controller
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
            ['href' => route('regional-coordinator.index'), 'text' => 'Data Koordinator Wilayah'],
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
                "value" => 'main_coordinator.full_name',
            ],
            [
                "text" => 'Nama',
                "align" => 'center',
                "sortable" => false,
                "value" => 'full_name',
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
            ],
            [
                "text" => 'Alamat',
                "align" => 'center',
                "sortable" => false,
                "value" => 'address',
            ],
            [
                "text" => 'PPH Final',
                "align" => 'center',
                "sortable" => false,
                "value" => 'pph_final',
            ],
        ];
        return view('salesagent::regional-coordinator.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('regional-coordinator.index'), 'text' => 'Tambah Koordinator Wilayah'];

        return view('salesagent::regional-coordinator.create', [
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

            $request->merge([
                'status' => 'koordinator_wilayah'
            ]);

            $user = User::create($request->only(['full_name','email','password','phone_number','address','province','city','sales','status']));

            $request->merge([
                'user_id' => $user->id
            ]);

            $data = RegionalCoordinator::create($request->all());

            DB::commit();
            return response_json(true, null, 'Data koordinator wilayah berhasil disimpan.', $data);
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
    public function edit(RegionalCoordinator $regional_coordinator)
    {
        $this->breadcrumbs[] = ['href' => route('regional-coordinator.edit', [$regional_coordinator->slug]), 'text' => 'Edit Koordinator Wilayah ' . $regional_coordinator->full_name];

        return view('salesagent::regional-coordinator.edit', [
            'page' => $this,
            'data' => $regional_coordinator
        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, RegionalCoordinator $regional_coordinator)
    {
        $validator = $this->validateFormRequest($request, $regional_coordinator->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $regional_coordinator->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data koordinator wilayah berhasil disimpan.', $data);
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
    public function destroy(RegionalCoordinator $regional_coordinator)
    {
        DB::beginTransaction();
        try {
            $regional_coordinator->delete();
            DB::commit();
            return response_json(true, null, 'Data koordinator wilayah berhasil dihapus.');
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

        if ($user->is_admin == '1' || $user->status == 'koordinator_utama') {
            $query = RegionalCoordinator::with('main_coordinator');
        }elseif ($user->status == 'koordinator_wilayah') {
            $query = RegionalCoordinator::with('main_coordinator')->where('user_id', $user->id);
        }else{
            $query = RegionalCoordinator::with('main_coordinator');
        }

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%')
                         ->orWhere('email', 'LIKE', '%' . $generalSearch . '%')
                         ->orWhere('phone_number', 'LIKE', '%' . $generalSearch . '%')
                         ->orWhere('address', 'LIKE', '%' . $generalSearch . '%');
            });

            $query->orWhereHas('main_coordinator', function($subquery) use ($generalSearch){
                $subquery->where('full_name', 'LIKE', '%'.$generalSearch.'%');
            });

        }

        if ($request->input('sort') != []) {
            foreach ($request->input('sort') as $sort_key => $sort) {
                
                if ($sort[0] == 'main_coordinator.full_name') {

                    $query->join('main_coordinators', 'regional_coordinators.main_coordinator_id', '=', 'main_coordinators.id')
                          ->select('regional_coordinators.*', 'main_coordinators.full_name AS main_coordinators_name');
                    $query->orderBy('main_coordinators_name', $sort[1] ? 'desc' : 'asc');

                } else {
                     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
                }
            }
        }else{
            $query->orderBy('created_at', 'DESC');
        }


        // if ($request->input('sort')) {
        //     foreach ($request->input('sort') as $sort_key => $sort) {
        //         if ($sort[0] == 'main_coordinator.full_name') {

        //             // $query->join('main_coordinators', 'regional_coordinators.main_coordinator_id', '=', 'main_coordinators.id')
        //             //       ->orderBy('full_name', $sort[1] ? 'desc' : 'asc');

        //             // $query->join()
        //             $query->orderBy('main_coordinators.full_name', $sort[1] ? 'desc' : 'asc');
        //         }
        //         else {
        //             $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        //         }
        //     }
        // }else{
        //     $query->orderBy('created_at', 'DESC');
        // }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->pph_final = $item->pph_final . ' %';
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
    public function data(RegionalCoordinator $regional_coordinator)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $regional_coordinator);
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
            "full_name" => "bail|required|string|max:255",
            "email" => "bail|required|email|unique:Modules\AppUser\Entities\User,email,$id,id,deleted_at,NULL",
            "phone_number" => "bail|required|numeric",
            "address" => "bail|nullable|string|max:255",
        ]);
    }

    /**
     *
     * Return Form Helper
     *
     */
    public function getHelper()
    {
        return [
            'main_coordinator' => MainCoordinator::select('id AS value', 'full_name AS text')->get()
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

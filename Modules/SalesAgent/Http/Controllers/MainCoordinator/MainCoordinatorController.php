<?php

namespace Modules\SalesAgent\Http\Controllers\MainCoordinator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\MainCoordinator;
use Modules\AppUser\Entities\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MainCoordinatorController extends Controller
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
            ['href' => route('main-coordinator.index'), 'text' => 'Data Koordinator Utama'],
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
                "text" => 'Nomor Telepon',
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
        return view('salesagent::main-coordinator.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('main-coordinator.index'), 'text' => 'Tambah Koordinator Utama'];

        return view('salesagent::main-coordinator.create', [
            'page' => $this,
        ]);
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
                'status' => 'koordinator_utama'
            ]);

            $user = User::create($request->only(['full_name','email','password','phone_number','address','province','city','sales','status']));

            $request->merge([
                'user_id' => $user->id
            ]);

            $data = MainCoordinator::create($request->all());
            
            activity()
               ->performedOn($data)
               ->causedBy(\Auth::user())
               ->log('Koordinator utama baru berhasil dibuat');

            DB::commit();
            return response_json(true, null, 'Data koordinator utama berhasil disimpan.', $data);
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
    public function edit(MainCoordinator $main_coordinator)
    {
        $this->breadcrumbs[] = ['href' => route('main-coordinator.edit', [$main_coordinator->slug]), 'text' => 'Edit Koordinator Utama ' . $main_coordinator->full_name];

        return view('salesagent::main-coordinator.edit', [
            'page' => $this,
            'data' => $main_coordinator
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, MainCoordinator $main_coordinator)
    {
        $validator = $this->validateFormRequest($request, $main_coordinator->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $old =  MainCoordinator::where('slug', $main_coordinator->slug)->get();
            $data = $main_coordinator->update($request->all());

            activity()
                ->performedOn($main_coordinator)
                ->causedBy(\Auth::user())
                ->withProperties(['new' => $main_coordinator, 'old' => $old])
                ->log('Koordinator utama berhasil diubah');

            DB::commit();
            return response_json(true, null, 'Data koordinator utama berhasil disimpan.', $data);
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
    public function destroy(MainCoordinator $main_coordinator)
    {
        DB::beginTransaction();
        try {

            activity()
                ->causedBy(\Auth::user())
                ->withProperties(['koordinator utama' => $main_coordinator])
                ->log('Koordinator utama berhasil dihapus');

            $main_coordinator->delete();
            DB::commit();
            return response_json(true, null, 'Data koordinator utama berhasil dihapus.');
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
        $query = MainCoordinator::orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('email', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('phone_number', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('address', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        // foreach ($request->input('sort') as $sort_key => $sort) {
        //     $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
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
    public function data(MainCoordinator $main_coordinator)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $main_coordinator);
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
}

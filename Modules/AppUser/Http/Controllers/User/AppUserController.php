<?php

namespace Modules\AppUser\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AppUser\Entities\User;
use Modules\AppUser\Entities\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AppUserController extends Controller
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
            ['href' => route('users.index'), 'text' => 'Data User'],
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
                "text" => 'Nama User',
                "align" => 'center',
                "sortable" => false,
                "value" => 'full_name',
            ],
            [
                "text" => 'Hak Akses',
                "align" => 'center',
                "sortable" => false,
                "value" => 'role_name',
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
            ]
           
        ];
        return view('appuser::user.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('users.index'), 'text' => 'Tambah User'];

        return view('appuser::user.create', [
            'page' => $this,
            'role' => Role::select('id AS value', 'role_name AS text')->get(),
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
            if ($request->role_id == '5') {
                $request->merge(['is_admin' => true]);
            }
            $data = User::create($request->all());
            DB::commit();
            return response_json(true, null, 'Data user berhasil disimpan.', $data);
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
    public function edit(User $user)
    {
        $this->breadcrumbs[] = ['href' => route('users.edit', [$user->slug]), 'text' => 'Edit User ' . $user->full_name];

        return view('appuser::user.edit', [
            'page' => $this,
            'data' => $user,
            'role' => Role::select('id AS value', 'role_name AS text')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $validator = $this->validateFormRequest($request, $user->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            if ($request->role_id == '5') {
                $request->merge(['is_admin' => true]);
            }
            $data = $user->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data user berhasil disimpan.', $data);
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
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return response_json(true, null, 'Data user berhasil dihapus.');
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
        // $query = User::doesntHave('sales')->with('role');
        $query = User::with('role')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('email', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('address', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->role_name = $item->role ? $item->role->role_name : '';
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
    public function data(User $users)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $users);
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
            "role_id" => "bail|nullable|exists:Modules\AppUser\Entities\Role,id",
            "full_name" => "bail|required|string|max:255",
            "email" => "bail|required|email|unique:Modules\AppUser\Entities\User,email,$id,id,deleted_at,NULL",
            "phone_number" => "bail|required|numeric",
            "address" => "bail|nullable|string|max:255",
            "province" => "bail|nullable|string|max:255",
            "city" => "bail|nullable|string|max:255",
        ]);
    }
   
}
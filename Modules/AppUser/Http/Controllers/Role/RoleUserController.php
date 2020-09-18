<?php

namespace Modules\AppUser\Http\Controllers\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AppUser\Entities\User;
use Modules\AppUser\Entities\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'])->except(['data']);
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('role.index'), 'text' => 'Hak Akses User'],
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
                "sortable" => true,
                "value" => 'full_name',
            ],
            // [
            //     "text" => 'Hak Akses',
            //     "align" => 'center',
            //     "sortable" => true,
            //     "value" => 'role.role_name',
            // ],
            [
                "text" => 'Email',
                "align" => 'center',
                "sortable" => true,
                "value" => 'email',
            ],
            [
                "text" => 'Nomor Telepon',
                "align" => 'center',
                "sortable" => true,
                "value" => 'phone_number',
            ],
            [
                "text" => 'Alamat',
                "align" => 'center',
                "sortable" => true,
                "value" => 'address',
            ]
           
        ];
        return view('appuser::role.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('role.index'), 'text' => 'Tambah Hak Akses User'];

        return view('appuser::role.create', [
            'page' => $this,
            'role' => Role::select('id AS value', 'role_name AS text')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(User $role)
    {
        $path = storage_path() . "/app/public/app-access.json";
        $hak_akses = json_decode(file_get_contents($path), true);

        $this->breadcrumbs[] = ['href' => route('role.edit', [$role->slug]), 'text' => 'Ubah Hak Akses User ' . $role->full_name];

        return view('appuser::role.edit', [
            'page' => $this,
            'data' => $role,
            'role' => Role::select('id AS value', 'role_name AS text')->get(),
            'menu' => $hak_akses,

        ]);
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        // $request->merge(['hak_akses' => json_decode($request->input('hak_akses'), true)]);
        return Validator::make($request->all(), [
            "hak_akses" => "bail|present|array",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $role)
    {
        $validator = $this->validateFormRequest($request, $role->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $hak_akses = json_encode($request->input('hak_akses'), true);
            $data = collect($hak_akses)->implode(','); 
            $request->merge(['user_access' => $data]);
            $role->update($request->only(["user_access"]));

            DB::commit();
            return response_json(true, null, 'Hak akses user berhasil disimpan.', $role);
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
        $query = User::doesntHave('sales')->with('role');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('full_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('email', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('address', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('pph_final', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

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
    public function data(User $role)
    {
        try {
            $hak_akses = $role->user_access;
            return response_json(true, null, 'Sukses mengambil data.', $role, $hak_akses);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

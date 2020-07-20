<?php

namespace Modules\SalesAgent\Http\Controllers\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\Sales;
use Modules\SalesAgent\Entities\Agency;
use Modules\AppUser\Entities\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
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
                "text" => 'Nama User',
                "align" => 'center',
                "sortable" => true,
                "value" => 'full_name',
            ],
            [
                "text" => 'Nama Agensi',
                "align" => 'center',
                "sortable" => true,
                "value" => 'sales.agency.agency_name',
            ],
            [
                "text" => 'Email',
                "align" => 'center',
                "sortable" => true,
                "value" => 'email',
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
            $data = Sales::create([
                'user_id' => $user->id,
                'agency_id' => $request->agency_id,
                'sales_nip' => $request->sales_nip
            ]);

            if ($request->hasFile('file_ktp')) {
                $file_name = 'ktp-' . $data->slug . '.' . $request->file('file_ktp')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('sales/', $request->file('file_ktp'), $file_name
                );
                $data->file_ktp = $file_name;

            }

            if ($request->hasFile('file_npwp')) {
                $file_name = 'npwp-' . $data->slug . '.' . $request->file('file_npwp')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('sales/', $request->file('file_npwp'), $file_name
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
        $validator = $this->validateFormRequest($request, $sale->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $sale->update($request->all());
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
    public function destroy(User $sale)
    {
        DB::beginTransaction();
        try {
            $sale->delete();
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
            'agency' => Agency::select('id AS value', 'agency_name AS text')->get(),
            'user' => User::select('id AS value', 'full_name AS text')->get()
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
        $query = User::has('sales')->with('sales.agency');
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
    public function data(User $sales)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $sales);
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
            "user_id" => "bail|nullable|exists:Modules\AppUser\Entities\User,id",
            "agency_id" => "bail|required|exists:Modules\SalesAgent\Entities\Agency,id",
            "sales_nip" => "bail|required|numeric",
            "file_ktp" => "bail|nullable|image",
            "file_npwp" => "bail|nullable|image",
            "full_name" => "bail|required|string|max:255",
            "email" => "bail|required|email|unique:Modules\AppUser\Entities\User,email,$id,id,deleted_at,NULL",
            "phone_number" => "bail|nullable|numeric",
            "address" => "bail|nullable|string|max:255",
            "province" => "bail|nullable|string|max:255",
            "city" => "bail|nullable|string|max:255",
        ]);
    }

}

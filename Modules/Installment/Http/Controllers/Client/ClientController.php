<?php

namespace Modules\Installment\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
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
            ['href' => route('client.index'), 'text' => 'Data Klien'],
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
                "text" => 'ID Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_number',
            ],
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
            ],
            [
                "text" => 'Pekerjaan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'profession',
            ],
            [
                "text" => 'No Handphone',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_mobile_number',
            ],
            [
                "text" => 'Email',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_email',
            ],
            [
                "text" => 'No.Telepon',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_phone_number',
            ]
        ];
        return view('installment::client.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('client.index'), 'text' => 'Tambah Klien'];

        return view('installment::client.create', [
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
                'client_number' => date('Y').date('m').date('d').sprintf("%06d", Client::count() + 1),
            ]);

            $data = Client::create($request->all());
            DB::commit();
            
            return response_json(true, null, 'Data klien berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

   /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Responsec
     */
    public function edit(Client $client)
    {
        $this->breadcrumbs[] = ['href' => route('client.edit', [$client->slug]), 'text' => 'Edit Klien ' . $client->client_name];

        return view('installment::client.edit', [
            'page' => $this,
            'data' => $client,

        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Client $client)
    {
        $validator = $this->validateFormRequest($request, $client->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $client->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data klien berhasil disimpan.', $data);
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
    public function destroy(Client $client)
    {
        DB::beginTransaction();
        try {
            $client->delete();
            DB::commit();
            return response_json(true, null, 'Data klien berhasil dihapus.');
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
        $query = Client::query();

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                $subquery->where('client_name', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('client_email', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('client_address', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('client_phone_number', 'LIKE', '%' . $generalSearch . '%');
                $subquery->orWhere('client_mobile_number', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
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
    public function data(Client $client)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $client);
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
            "client_name" => "bail|required|string|max:255",
            "client_email" => "bail|required|email",
            "client_phone_number" => "bail|nullable|string|max:255",
            "client_mobile_number" => "bail|required|string|max:255",
            "client_address" => "bail|nullable|string|max:255",
            "profession" => "bail|required|string|max:255"
        ]);
    }
}

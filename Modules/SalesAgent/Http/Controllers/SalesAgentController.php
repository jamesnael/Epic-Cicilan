<?php

namespace Modules\SalesAgent\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SalesAgent\Entities\Agency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SalesAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('salesagent::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['url' => route('salesagent.index'), 'title' => 'Data Sales Agency'];
        $this->breadcrumbs[] = ['url' => route('salesagent.index'), 'title' => 'Tambah Sales Agency'];

        return view('salesagent::create', [
            'page' => $this,
        ]);
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "agency_name" => "bail|required|max:255",
            "agency_email" => "bail|required|required|email",
            "agency_phone" => "bail|required|numeric",
            "agency_address" => "bail|required",
            "province" => "bail|required|max:255",
            "city" => "bail|required|max:255",
        ], [
            "agency_name.required" => __('validation.required', ['attribute' => 'nama agen']),
            "agency_name.max" => __('validation.max.string', ['attribute' => 'nama agen', 'max' => '255']),
            "agency_phone.required" => __('validation.required', ['attribute' => 'nomor telepon']),
            "agency_phone.numeric" => __('validation.numeric', ['attribute' => 'nomor telepon']),
            "agency_email.required" => __('validation.required', ['attribute' => 'alamat e-mail']),
            "agency_email.email" => __('validation.email', ['attribute' => 'alamat e-mail']),
            "agency_address.required"=> __('validation.required', ['attribute' => 'alamat agen']),
            "province.required"=> __('validation.required', ['attribute' => 'provinsi']),
            "city.required"=> __('validation.required', ['attribute' => 'kota']),
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
            $data = Agency::create($request->all());
            DB::commit();
            return response_json(true, null, 'Data agen berhasil disimpan.', $data);
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
        return view('salesagent::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Agency $salesagent)
    {
        $this->breadcrumbs[] = ['url' => route('salesagent.index'), 'title' => 'Data Sales Agency'];
        $this->breadcrumbs[] = ['url' => route('salesagent.edit', [$salesagent->slug]), 'title' => 'Edit Sales Agency ' . $salesagent->agency_name];

        return view('salesagent::edit', [
            'page' => $this,
            'data' => $salesagent
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Agency $salesagent)
    {
        $validator = $this->validateFormRequest($request, $salesagent->id);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = $salesagent->update($request->all());
            DB::commit();
            return response_json(true, null, 'Data agen berhasil disimpan.', $data);
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
    public function destroy(Agency $salesagent)
    {
        DB::beginTransaction();
        try {
            $salesagent->delete();
            DB::commit();
            return response_json(true, null, 'Data agen berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

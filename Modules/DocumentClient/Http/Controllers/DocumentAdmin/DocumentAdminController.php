<?php

namespace Modules\DocumentClient\Http\Controllers\DocumentAdmin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\DocumentClient\Entities\DocumentClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DocumentAdminController extends Controller
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
            ['href' => route('document-admin.index'), 'text' => 'Data Dokumen Admin'],
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
                "text" => 'Nama Debitur',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_name',
            ],
            [
                "text" => 'Pekerjaan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'client_profesion',
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
                "value" => 'unit_price',
            ],
            [
                "text" => 'Tgl Pengajuan',
                "align" => 'center',
                "sortable" => true,
                "value" => 'submission_date',
            ],
        ];
        return view('documentclient::document-admin.index', [
            'page' => $this,
        ]);
    }


    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {   
        $this->breadcrumbs[] = ['href' => route('document-admin.index'), 'text' => 'Tambah Dokumen Admin'];

        return view('documentclient::document-admin.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }

     /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "booking_id" => "bail|required",
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
        return $request->all();
        
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data = DocumentClient::create($request->all());

            DB::commit();
            return response_json(true, null, 'Data dokumen klien berhasil disimpan.', $data);
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
        return view('document::show');
    }

     /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Booking $document_admin)
    {
        $this->breadcrumbs[] = ['href' => route('document-admin.index'), 'text' => 'Edit Dokumen'];

        return view('documentclient::document-admin.edit',[
            'page' => $this,
            'data' => $document_admin,
        ])->with($this->getHelper());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Booking $document_admin)
    {

        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return response_json(false, 'Isian form salah', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

            if ($request->hasFile('ktp_pemohon')) {
                $file_name_ktp = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('ktp_pemohon')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/ktp_pemohon', $request->file('ktp_pemohon'), $file_name_ktp
                );
                $request->merge([
                    'file_ktp_pemohon' => $file_name_ktp,
                ]);
            }

            if ($request->hasFile('ktp_suami_istri')) {
                $file_name_suami_istri = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('ktp_suami_istri')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/ktp_suami_istri', $request->file('ktp_suami_istri'), $file_name_suami_istri
                );
                $request->merge([
                    'file_ktp_suami_istri' => $file_name_suami_istri,
                ]);
            }

            if ($request->hasFile('npwp')) {
                $file_name_npwp = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('npwp')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/npwp', $request->file('npwp'), $file_name_npwp
                );
                $request->merge([
                    'file_npwp' => $file_name_npwp,
                ]);
            }

            if ($request->hasFile('kk')) {
                $file_name_kk = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('kk')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/kk', $request->file('kk'), $file_name_kk
                );
                $request->merge([
                    'file_kk' => $file_name_kk,
                ]);
            }

            if ($request->hasFile('surat_nikah')) {
                $file_name_surat_nikah = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('surat_nikah')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/surat_nikah', $request->file('surat_nikah'), $file_name_surat_nikah
                );
                $request->merge([
                    'file_surat_nikah' => $file_name_surat_nikah,
                ]);
            }

            if ($request->hasFile('rekening_tabungan')) {
                $file_name_rekening_tabungan = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('rekening_tabungan')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/rekening_tabungan', $request->file('rekening_tabungan'), $file_name_rekening_tabungan
                );
                $request->merge([
                    'file_rekening_tabungan' => $file_name_rekening_tabungan,
                ]);
            }

            if ($request->hasFile('slip_gaji')) {
                $file_name_slip_gaji = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('slip_gaji')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/slip_gaji', $request->file('slip_gaji'), $file_name_slip_gaji
                );
                $request->merge([
                    'file_slip_gaji' => $file_name_slip_gaji,
                ]);
            }

            if ($request->hasFile('izin_praktek')) {
                $file_name_izin_praktek = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('izin_praktek')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/izin_praktek', $request->file('izin_praktek'), $file_name_izin_praktek
                );
                $request->merge([
                    'file_izin_praktek' => $file_name_izin_praktek,
                ]);
            }

            if ($request->hasFile('rekening_koran')) {
                $file_name_rekening_koran = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('rekening_koran')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/rekening_koran', $request->file('rekening_koran'), $file_name_rekening_koran
                );
                $request->merge([
                    'file_rekening_koran' => $file_name_rekening_koran,
                ]);
            }

            if ($request->hasFile('siup')) {
                $file_name_siup = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('siup')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/siup', $request->file('siup'), $file_name_siup
                );
                $request->merge([
                    'file_siup' => $file_name_siup,
                ]);
            }

            if ($request->hasFile('tdp')) {
                $file_name_tdp = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('tdp')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/tdp', $request->file('tdp'), $file_name_tdp
                );
                $request->merge([
                    'file_tdp' => $file_name_tdp,
                ]);
            }

            if ($request->hasFile('akta')) {
                $file_name_akta = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('akta')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/akta', $request->file('akta'), $file_name_akta
                );
                $request->merge([
                    'file_akta' => $file_name_akta,
                ]);
            }

            if ($request->hasFile('pengesahan')) {
                $file_name_pengesahan = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('pengesahan')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/pengesahan', $request->file('pengesahan'), $file_name_pengesahan
                );
                $request->merge([
                    'file_pengesahan' => $file_name_pengesahan,
                ]);
            }

            if ($request->hasFile('izin_praktek')) {
                $file_name_izin_praktek = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('izin_praktek')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/izin_praktek', $request->file('izin_praktek'), $file_name_izin_praktek
                );
                $request->merge([
                    'file_izin_praktek' => $file_name_izin_praktek,
                ]);
            }

            if ($request->hasFile('sk_domisili')) {
                $file_name_sk_domisili = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('sk_domisili')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/sk_domisili', $request->file('sk_domisili'), $file_name_sk_domisili
                );
                $request->merge([
                    'file_sk_domisili' => $file_name_sk_domisili,
                ]);
            }

            if ($request->hasFile('keterangan_usaha')) {
                $file_name_keterangan_usaha = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('keterangan_usaha')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/keterangan_usaha', $request->file('keterangan_usaha'), $file_name_keterangan_usaha
                );
                $request->merge([
                    'file_keterangan_usaha' => $file_name_keterangan_usaha,
                ]);
            }

            if ($request->hasFile('spt')) {
                $file_name_spt = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('spt')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/spt', $request->file('spt'), $file_name_spt
                );
                $request->merge([
                    'file_spt' => $file_name_spt,
                ]);
            }

            if ($request->hasFile('keterangan_kerja')) {
                $file_name_keterangan_kerja = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('keterangan_kerja')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/keterangan_kerja', $request->file('keterangan_kerja'), $file_name_keterangan_kerja
                );
                $request->merge([
                    'file_keterangan_kerja' => $file_name_keterangan_kerja,
                ]);
            }

            if ($request->hasFile('tabungan_3_bulan_terakhir')) {
                $file_name_tabungan_3_bulan_terakhir = $request->input('booking_id').'_'.uniqid() . '.' . $request->file('tabungan_3_bulan_terakhir')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs(
                    'document/tabungan_3_bulan_terakhir', $request->file('tabungan_3_bulan_terakhir'), $file_name_tabungan_3_bulan_terakhir
                );
                $request->merge([
                    'file_tabungan_3_bulan_terakhir' => $file_name_tabungan_3_bulan_terakhir,
                ]);
            }

            $request->merge([
                'submission_date' => \Carbon\Carbon::parse($request->submission_date)->format('Y-m-d'),
            ]);

            $has_document = DocumentClient::where('booking_id', $request->booking_id)->first();

            if ($has_document) {
                 $data = $has_document->update($request->all());
            }else{
                $data = DocumentClient::create($request->all());
            }

            DB::commit();
            return response_json(true, null, 'Data dokumen klien berhasil disimpan.', $data);
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
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
        $query = Booking::with('client', 'unit', 'document')->orderBy('created_at', 'DESC');

        if ($request->input('search')) {
            $generalSearch = $request->input('search');

            $query->where(function($subquery) use ($generalSearch) {
                // $subquery->where('installment', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('due_date', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('dp_amount', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('total_amount', 'LIKE', '%' . $generalSearch . '%');
                // $subquery->orWhere('point', 'LIKE', '%' . $generalSearch . '%');
            });
        }

        foreach ($request->input('sort') as $sort_key => $sort) {
            $query->orderBy($sort[0], $sort[1] ? 'desc' : 'asc');
        }

        $data = $query->paginate($request->input('paginate') == '-1' ? 100000 : $request->input('paginate'));
        $data->getCollection()->transform(function($item) {
            $item->submission_date = $item->document ? \Carbon\Carbon::parse($item->document->submission_date)->locale('id')->translatedFormat('d F Y') : '';
            $item->client_name = $item->client->client_name;
            $item->client_profesion = $item->client->profession;
            $item->unit_number = $item->unit->unit_number .'/'. $item->unit->unit_block ;
            $item->unit_price = 'Rp '.format_money($item->total_amount);
            
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
     * Return Form Helper
     *
     */
    public function getHelper()
    {
        return [
            'client' => Client::select('id AS value', 'client_name AS text', 'client_number', 'client_email', 'client_address', 'client_phone_number', 'client_mobile_number','profession')->get(),
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
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $document_admin)
    {
        $data = $document_admin->load('unit','client', 'document');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }
}

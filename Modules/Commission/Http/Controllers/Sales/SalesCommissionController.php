<?php

namespace Modules\Commission\Http\Controllers\Sales;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Commission\Entities\Commission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SalesCommissionController extends Controller
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
            ['href' => route('salescommission.index'), 'text' => 'Data Komisi Penjualan'],
        ];
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->table_headers = [
            [
                "text" => 'Nama Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Koordinator Wilayah',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Tanggal Transaksi',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Data Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Harga Pricelist',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Cara Bayar',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Type Komisi',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Komisi Koordinator Utama',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Komisi Bruto Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Total Komisi(PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Komisi Bruto Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Total Komisi Sub Agent (PPH Final + PPH 21)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Pencairan 1 (50%)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Pencairan 2 (50%)',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
        ];
        return view('commission::salescommission.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('salescommission.index'), 'text' => 'Tambah Komisi'];

        return view('commission::salescommission.create', [
            'page' => $this,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('commission::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('commission::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace Modules\Installment\Http\Controllers\Spr;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\SalesAgent\Entities\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SprController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('spr.index'), 'text' => 'Data SPR'],
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
                "text" => 'Nama Klien',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Unit',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Sales',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Tanggal Cetak',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Tanggal Kirim',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Tanggal Terima',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
        ];
        return view('installment::spr.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('spr.index'), 'text' => 'Tambah SPR'];

        return view('installment::spr.create', [
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
        return view('installment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('installment::edit');
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

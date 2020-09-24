<?php

namespace App\Exports;

use Modules\Installment\Entities\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class InstallmentReport implements FromView
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data, $from_date, $until_date)
    {
        $this->data       = $data;
        $this->from_date  = $from_date;
        $this->until_date = $until_date;
    }

    public function view(): View
    {
        return view('installment::report.report', [
            'data'       => $this->data,
            'from_date'  => $this->from_date,
            'until_date' => $this->until_date,
        ]);
    }
}

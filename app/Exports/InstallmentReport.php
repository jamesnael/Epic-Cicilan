<?php

namespace App\Exports;

use Modules\Installment\Entities\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InstallmentReport implements FromView, ShouldAutoSize
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data, $from_date, $until_date, $max_installment)
    {
        $this->data            = $data;
        $this->from_date       = $from_date;
        $this->until_date      = $until_date;
        $this->max_installment = $max_installment;
    }

    public function view(): View
    {
        return view('installment::report.report', [
            'data'            => $this->data,
            'from_date'       => $this->from_date,
            'until_date'      => $this->until_date,
            'max_installment' => $this->max_installment,
        ]);
    }
}

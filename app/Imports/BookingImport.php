<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\RewardPoint\Entities\Point;
use Modules\Installment\Entities\Unit;
use Modules\SalesAgent\Entities\MainCoordinator;
use Modules\SalesAgent\Entities\RegionalCoordinator;
use Modules\SalesAgent\Entities\Agency;

class BookingImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
	   	 	if($row->filter()->isNotEmpty()){
	 			$unit_type = Point::firstOrCreate(['building_type' => $row[0]], ['point' => $row[5] , 'closing_fee' => $row[6]]);
	 			$unit = Unit::create([
 					'unit_type' => $unit_type->building_type,
 					'unit_number' => $row[2],
 					'unit_block' => $row[1],
 					'surface_area' => $row[3],
 					'building_area' => $row[4],
 					'points' => $unit_type->point,
 					'closing_fee' => $unit_type->closing_fee,
 				    'id_unit_type' => $unit_type->id,
	 			]);
	 			if ($row[15]) {
	 				$main_coord = MainCoordinator::firstOrCreate(['full_name' => $row[15]], ['pph_final' => 0]);
	 			}
	 			if ($row[14]) {
	 				$regional_coord = RegionalCoordinator::firstOrCreate(['full_name' => $row[14]], ['main_coordinator_id' => $main_regional ?? null]);
	 			}
	 			if ($row[13]) {
	 				$regional_coord = Agency::firstOrCreate(['agency_name' => $row[13]], ['main_coordinator_id' => $main_regional ?? null]);
	 			}
	   		}
    	}
    }

    public function startRow(): int
    {
        return 3;
    }
}

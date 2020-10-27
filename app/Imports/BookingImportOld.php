<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Modules\Installment\Entities\Cluster;
use Modules\RewardPoint\Entities\Point AS BuildingType;
use Modules\AppUser\Entities\User;
use Modules\SalesAgent\Entities\Sales;
use Modules\SalesAgent\Entities\Agency;
use Modules\SalesAgent\Entities\RegionalCoordinator;
use Modules\SalesAgent\Entities\MainCoordinator;
use Modules\Installment\Entities\Unit;
use Modules\Installment\Entities\Client;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\BookingPayment;
use Modules\Installment\Entities\TipeProgram;
use Modules\Installment\Entities\Spr;

class BookingImport implements ToCollection, WithStartRow, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
	   	 	if($row->filter()->isNotEmpty()){
	 			$cluster = Cluster::firstOrCreate(['cluster_name' => $row['cluster']]);
	 			$unit_type = BuildingType::firstOrCreate([
	 				'cluster_id' => $cluster->id, 
	 				'building_type' => $row['type']
	 			], [
	 				'point' => $row['point'] ?? 0, 
	 				'closing_fee' => $row['jumlah_cf_sales']
	 			]);
 				$user_korut = User::firstOrCreate([
 					'full_name' => $row['korut'], 
 					'email' => $row['korut_email']
 				], [
 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
 				]);
 				$korut = MainCoordinator::firstOrCreate([
 					'user_id' => $user_korut->id,
 					'full_name' => $row['korut'],
 					'email' => $row['korwil_email']
 				], [
 					'user_id' => $user_korut->id ?? null
 				]);
	 			if ($row['korwil']) {
	 				$user_korwil = User::firstOrCreate([
	 					'full_name' => $row['korwil'], 
	 					'email' => $row['korwil_email']
	 				], [
	 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
	 				]);
	 				$korwil = RegionalCoordinator::firstOrCreate([
	 					'user_id' => $user_korwil->id,
	 					'full_name' => $row['korwil'],
	 					'email' => $row['korwil_email']
	 				], [
	 					'user_id' => $user_korwil->id ?? null,
	 					'main_coordinator_id' => $korut->id ?? null
	 				]);
	 			}
	 			if ($row['kantor_agentsub_agent']) {
	 				$user_sub_agent = User::firstOrCreate([
	 					'full_name' => $row['kantor_agentsub_agent'], 
	 					'email' => $row['kantor_agentsub_agent_email']
	 				], [
	 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
	 				]);
	 				$sub_agent = Agency::firstOrCreate([
	 					'user_id' => $user_sub_agent->id,
	 					'agency_name' => $row['kantor_agentsub_agent']
	 				], [
	 					'user_id' => $user_sub_agent->id ?? null,
	 					'regional_coordinator_id' => $korwil->id ?? null
	 				]);
	 			}
 				$user_salesagent = User::firstOrCreate([
 					'full_name' => $row['salesagent'], 
 					'email' => $row['salesagent_email']
 				], [
 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
 				]);
 				$salesagent = Sales::firstOrCreate([
 					'user_id' => $user_salesagent->id,
 					'agency_name' => $row['salesagent']
 				], [
 					'user_id' => $user_salesagent->id ?? null,
 					'main_coordinator_id' => $korut->id ?? null,
 					'regional_coordinator_id' => $korwil->id ?? null,
 					'agency_id' => $sub_agent->id ?? null,
 				]);
 				$tipe_program = TipeProgram::firstOrCreate([
 					'nama_program' => $row['nama_program'],
 					'harga_termasuk' => $row['harga_termasuk'],
 					'harga_tidak_termasuk' => $row['harga_tidak_termasuk'],
 					'gimmick' => $row['gimmick'],
 				], [
 					'keterangan' => $row['keterangan'],
 				]);
	 			$unit = Unit::create([
 					'unit_type' => $unit_type->building_type,
 					'unit_number' => $row['no_unit'],
 					'unit_block' => $row['blok'],
 					'surface_area' => $row['lt'],
 					'building_area' => $row['lb'],
 					'points' => $unit_type->point,
 					'closing_fee' => $unit_type->closing_fee,
 				    'id_unit_type' => $unit_type->id,
	 			]);
	 			$client = Client::firstOrCreate([
 					'client_number' => 'number client',
 					'client_name' => $row['nama_buyer'],
 					'client_email' => $row['alamat_email_buyer'],
 					'client_mobile_number' => $row['no_handphone_buyer'],
 				], [
 					'client_phone_number' => $row['no_handphone_buyer'],
 					'client_address' => $row['alamat_penyuratan'],
 					'alamat_ktp' => $row['alamat_ktp'],
 					'no_ktp' => $row['no_ktp'],
 					'npwp' => $row['npwp'],
 					'profession' => $row['pekerjaan_buyer'],
	 			]);
	 			$booking = Booking::create([
 					'unit_id' => $unit->id,
 					'client_id' => $client->id,
 					'amount' => $row['harga_exclude_ppn'],
 					'total_amount' => $row['harga_include_ppn'],
 					'payment_type' => $row['cara_bayar'],
 					'payment_method' => $row['cara_bayar'],
 					'first_payment' => $row['jumlahrp_dp1'],
 					'principal' => $row['plafond_kredit'],
 					'installment' => $row['jumlahrp_dp1'],
 					'installment_time' => $row['termyn_dp'],
 					'due_date' => \Carbon\Carbon::parse($row['tgl_jatuh_tempo_dp1'])->format('d'),
 					'credits' => $row['harga_include_ppn'] - $row['plafond_kredit'],
 					'point' => $row['point'],
 					'deal_closer' => $row['deal_closer'],
 					'sales_id' => $salesagent->id,
 					'booking_status' => 'dokumen', // kondisi
 					'nup_amount' => $row['jumlah_rp_nup'],
 					'utj_amount' => $row['jumlah_rp_utj'],
 					'nup_date' => $row['tanggal_nup'],
 					'utj_date' => $row['tanggal_utj'],
 					'main_coor_id' => $korut->id ?? null,
 					'regional_coor_id' => $korwil->id ?? null,
 					'agent_id' => $sub_agent->id ?? null,
 					// 'komisi_status' => $row[''], // gw gatau nih status komisi
 					'program_id' => $tipe_program->id ?? null,
 					'nama_program' => $row['nama_program'],
 					'harga_termasuk' => $row['harga_termasuk'],
 					'harga_tidak_termasuk' => $row['harga_tidak_termasuk'],
 					'gimmick' => $row['gimmick'],
 					'keterangan_program' => $tipe_program->keterangan ?? null,
	 			]);
	 			$credit = $row['plafond_kredit'];
	 			for ($i=1; $i <= 30; $i++) { 
	 				if ($row['jumlahrp_dp' . $i]) {
	 					$credit = $credit - $row['jumlahrp_dp' . $i];
			 			$payment = $booking->create([
	 						'payment' => 'Pembayaran ' . $i,
	 						'due_date' => $row['tgl_jatuh_tempo_dp' . $i],
	 					    'sp1_date' => $row['tgl_jatuh_tempo_dp' . $i],
	 					    'sp2_date' => $row['tgl_jatuh_tempo_dp' . $i],
	 					    'sp3_date' => $row['tgl_jatuh_tempo_dp' . $i],
	 						'installment' => $row['jumlahrp_dp' . $i],
	 						'credit' => $credit,
	 						'payment_status' => $row['tgl_bayar_dp' . $i] ? 'Paid' : 'Unpaid',
	 						'payment_date' => $row['tgl_bayar_dp' . $i],
	 						'number_of_delays' => $row['terlambat_dp'.$i.'_hari'],
	 						'fine' => option('persen_denda', 0.0001) * $booking->total_amount,
			 			]);
	 				}
	 			}
	   		}
    	}
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function startRow(): int
    {
        return 1;
    }
}

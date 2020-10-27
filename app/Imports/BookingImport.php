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
use Modules\Installment\Http\Controllers\Booking\BookingHelper;
use Illuminate\Http\Response;

class BookingImport implements ToCollection, WithStartRow, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
	   	 	if($row->filter()->isNotEmpty()){
	 			$cluster = Cluster::firstOrCreate(['cluster_name' => $row['nama_cluster']]);
	 			$unit_type = BuildingType::firstOrCreate([
	 				'cluster_id' => $cluster->id, 
	 				'building_type' => $row['tipe_unit']
	 			], [
	 				'point' => $row['point'] ?? 0, 
	 				'closing_fee' => $row['closing_fee'] ?? 0
	 			]);
 				$user_korut = User::firstOrCreate([
 					'full_name' => $row['nama_koordinator_utama'], 
 					'email' => $row['email_koordinator_utama'],
 					'status' => 'koordinator_utama',
 				], [
 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
 				]);
 				$korut = MainCoordinator::firstOrCreate([
 					'user_id' => $user_korut->id,
 					'full_name' => $row['nama_koordinator_utama'],
 					'email' => $row['email_koordinator_utama'],
 				], [
 					'user_id' => $user_korut->id ?? null,
 					'phone_number' => $row['nomor_telepon_koordinator_utama'] ?? null, 
 					'address' => $row['alamat_koordinator_utama'] ?? null,
 					'pph_final' => $row['pph_final_koordinator_utama'] ?? 0,
 					'principal' => $row['nama_principal_koordinator_utama'] ?? null,
 					'no_hp_principal' => $row['nomor_handphone_principal_korut'] ?? null,
 					'ppn' => $row['ppn_koordinator_utama'] ?? 0,
 					'pph_21' => $row['pph21_koordinator_utama'] ?? 0,
 					'pph_23' => $row['pph23_koordinator_utama'] ?? 0
 				]);
	 			if ($row['nama_koordinator_wilayah']) {
	 				$user_korwil = User::firstOrCreate([
	 					'full_name' => $row['nama_koordinator_wilayah'], 
	 					'email' => $row['email_koordinator_wilayah'],
	 					'status' => 'koordinator_wilayah',
	 				], [
	 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
	 				]);
	 				$korwil = RegionalCoordinator::firstOrCreate([
	 					'user_id' => $user_korwil->id,
	 					'full_name' => $row['nama_koordinator_wilayah'],
	 					'email' => $row['email_koordinator_wilayah'],
	 				], [
	 					'user_id' => $user_korwil->id ?? null,
	 					'main_coordinator_id' => $korut->id ?? null,
	 					'phone_number' => $row['nomor_telepon_koordinator_wilayah'] ?? null, 
	 					'address' => $row['alamat_koordinator_wilayah'] ?? null,
	 					'pph_final' => $row['pph_final_koordinator_wilayah'] ?? 0,
	 					'principal' => $row['nama_principal_koordinator_wilayah'] ?? 0,
	 					'no_hp_principal' => $row['nomor_handphone_principal_koordinator_wilayah'] ?? null,
	 					'ppn' => $row['ppn_koordinator_wilayah'] ?? 0,
	 					'pph_21' => $row['pph21_koordinator_wilayah'] ?? 0,
	 					'pph_23' => $row['pph23_koordinator_wilayah'] ?? 0
	 				]);
	 			}
	 			if ($row['nama_sub_agent']) {
	 				$user_sub_agent = User::firstOrCreate([
	 					'full_name' => $row['nama_sub_agent'], 
	 					'email' => $row['email_sub_agent'],
	 					'status' => 'sub_agent',
	 				], [
	 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
	 				]);
	 				$sub_agent = Agency::firstOrCreate([
	 					'user_id' => $user_sub_agent->id,
	 					'agency_name' => $row['nama_sub_agent'],
	 				], [
	 					'user_id' => $user_sub_agent->id ?? null,
	 					'regional_coordinator_id' => $korwil->id ?? null,
	 					'phone_number' => $row['nomor_telepon_sub_agent'], 
	 					'address' => $row['alamat_sub_agent'],
	 					'pph_final' => $row['pph_final_sub_agent'] ?? 0,
	 					'principal' => $row['nama_principal_sub_agent'] ?? 0,
	 					'no_hp_principal' => $row['nomor_handphone_principal_sub_agent'],
	 					'ppn' => $row['ppn_sub_agent'] ?? 0,
	 					'pph_21' => $row['pph21_sub_agent'] ?? 0,
	 					'pph_23' => $row['pph23_sub_agent'] ?? 0
	 				]);
	 			}
 				$user_salesagent = User::firstOrCreate([
 					'full_name' => $row['nama_sales'], 
 					'email' => $row['email_sales'],
 					'status' => 'sales',
 				], [
 					'password' => Str::title(Str::snake(config('app.name', 'Laravel').'321+'))
 				]);
 				$salesagent = Sales::firstOrCreate([
 					'user_id' => $user_salesagent->id,
 				], [
 					'user_id' => $user_salesagent->id ?? null,
 					'main_coordinator_id' => $korut->id ?? null,
 					'agency_id' => $sub_agent->id ?? null,
 					'regional_coordinator_id' => $korwil->id ?? null,
 					'sales_nip' => $row['nip_sales'],
 					'no_ktp' => $row['no_ktp_sales'],
 					'status' => 'Aktif',

 				]);
 				$tipe_program = TipeProgram::firstOrCreate([
 					'nama_program' => $row['nama_tipe_program'],
 					'harga_termasuk' => explode(',', $row['harga_sudah_termasuk']),
 					'harga_tidak_termasuk' => explode(',', $row['harga_tidak_termasuk']),
 					'gimmick' => $row['gimmick'],
 				], [
 					'keterangan' => $row['keterangan_program'],
 				]);
	 			$unit = Unit::create([
 					'unit_type' => $row['tipe_unit'],
 					'unit_number' => $row['nomor_unit'],
 					'unit_block' => $row['blok_unit'],
 					'surface_area' => $row['luas_kavling'],
 					'building_area' => $row['luas_bangunan'],
 					'points' => $unit_type->point,
 					'closing_fee' => $unit_type->closing_fee,
 				    'id_unit_type' => $unit_type->id,
	 			]);
	 			$client = Client::firstOrCreate([
 					'client_number' => date('Y').date('m').date('d').sprintf("%06d", Client::count() + 1),
 					'client_name' => $row['nama_klien'],
 					'client_email' => $row['alamat_klien'],
 					'client_mobile_number' => $row['nomor_telepon_klien'],
 				], [
 					'client_phone_number' => $row['nomor_telepon_klien'],
 					'client_address' => $row['alamat_klien'],
 					'alamat_ktp' => $row['alamat_ktp_klien'],
 					'no_ktp' => $row['nomor_ktp_klien'],
 					'npwp' => $row['npwp_klien'],
 					'profession' => $row['profesi_klien'],
	 			]);
	 			$booking = Booking::create([
 					'unit_id' => $unit->id,
 					'client_id' => $client->id,
 					'amount' => $row['total_harga_tanpa_ppn'],
 					'total_amount' => $row['total_hargappn'],
 					'dp_amount' => $row['total_dp'] ?? 0,
 					'payment_type' => $row['tipe_pembayaran'],
 					'payment_method' => $row['tipe_pembayaran'],
 					'first_payment' => $row['pembayaran_pertama'],
 					'principal' => $row['total_cicilan_yang_harus_dibayar'],
 					'installment' => $row['pembayaran_pertama'],
 					'installment_time' => $row['lama_cicilan'],
 					'due_date' => \Carbon\Carbon::parse($row['tanggal_jatuh_tempo'])->format('d'),
 					'credits' => $row['akad_kredit'],
 					'point' => $row['point'],
 					'deal_closer' => $row['deal_closer'],
 					'sales_id' => $salesagent->id,
 					'booking_status' => 'dokumen',
 					'payment_method_utj' => $row['cara_pembayaran_utj'],
 					'payment_method_nup' => $row['cara_pembayaran_nup'],
 					'nup_amount' => $row['total_nup'],
 					'utj_amount' => $row['total_utj'],
 					'nup_date' => \Carbon\Carbon::parse($row['tanggal_pembayaran_nup'])->format('Y-m-d'),
 					'utj_date' => \Carbon\Carbon::parse($row['tanggal_pembayaran_utj'])->format('Y-m-d'),
 					'main_coor_id' => $korut->id ?? null,
 					'regional_coor_id' => $korwil->id ?? null,
 					'agent_id' => $sub_agent->id ?? null,
 					'program_id' => $tipe_program->id ?? null,
 					'nama_program' => $row['nama_tipe_program'],
 					'harga_termasuk' => explode(',', $row['harga_sudah_termasuk']),
 					'harga_tidak_termasuk' => explode(',', $row['harga_tidak_termasuk']),
 					'gimmick' => $row['gimmick'],
 					'keterangan_program' => $tipe_program->keterangan ?? null,
	 			]);

	 			$booking_payment = new BookingHelper;
	 			$booking_payment->saveBookingPayments($booking);
	   		}
    	}
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function startRow(): int
    {
        return 4;
    }
}

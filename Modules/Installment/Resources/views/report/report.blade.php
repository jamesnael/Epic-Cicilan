<table border="1" class="table" style="margin-top:20px;">
	<thead>
		<tr>
			<th colspan="100%" style="text-decoration:bold;font-size: 18;">Laporan Pembayaran Cicilan {{ \Carbon\Carbon::parse($from_date)->locale('id')->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($until_date)->locale('id')->translatedFormat('d F Y') }}</th>
		</tr>
		<tr></tr>
		<tr>
			<!-- Admin -->
			<th align="center"><b>No.</b></th>
			<th><b>Nama Buyer</b></th>
			<th align="center"><b>NPWP</b></th>
			<th align="center"><b>No. KTP</b></th>
			<th align="center"><b>Alamat KTP</b></th>
			<th align="center"><b>Alamat Penyuratan</b></th>
			<th align="center"><b>Alamat Email Buyer</b></th>
			<th align="center"><b>Nomor Handphone Buyer</b></th>
			<th align="center"><b>Nama Sales</b></th>
			<th align="center"><b>Nama Sub Agent</b></th>
			<th align="center"><b>Kantor Agent / Sub Agent</b></th>
			<th align="center"><b>Nama Korwil</b></th>
			<th align="center"><b>Nama Korut</b></th>
			<th align="center"><b>Deal Closer</b></th>
			<th align="center"><b>Cluster</b></th>
			<th align="center"><b>Blok</b></th>
			<th align="center"><b>No. Unit</b></th>
			<th align="center"><b>Tipe Unit</b></th>
			<th align="center"><b>Point</b></th>
			<th align="center"><b>Luas Tanah</b></th>
			<th align="center"><b>Luas Bangunan</b></th>
			<th align="center"><b>Jumlah (Rp) NUP</b></th>
			<th align="center"><b>Tanggal NUP</b></th>
			<th align="center"><b>No NUP</b></th>
			<th align="center"><b>Jumlah (Rp) UTJ</b></th>
			<th align="center"><b>Tanggal UTJ</b></th>
			<th align="center"><b>Tanggal Cetak SPR</b></th>
			<th align="center"><b>Tanggal Kirim SPR</b></th>
			<th align="center"><b>Tanggal Terima SPR</b></th>
			<!-- --Admin-- -->

			<!-- Admin & Finance -->
			<th align="center"><b>Harga Exclude PPN</b></th>
			<th align="center"><b>Harga Include PPN</b></th>
			<th align="center"><b>Plafond Kredit</b></th>
			<th align="center"><b>Cara Bayar</b></th>
			<th align="center"><b>Termyn DP</b></th>
			<!-- --Admin & Finance-- -->

			<!-- Finance -->
			@for($i = 1; $i <= $max_installment; $i++)
				<th align="center"><b>Jumlah (Rp) DP {{ $i }}</b></th>
				<th align="center"><b>Tanggal Jatuh Tempo DP {{ $i }}</b></th>
				<th align="center"><b>Terlambat (Hari)</b></th>
				<th align="center"><b>Status SP</b></th>
				<th align="center"><b>Tanggal Bayar DP {{ $i }}</b></th>
			@endfor
			<th align="center"><b>Total Denda Cicilan</b></th>
			<!-- --Finance-- -->

			<!-- Finance Komisi -->
			<th align="center"><b>Jumlah CF Sales</b></th>
			<th align="center"><b>No. Inv CF</b></th>
			<th align="center"><b>Tanggal Inv Terbayar</b></th>
			<!-- --Finance Komisi-- -->

			<!-- Admin & Finance Reward -->
			<!-- <th align="center"><b>Jumlah PTS</b></th>
				<th align="center"><b>Jenis Reward</b></th>
				<th align="center"><b>No. Inv</b></th>
				<th align="center"><b>Tanggal Inv</b></th>
				<th align="center"><b>Tanggal Realisasi</b></th> -->
			<!-- --Admin & Finance Reward-- -->

			<!-- Admin & Legal -->
			<th align="center"><b>Tanggal Invitation PPJB dikirim</b></th>
			<th align="center"><b>Tanggal TTD PPJB</b></th>
			<th align="center"><b>Bank SP3K</b></th>
			<th align="center"><b>Jumlah Plafond</b></th>
			<th align="center"><b>Tanggal Invitation Akad dikirim</b></th>
			<th align="center"><b>No. AJB</b></th>
			<th align="center"><b>Tanggal Invitation AJB dikirim</b></th>
			<th align="center"><b>Tanggal TTD AJB</b></th>
			<th align="center"><b>Notaris AJB</b></th>
			<!-- --Admin & Legal-- -->

			<!-- Admin & Officer Serah Terima -->
			<th align="center"><b>No. BAST</b></th>
			<th align="center"><b>Tanggal Invitation BAST dikirim</b></th>
			<th align="center"><b>Tanggal Serah Terima</b></th>
			<th align="center"><b>Officer BAST</b></th>
			<!-- --Admin & Officer Serah Terima-- -->
			
			<th align="center"><b>Status Tahapan</b></th>

		</tr>
	</thead>
	<tbody>
		@php $no = 1 @endphp
		@foreach($data as $value)
			@if($value->booking_status == 'dokumen')
				@php
					$booking_status = "Pengajuan Dokumen"
				@endphp
			@elseif($value->booking_status == 'spr')
				@php
					$booking_status = "SPR"
				@endphp
			@elseif($value->booking_status == 'ppjb')
				@php
					$booking_status = "PPJB"
				@endphp
			@elseif($value->booking_status == 'cicilan')
				@php
					$booking_status = "Cicilan"
				@endphp
			@elseif($value->booking_status == 'cicilan_sp3k')
				@php
					$booking_status = "Cicilan SP3K"
				@endphp
			@elseif($value->booking_status == 'akad')
				@php
					$booking_status = "Proses Akad KPR"
				@endphp
			@elseif($value->booking_status == 'ajb_handover')
				@php
					$booking_status = "Tahap AJB / Serah Terima Unit"
				@endphp
			@elseif($value->booking_status == 'cicilan_cancel') 
                @php
	                $booking_status = "Cancel di Cicilan"
            	@endphp
            @elseif($value->booking_status == 'ppjb_cancel')
                @php
	                $booking_status = "Cancel di PPJB"
            	@endphp
            @elseif($value->booking_status == 'akad_cancel')
                @php
	                $booking_status = "Cancel di Akad KPR"
            	@endphp
            @elseif($value->booking_status == 'dokumen_cancel')
                @php
	                $booking_status = "Cancel di Dokumen"
            	@endphp
            @elseif($value->booking_status == 'spr_cancel')
                @php
	                $booking_status = "Cancel di SPR"
				@endphp
			@else
				@php
	                $booking_status = ""
				@endphp
			@endif
			<tr>
				<!-- Admin -->
				<td align="center" valign="middle">{{ $no++ }}</td>
				<td valign="middle">{{ $value->client->client_name }}</td>
				<td align="center" valign="middle">'{{ $value->client->npwp }}</td>
				<td align="center" valign="middle">'{{ $value->client->no_ktp }}</td>
				<td align="center" valign="middle">{{ $value->client->alamat_ktp }}</td>
				<td align="center" valign="middle">{{ $value->client->client_address }}</td>
				<td align="center" valign="middle">{{ $value->client->client_email }}</td>
				<td align="center" valign="middle">'{{ $value->client->client_mobile_number }}</td>
				<td align="center" valign="middle">{{ $value->sales->user->full_name }}</td>
				<td align="center" valign="middle">{{ $value->agency->agency_name }}</td>
				<td align="center" valign="middle">{{ $value->agency->agency_address }}</td>
				<td align="center" valign="middle">{{ $value->regional_coordinator->full_name }}</td>
				<td align="center" valign="middle">{{ $value->main_coordinator->full_name }}</td>
				<td align="center" valign="middle">{{ $value->deal_closer }}</td>
				<td align="center" valign="middle">{{ $value->unit->point->cluster->cluster_name }}</td>
				<td align="center" valign="middle">{{ $value->unit->unit_block }}</td>
				<td align="center" valign="middle">{{ $value->unit->unit_number }}</td>
				<td align="center" valign="middle">{{ $value->unit->unit_type }}</td>
				<td align="center" valign="middle">{{ $value->unit->points }}</td>
				<td align="center" valign="middle">{{ $value->unit->surface_area }} m<sup>2</sup></td>
				<td align="center" valign="middle">{{ $value->unit->building_area }} m<sup>2</sup></td>
				<td align="center" valign="middle">Rp. {{ format_money($value->nup_amount) }}</td>
				<td align="center" valign="middle">{{ \Carbon\Carbon::parse($value->nup_date)->locale('id')->translatedFormat('d F Y') }}</td>
				<td align="center" valign="middle"></td>
				<td align="center" valign="middle">Rp. {{ format_money($value->utj_amount) }}</td>
				<td align="center" valign="middle">{{ \Carbon\Carbon::parse($value->utj_date)->locale('id')->translatedFormat('d F Y') }}</td>
				<td align="center" valign="middle">{{ ($value->spr) ? \Carbon\Carbon::parse($value->spr->print_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->spr) ? \Carbon\Carbon::parse($value->spr->sent_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->spr) ? \Carbon\Carbon::parse($value->spr->received_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<!-- --Admin-- -->

				<!-- Admin & Finance -->
				<td align="center" valign="middle">Rp. {{ format_money($value->total_amount/1.1) }}</td>
				<td align="center" valign="middle">Rp. {{ format_money($value->total_amount) }}</td>
				<td align="center" valign="middle">Rp. {{ format_money($value->principal) }}</td>
				<td align="center" valign="middle">{{ $value->payment_method }}</td>
				<td align="center" valign="middle">{{ $value->installment_time }}</td>
				<!-- --Admin & Finance-- -->

				<!-- Finance -->
				@php
					$pay = \Modules\Installment\Entities\BookingPayment::where('booking_id', $value->id)->where('payment', '!=', 'UTJ + NUP')->where('payment', '!=', 'Akad Kredit')->get();
					$count_payments = 1;
				@endphp
				@foreach($pay as $payments)
					@php
						$skip_column     = ($max_installment - $count_payments) * 5;
						$count_payments++;
						if($payments->notification_mail_sp1 == 1) {
							$sp_status = 'SP 1';
						} else if($payments->notification_mail_sp2 == 1 && $payments->notification_mail_sp1 == 1) {
							$sp_status = 'SP 2';
						} else if($payments->notification_mail_sp3 == 1 && $payments->notification_mail_sp2 == 1 && $payments->notification_mail_sp1 == 1) {
							$sp_status = 'SP 3';
						} else {
							$sp_status = 'Belum terkena SP';
						}
					@endphp
					<td align="center" valign="middle">Rp. {{ format_money($payments->installment) }}</td>
					<td align="center" valign="middle">{{ \Carbon\Carbon::parse($payments->due_date)->locale('id')->translatedFormat('d F Y') }}</td>
					<td align="center" valign="middle">{{ $payments->number_of_delays }}</td>
					<td align="center" valign="middle">{{ $sp_status }}</td>
					<td align="center" valign="middle">{{ \Carbon\Carbon::parse($payments->payment_date)->locale('id')->translatedFormat('d F Y') }}</td>
					@if($loop->last)
						@for($i = 1; $i <= $skip_column; $i++)
							<td>&nbsp;</td>
						@endfor
					@endif
				@endforeach
				<td align="center" valign="middle">Rp. {{ format_money($value->total_denda) }}</td>
				<!-- --Finance-- -->

				<!-- Finance Komisi -->
				<td align="center" valign="middle">{{ ($value->commission) ? 'Rp. '.format_money($value->commission->closing_fee_sales) : '' }}</td>
				<td align="center" valign="middle">{{ ($value->commission) ? $value->commission->sales_invoice : '' }}</td>
				<td align="center" valign="middle">{{ ($value->commission) ? \Carbon\Carbon::parse($value->commission->sales_payment_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<!-- --Finance Komisi-- -->

				<!-- Admin & Finance Reward -->

				<!-- --Admin & Finance Reward-- -->

				<!-- Admin & Legal -->
				<td align="center" valign="middle">{{ ($value->ppjb) ? \Carbon\Carbon::parse($value->ppjb->ppjb_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->ppjb) ? \Carbon\Carbon::parse($value->ppjb->ppjb_sign_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->akad_kpr) ? $value->akad_kpr->location : '' }}</td>
				<td align="center" valign="middle">{{ ($value->akad_kpr) ? 'Rp. '.format_money($value->akad_kpr->total_kpr) : '' }}</td>
				<td align="center" valign="middle">{{ ($value->akad_kpr) ? \Carbon\Carbon::parse($value->akad_kpr->akad_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->ajb) ? $value->ajb->ajb_number : '' }}</td>
				<td align="center" valign="middle">{{ ($value->ajb) ? \Carbon\Carbon::parse($value->ajb->ajb_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->ajb) ? \Carbon\Carbon::parse($value->ajb->ajb_sign_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->ajb) ? $value->ajb->notaris_name : '' }}</td>
				<!-- --Admin & Legal-- -->

				<!-- Admin & Officer Serah Terima -->
				<td align="center" valign="middle">{{ ($value->handover) ? $value->handover->no_bast : '' }}</td>
				<td align="center" valign="middle">{{ ($value->handover) ? \Carbon\Carbon::parse($value->handover->bast_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->handover) ? \Carbon\Carbon::parse($value->handover->handover_date)->locale('id')->translatedFormat('d F Y') : '' }}</td>
				<td align="center" valign="middle">{{ ($value->handover) ? $value->handover->nama_petugas : '' }}</td>
				<!-- --Admin & Officer Serah Terima-- -->
				<td align="center" valign="middle">{{ $booking_status }}</td>
			</tr>
		@endforeach
	</tbody>    
</table>
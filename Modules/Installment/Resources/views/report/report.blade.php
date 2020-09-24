<table border="1" class="table" style="margin-top:20px;">
	<thead>
		<tr>
			<th colspan="19" style="text-decoration:bold;font-size: 18;">Laporan Pembayaran Cicilan {{ \Carbon\Carbon::parse($from_date)->locale('id')->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($until_date)->locale('id')->translatedFormat('d F Y') }}</th>
		</tr>
		<tr></tr>
		<tr>
			<th align="center"><b>No.</b></th>
			<th align="center"><b>ID Klien</b></th>
			<th><b>Nama Klien</b></th>
			<th align="center"><b>Tipe Unit</b></th>
			<th align="center"><b>Unit</b></th>
			<th align="center"><b>Harga Unit</b></th>
			<th align="center"><b>Cara Bayar</b></th>
			<th align="center"><b>Total Pembayaran</b></th>
			<th align="center"><b>Total NUP</b></th>
			<th align="center"><b>Total UTJ</b></th>
			<th align="center"><b>Total Cicilan Yang Harus Dibayar</b></th>
			<th align="center"><b>Lama Cicilan</b></th>
			<th align="center"><b>Tanggal Jatuh Tempo</b></th>
			<th align="center"><b>Sisa Tunggakan</b></th>
			<th align="center"><b>Nama Sales</b></th>
			<th align="center"><b>Nama Sub Agent</b></th>
			<th align="center"><b>Nama Korwil</b></th>
			<th align="center"><b>Status</b></th>
			<th align="center"><b>Tanggal Transaksi</b></th>
		</tr>
	</thead>
	<tbody>
		@php $no = 1 @endphp
		@foreach($data as $value)
			<tr>
				<td align="center" valign="middle">{{ $no++ }}</td>
				<td valign="middle">'{{ $value->client->client_number }}</td>
				<td valign="middle">{{ $value->client->client_name }}</td>
				<td align="center" valign="middle">{{ $value->unit->unit_type }}</td>
				<td align="center" valign="middle">{{ $value->unit->unit_number }} / {{ $value->unit->unit_block }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->total_amount) }}</td>
				<td align="center" valign="middle">{{ $value->payment_type }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->total_pembayaran) }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->nup_amount) }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->utj_amount) }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->principal) }}</td>
				<td align="center" valign="middle">{{ $value->installment_time }}</td>
				<td align="center" valign="middle">{{ $value->due_date }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->sisa_tunggakan) }}</td>
				<td align="center" valign="middle">{{ $value->sales->user->full_name }}</td>
				<td align="center" valign="middle">{{ $value->agency->agency_name }}</td>
				<td align="center" valign="middle">{{ $value->regional_coordinator->full_name }}</td>
				<td align="center" valign="middle">{{ ($value->unpaid_payments) ? 'Belum Lunas' : 'Lunas' }}</td>
				<td align="center" valign="middle">{{ \Carbon\Carbon::parse($value->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
			</tr>
		@endforeach
	</tbody>	
</table>
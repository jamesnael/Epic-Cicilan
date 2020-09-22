<table border="1" class="table" style="margin-top:20px;">
	<thead>
		<tr>
			<th colspan="14" style="text-decoration:bold;font-size: 18;">Installment Report</th>
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
			<th align="center"><b>Total Bayar</b></th>
			<th align="center"><b>Tanggal Jatuh Tempo</b></th>
			<th align="center"><b>Sisa Tunggakan</b></th>
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
				<td align="center" valign="middle">Rp {{ format_money($value->dp_amount) }}</td>
				<td align="center" valign="middle">{{ $value->payment_type }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->installment) }}</td>
				<td align="center" valign="middle">{{ $value->due_date }}</td>
				<td align="center" valign="middle">Rp {{ format_money($value->sisa_tunggakan) }}</td>
			</tr>
		@endforeach
	</tbody>	
</table>
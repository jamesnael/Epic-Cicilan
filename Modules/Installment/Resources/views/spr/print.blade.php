<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Surat Pemesanan Unit {{ $data->client->client_name }}</title>
	<style type="text/css">
		.mt-cm {
			margin-top: 3cm;
		}
		.sans{
            font-size : 12.5px;
			font-family: sans-serif;
		}
	</style>
</head>
<body>
	<!-- Kop Surat -->
	<div class="mt-cm">&nbsp;</div>
	
	<!-- Page 1 -->
	<table class="sans" width="100%">
		<tr>
			<td width="30%">Nama Lengkap Pembeli</td>
			<td width="5%">:</td>
			<td width="65%">{{ $data->client->client_name }}</td>
		</tr>
		<tr>
			<td>No. KTP</td>
			<td>:</td>
			<td>{{ $data->client->no_ktp }}</td>
		</tr>
		<tr>
			<td>NPWP</td>
			<td>:</td>
			<td>{{ $data->client->npwp }}</td>
		</tr>
		<tr>
			<td>Alamat KTP</td>
			<td>:</td>
			<td>{{ $data->client->alamat_ktp }}</td>
		</tr>
		<tr>
			<td>Alamat Surat</td>
			<td>:</td>
			<td>{{ $data->client->client_address }}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td>{{ $data->client->client_email }}</td>
		</tr>
		<tr>
			<td>No. Telepon / HP</td>
			<td>:</td>
			<td>{{ $data->client->client_mobile_number }}</td>
		</tr>

		<!-- Pemesanan -->
		<tr>
			<td colspan="3">
				<div class="text-center mt-3">
					<font style="font-family: sans-serif;font-size: 15px;"><strong>PEMESANAN</strong></font>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3"><div>&nbsp;</div></td>
		</tr>
		<tr>
			<td>Tipe Unit</td>
			<td>:</td>
			<td>{{ $data->unit->unit_type }}</td>
		</tr>
		<tr>
			<td>Jalan</td>
			<td>:</td>
			<td>{{ $data->unit->unit_address }}</td>
		</tr>
		<tr>
			<td>No. Unit</td>
			<td>:</td>
			<td>{{ $data->unit->unit_number }} / {{ $data->unit->unit_block }}</td>
		</tr>
		<tr>
			<td>Luas Bangunan</td>
			<td>:</td>
			<td>{{ $data->unit->building_area }} m<sup>2</sup></td>
		</tr>
		<tr>
			<td>Luas Tanah</td>
			<td>:</td>
			<td>{{ $data->unit->surface_area }} m<sup>2</sup></td>
		</tr>

		<!-- Harga Jual -->
		<tr>
			<td colspan="3">
				<div class="text-center mt-2">
					<font style="font-family: sans-serif;font-size: 15px;"><strong>HARGA JUAL</strong></font>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3"><div>&nbsp;</div></td>
		</tr>
		<tr>
			<td>Harga Jual</td>
			<td>:</td>
			<td>Rp. {{ format_money($data->total_amount) }}</td>
		</tr>
		<tr>
			<td>Cara Bayar</td>
			<td>:</td>
			<td>{{ $data->payment_method }}</td>
		</tr>
		<tr>
			<td valign="top">Harga sudah termasuk *)</td>
			<td valign="top">:</td>
			<td>
				@foreach($data->harga_termasuk as $harga_msk)
					- {{ $harga_msk }}<br>
				@endforeach
			</td>
		</tr>
		<tr>
			<td valign="top">Harga belum termasuk *)</td>
			<td valign="top">:</td>
			<td>
				@foreach($data->harga_tidak_termasuk as $harga_tidak_msk)
					- {{ $harga_tidak_msk }}<br>
				@endforeach
			</td>
		</tr>
		<tr>
			<td>Gimmick</td>
			<td>:</td>
			<td>{{ $data->gimmick }}</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>:</td>
			<td>{{ $data->keterangan_program }}</td>
		</tr>
	</table>

	<!-- Footer -->
	<p class="sans text-right">Jakarta, {{ $date }}</p>
	<table border="1" cellspacing="0" cellpadding="3" class="sans mt-3" style="font-size:11px" width="100%">
		<tr>
			<th width="25%"><div class="text-center">ADMIN</div></th>
			<th width="25%"><div class="text-center">SALES</div></th>
			<th width="25%"><div class="text-center">DIRECTOR</div></th>
			<th width="25%"><div class="text-center">PEMBELI</div></th>
		</tr>
		<tr>
			<td><div class="my-4"><br></div></td>
			<td><div class="my-4"><br></div></td>
			<td><div class="my-4"><br></div></td>
			<td><div class="my-4"><br></div></td>
		</tr>
		<tr>
			<td><div class="text-center"></div></td>
			<td><div class="text-center">{{ $data->sales->user->full_name }}</div></td>
			<td><div class="text-center"></div></td>
			<td><div class="text-center">{{ $data->client->client_name }}</div></td>
		</tr>
	</table>

	<!-- Page Break -->
	<div style="page-break-before: always;">&nbsp;</div>

	<!-- Kop Surat -->
	<div class="mt-cm">&nbsp;</div>

	<!-- Page 2 -->
	<div class="text-center">
		<font style="font-family: sans-serif;font-size: 15px;"><strong>JADWAL PEMBAYARAN</strong></font>
	</div>
	<table border="1" cellspacing="0" cellpadding="5" class="sans mt-3" style="font-size:12px" width="100%">
		<tr>
			<th width="5%"><div class="text-center">No.</div></th>
			<th width="35%"><div class="text-center">PEMBAYARAN</div></th>
			<th width="20%"><div class="text-center">JATUH TEMPO</div></th>
			<th width="20%"><div class="text-center">ANGSURAN</div></th>
			<th width="20%"><div class="text-center">SISA ANGSURAN</div></th>
		</tr>
		@foreach($data->payments as $payment)
			<tr>
				<td><div class="text-center">{{ $loop->iteration }}</div></td>
				<td><div class="text-center">{{ $payment->payment }}</div></td>
				<td><div class="text-center">{{ \Carbon\Carbon::parse($payment->due_date)->locale('id')->translatedFormat('d F Y') }}</div></td>
				<td><div class="text-center">Rp. {{ format_money($payment->installment) }}</div></td>
				<td><div class="text-center">Rp. {{ format_money($payment->credit) }}</div></td>
			</tr>
		@endforeach
	</table>
</body>
</html>
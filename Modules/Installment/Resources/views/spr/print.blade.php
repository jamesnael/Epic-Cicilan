<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<title>Surat Pemesanan Unit</title>
	<style type="text/css">
		.mt-cm {
			margin-top: 3cm;
		}
		.sans{
            font-size : 14px;
			font-family: sans-serif;
		}
	</style>
</head>
<body>
	<div class="mt-cm">&nbsp;</div>
	<table class="sans">
		<tr>
			<td>Nama Lengkap Pembeli</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->client->client_name }}</td>
		</tr>
		<tr>
			<td>No. KTP</td>
			<td><div class="mx-3">:</div></td>
			<td>32010100001000</td>
		</tr>
		<tr>
			<td>NPWP</td>
			<td><div class="mx-3">:</div></td>
			<td>32010100001000</td>
		</tr>
		<tr>
			<td>Alamat KTP</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->client->client_address }}</td>
		</tr>
		<tr>
			<td>Alamat Surat</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->client->client_address }}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->client->client_email }}</td>
		</tr>
		<tr>
			<td>No. Telepon / HP</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->client->client_mobile_number }}</td>
		</tr>
	</table>
	<div class="text-center mt-4">
		<font style="font-family: sans-serif;font-size: 16px;"><strong>PEMESANAN</strong></font>
	</div>
	<table class="mt-3 sans">
		<tr>
			<td>Tipe Unit</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->unit->unit_type }}</td>
		</tr>
		<tr>
			<td>Jalan</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->client->client_address }}</td>
		</tr>
		<tr>
			<td>No. Unit</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->unit->unit_number }} / {{ $data->unit->unit_block }}</td>
		</tr>
		<tr>
			<td>Luas Bangunan</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->unit->building_area }} m<sup>2</sup></td>
		</tr>
		<tr>
			<td>Luas Tanah</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->unit->surface_area }} m<sup>2</sup></td>
		</tr>
	</table>
	<div class="text-center mt-4">
		<font style="font-family: sans-serif;font-size: 16px;"><strong>HARGA JUAL</strong></font>
	</div>
	<table class="mt-3 sans">
		<tr>
			<td>Harga Jual</td>
			<td><div class="mx-3">:</div></td>
			<td>Rp. {{ format_money($data->total_amount) }}</td>
		</tr>
		<tr>
			<td>Cara Bayar</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->payment_method }}</td>
		</tr>
		<tr>
			<td valign="top">Harga sudah termasuk *)</td>
			<td valign="top"><div class="mx-3">:</div></td>
			<td>
				@foreach($data->harga_termasuk as $harga_msk)
					- {{ $harga_msk }}<br>
				@endforeach
			</td>
		</tr>
		<tr>
			<td valign="top">Harga belum termasuk *)</td>
			<td valign="top"><div class="mx-3">:</div></td>
			<td>
				@foreach($data->harga_tidak_termasuk as $harga_tidak_msk)
					- {{ $harga_tidak_msk }}<br>
				@endforeach
			</td>
		</tr>
		<tr>
			<td>Gimmick</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->gimmick }}</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><div class="mx-3">:</div></td>
			<td>{{ $data->keterangan_program }}</td>
		</tr>
	</table>
	<p class="sans text-right">Jakarta, {{ $date }}</p>
	<div class="table-responsive mt-4">
		<table border="1" cellspacing="0" cellpadding="3" class="table sans" style="font-size:12px">
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
				<td><div class="text-center">ADMIN</div></td>
				<td><div class="text-center">{{ $data->sales->user->full_name }}</div></td>
				<td><div class="text-center">DIRECTOR</div></td>
				<td><div class="text-center">{{ $data->client->client_name }}</div></td>
			</tr>
		</table>
	</div>
</body>
</html>
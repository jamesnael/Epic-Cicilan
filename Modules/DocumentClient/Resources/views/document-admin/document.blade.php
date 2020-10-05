<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Dokumen {{ $client }}</title>
	<style>
	.page-break {
	    page-break-after: always;
	}

	.img-fluid{
		max-width: 100%;
		height: auto;
	}


	</style>
</head>
<body>
	@if ($data->document->url_file_ktp_pemohon)
		<table>
			<tr>
				<td width="100%"><h3>KTP Pemohon</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_ktp_pemohon ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
		<div class="page-break"></div>
	@endif
	@if ($data->document->url_file_ktp_suami_istri)
		<table>
			<tr>
				<td width="100%"><h3>KTP Suami/Istri</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_ktp_suami_istri ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
		<div class="page-break"></div>
	@endif
	
	@if ($data->document->url_file_kk)
		<table>
			<tr>
				<td><h3>Kartu Keluarga</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_kk ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif
	
	@if ($data->document->url_file_surat_nikah)
		<table>
			<tr>
				<td><h3>Buku Nikah</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_surat_nikah ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_npwp)
		<table>
			<tr>
				<td><h3>NPWP</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_npwp ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
		
		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_rekening_tabungan)
		<table>
			<tr>
				<td><h3>Rekening Tabungan</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_rekening_tabungan ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_slip_gaji)
		<table>
			<tr>
				<td><h3>Slip Gaji (3 Bln Terakhir)</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_slip_gaji ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_keterangan_kerja)
		<table>
			<tr>
				<td><h3>Keterangan Kerja</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_keterangan_kerja ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_tabungan_3_bulan_terakhir)
		<table>
			<tr>
				<td><h3>R/K Tab.3 bln Terakhir</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_tabungan_3_bulan_terakhir ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_rekening_koran)
		<table>
			<tr>
				<td><h3>Rek. Koran 6 Bulan Bagi Pengusaha</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_rekening_koran ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_siup)
		<table>
			<tr>
				<td><h3>SIUP</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_siup ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_tdp)
		<table>
			<tr>
				<td><h3>TDP/NIB</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_tdp ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_akta)
		<table>
			<tr>
				<td><h3>Akte Pendirian/Perubahan</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_akta ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_pengesahan)
		<table>
			<tr>
				<td><h3>Akte Pengesahan Menkeh</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_pengesahan ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_izin_praktek)
		<table>
			<tr>
				<td><h3>Izin Praktek</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_izin_praktek ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_sk_domisili)
		<table>
			<tr>
				<td><h3>SK Domisili</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_sk_domisili ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_keterangan_usaha)
		<table>
			<tr>
				<td><h3>Surat Keterangan Usaha/Sewa</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_keterangan_usaha ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_spt)
		<table>
			<tr>
				<td><h3>SPT</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_spt ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_other)
		<table>
			<tr>
				<td><h3>File Pendukung</h3></td>
			</tr>
			<tr>
				<td>
					<img src="{{$data->document->url_file_other ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
	@endif

</body>
</html>
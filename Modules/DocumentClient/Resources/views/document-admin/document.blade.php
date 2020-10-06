<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Dokumen {{ $client }}</title>
	<style type="text/css">
		.page-break {
		    page-break-after: always;
		}

		.img-fluid{
			width: auto;
			height: 100%;
		}
	</style>
</head>
<body>
	@if ($data->document->url_file_ktp_pemohon)
		<table width="100%">
			<tr>
				<th width="100%"><h3>KTP Pemohon</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_ktp_pemohon ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
		<div class="page-break"></div>
	@endif
	@if ($data->document->url_file_ktp_suami_istri)
		<table width="100%">
			<tr>
				<th width="100%"><h3>KTP Suami/Istri</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_ktp_suami_istri ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
		<div class="page-break"></div>
	@endif
	
	@if ($data->document->url_file_kk)
		<table width="100%">
			<tr>
				<th><h3>Kartu Keluarga</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_kk ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif
	
	@if ($data->document->url_file_surat_nikah)
		<table width="100%">
			<tr>
				<th><h3>Buku Nikah</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_surat_nikah ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_npwp)
		<table width="100%">
			<tr>
				<th><h3>NPWP</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_npwp ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
		
		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_rekening_tabungan)
		<table width="100%">
			<tr>
				<th><h3>Rekening Tabungan</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_rekening_tabungan ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_slip_gaji)
		<table width="100%">
			<tr>
				<th><h3>Slip Gaji (3 Bln Terakhir)</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_slip_gaji ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_keterangan_kerja)
		<table width="100%">
			<tr>
				<th><h3>Keterangan Kerja</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_keterangan_kerja ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_tabungan_3_bulan_terakhir)
		<table width="100%">
			<tr>
				<th><h3>R/K Tab.3 bln Terakhir</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_tabungan_3_bulan_terakhir ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_rekening_koran)
		<table width="100%">
			<tr>
				<th><h3>Rek. Koran 6 Bulan Bagi Pengusaha</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_rekening_koran ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_siup)
		<table width="100%">
			<tr>
				<th><h3>SIUP</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_siup ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_tdp)
		<table width="100%">
			<tr>
				<th><h3>TDP/NIB</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_tdp ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_akta)
		<table width="100%">
			<tr>
				<th><h3>Akte Pendirian/Perubahan</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_akta ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_pengesahan)
		<table width="100%">
			<tr>
				<th><h3>Akte Pengesahan Menkeh</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_pengesahan ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_izin_praktek)
		<table width="100%">
			<tr>
				<th><h3>Izin Praktek</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_izin_praktek ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_sk_domisili)
		<table width="100%">
			<tr>
				<th><h3>SK Domisili</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_sk_domisili ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_keterangan_usaha)
		<table width="100%">
			<tr>
				<th><h3>Surat Keterangan Usaha/Sewa</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_keterangan_usaha ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_spt)
		<table width="100%">
			<tr>
				<th><h3>SPT</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_spt ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_other)
		<table width="100%">
			<tr>
				<th><h3>File Pendukung</h3></th>
			</tr>
			<tr>
				<td align="center">
					<img src="{{$data->document->url_file_other ?? ''}}" class="img-fluid">
				</td>
			</tr>
		</table>
	@endif

</body>
</html>
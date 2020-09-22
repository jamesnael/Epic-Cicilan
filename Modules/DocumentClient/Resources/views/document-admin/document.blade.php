<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>DOKUMEN</title>
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
		<h3>KTP Pemohon</h3>
		<img src="{{$data->document->url_file_ktp_pemohon ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif
	@if ($data->document->url_file_ktp_suami_istri)
		<h3>KTP Suami/Istri</h3>
		<img src="{{$data->document->url_file_ktp_suami_istri ?? ''}}" class="img-fluid">
		
		<div class="page-break"></div>
	@endif
	
	@if ($data->document->url_file_kk)
		<h3>Kartu Keluarga</h3>
		<img src="{{$data->document->url_file_kk ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif
	
	@if ($data->document->url_file_surat_nikah)
		<h3>Buku Nikah</h3>
		<img src="{{$data->document->url_file_surat_nikah ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_npwp)
		<h3>NPWP</h3>
		<img src="{{$data->document->url_file_npwp ?? ''}}" class="img-fluid">
		
		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_rekening_tabungan)
		<h3>Rekening Tabungan</h3>
		<img src="{{$data->document->url_file_rekening_tabungan ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_slip_gaji)
		<h3>Slip Gaji (3 Bln Terakhir)</h3>
		<img src="{{$data->document->url_file_slip_gaji ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_keterangan_kerja)
		<h3>Keterangan Kerja</h3>
		<img src="{{$data->document->url_file_keterangan_kerja ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_tabungan_3_bulan_terakhir)
		<h3>R/K Tab.3 bln Terakhir</h3>
		<img src="{{$data->document->url_file_tabungan_3_bulan_terakhir ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_rekening_koran)
		<h3>Rek. Koran 6 Bulan Bagi Pengusaha</h3>
		<img src="{{$data->document->url_file_rekening_koran ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_siup)
		<h3>SIUP</h3>
		<img src="{{$data->document->url_file_siup ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_tdp)
		<h3>TDP/NIB</h3>
		<img src="{{$data->document->url_file_tdp ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_akta)
		<h3>Akte Pendirian/Perubahan</h3>
		<img src="{{$data->document->url_file_akta ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_pengesahan)
		<h3>Akte Pengesahan Menkeh</h3>
		<img src="{{$data->document->url_file_pengesahan ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_izin_praktek)
		<h3>Izin Praktek</h3>
		<img src="{{$data->document->url_file_izin_praktek ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_sk_domisili)
		<h3>SK Domisili</h3>
		<img src="{{$data->document->url_file_sk_domisili ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_keterangan_usaha)
		<h3>Surat Keterangan Usaha/Sewa</h3>
		<img src="{{$data->document->url_file_keterangan_usaha ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_spt)
		<h3>SPT</h3>
		<img src="{{$data->document->url_file_spt ?? ''}}" class="img-fluid">

		<div class="page-break"></div>
	@endif

	@if ($data->document->url_file_other)
		<h3>File Pendukung</h3>
		<img src="{{$data->document->url_file_other ?? ''}}" class="img-fluid">
	@endif

</body>
</html>
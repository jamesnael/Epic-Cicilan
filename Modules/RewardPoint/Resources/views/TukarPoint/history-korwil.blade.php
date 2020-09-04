@extends('app')

@section('content')

	@include('components.breadcrumbs')

	@php
		$page->table_headers[] = [
            "text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Aksi',
            "align" => 'center',
            "sortable" => false,
            "value" => 'actions',
        ];
        $page->table_headers = collect($page->table_headers)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();
	@endphp
	<h3><u>History Penukaran Koordinator Wilayah</u></h3>
	<table-layout inline-template
		uri="{{ route('tukar-point-history-korwil.table', $page->id) }}"
		:headers='@json($page->table_headers)'
		no-data-text="Tidak ada data ditemukan."
		no-results-text="Tidak ada data ditemukan."
		search-text="Pencarian"
		refresh-text="Muat Ulang"
		items-per-page-all-text="Semua"
		items-per-page-text="Tampilkan"
		page-text-locale="id"
		delete-uri="tukar-point-korwil.destroy"
		delete-uri-parameter="id"
		delete-text="Cancel"
		delete-confirmation-text="Apakah Anda yakin untuk mengcancel penukaran point berikut ini ?"
		delete-cancel-text="Tidak"
		>
		@include('components.table')
	</table-layout>
 
@endsection

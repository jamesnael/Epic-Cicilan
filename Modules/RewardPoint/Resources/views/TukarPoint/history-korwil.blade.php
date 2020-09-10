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

        //Get Point
        $page->table_headers_korwil_get_point = collect($page->table_headers_korwil_get_point)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();
	@endphp
	<h3><u>History Penukaran Point</u></h3>
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
		delete-confirmation-text="Apakah anda yakin untuk mengcancel penukaran point berikut ini ?"
		delete-cancel-text="Tidak"
		delete-icon="mdi-cancel"
		>
		@include('components.table')
	</table-layout>
 	
	<h3 class="mt-5"><u>History Pendapatan Point</u></h3>
 	<korwil-table inline-template
		uri="{{ route('tukar-point-history-korwil-get-point.table', $page->id) }}"
		:headers='@json($page->table_headers_korwil_get_point)'
		no-data-text="Tidak ada data ditemukan."
		no-results-text="Tidak ada data ditemukan."
		search-text="Pencarian"
		refresh-text="Muat Ulang"
		items-per-page-all-text="Semua"
		items-per-page-text="Tampilkan"
		page-text-locale="id"
		>
		@include('components.table')
	</korut-table>
@endsection

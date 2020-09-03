@extends('app')

@section('content')

	@include('components.breadcrumbs')

	@php
        $page->table_headers = collect($page->table_headers)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();
	@endphp
	<h3><u>History Agent</u></h3>
	<h5>Sisa Point : -</h5>
	<table-layout inline-template
		uri="{{ route('tukar-point-agent.table') }}"
		:headers='@json($page->table_headers)'
		no-data-text="Tidak ada data ditemukan."
		no-results-text="Tidak ada data ditemukan."
		search-text="Pencarian"
		refresh-text="Muat Ulang"
		items-per-page-all-text="Semua"
		items-per-page-text="Tampilkan"
		page-text-locale="id"
		>
		@include('components.table')
	</table-layout>
 
@endsection

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
	<table-layout inline-template
		uri="{{ route('main-coordinator.table') }}"
		:headers='@json($page->table_headers)'
		no-data-text="Tidak ada data ditemukan."
		no-results-text="Tidak ada data ditemukan."
		search-text="Pencarian"
		refresh-text="Muat Ulang"
		items-per-page-all-text="Semua"
		items-per-page-text="Tampilkan"
		page-text-locale="id"
		add-new-uri="{{ route('main-coordinator.create') }}"
		add-new-text="Tambah"
		add-new-color="light-blue lighten-2"
		edit-uri="main-coordinator.edit"
		edit-uri-parameter="slug"
		edit-text="Ubah"
		delete-uri="main-coordinator.destroy"
		delete-uri-parameter="slug"
		delete-text="Hapus"
		delete-confirmation-text="Apakah Anda yakin untuk menghapus data ini ?"
		delete-cancel-text="Batal"
		>
		
		@include('components.table')
	</table-layout>

@endsection

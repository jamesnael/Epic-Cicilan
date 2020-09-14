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
        
        $page->table_headers_pending = collect($page->table_headers)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();

        $page->table_headers_approved = collect($page->table_headers_approved)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();

	@endphp

	<v-tabs>
	    <v-tab>Pending</v-tab>
      	<v-tab-item>
			<table-layout inline-template
				uri="{{ route('akad.table') }}"
				:headers='@json($page->table_headers_pending)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				edit-uri="akad.edit"
				edit-uri-parameter="slug"
				edit-text="Edit Akad"
				>
				
				@include('components.table')
			</table-layout>
		</v-tab-item>

		<v-tab>Approved</v-tab>
      	<v-tab-item>
      		<table-layout inline-template
				uri="{{ route('akad.table.approved') }}"
				:headers='@json($page->table_headers_approved)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				{{-- edit-uri="akad.edit"
				edit-uri-parameter="slug"
				edit-text="Edit Akad" --}}
				>
				
				@include('components.table')
			</table-layout>
		</v-tab-item>
	</v-tabs>
	

@endsection

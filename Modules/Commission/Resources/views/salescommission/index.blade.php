@extends('app')

@section('content')

	@include('components.breadcrumbs')

	@php
		// Table Sub Agent
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

	<v-tabs>
		@if (\Auth::user()->status != 'sales')
		    <v-tab>Sub Agent</v-tab>
	      	<v-tab-item>
				<table-layout inline-template
					uri="{{ route('salescommission.table') }}"
					:headers='@json($page->table_headers)'
					no-data-text="Tidak ada data ditemukan."
					no-results-text="Tidak ada data ditemukan."
					search-text="Pencarian"
					refresh-text="Muat Ulang"
					items-per-page-all-text="Semua"
					items-per-page-text="Tampilkan"
					page-text-locale="id"
					edit-uri="salescommission.edit"
					edit-uri-parameter="slug"
					edit-text="Ubah"
					>
					
					@include('components.table')
				</table-layout>
		   	</v-tab-item>

		   	<v-tab>Koordinator Wilayah</v-tab>
	      	<v-tab-item>
				<table-layout inline-template
					uri="{{ route('salescommission.table.korwil') }}"
					:headers='@json($page->table_headers_korwil)'
					no-data-text="Tidak ada data ditemukan."
					no-results-text="Tidak ada data ditemukan."
					search-text="Pencarian"
					refresh-text="Muat Ulang"
					items-per-page-all-text="Semua"
					items-per-page-text="Tampilkan"
					page-text-locale="id"
					edit-uri="salescommission.edit.korwil"
					edit-uri-parameter="slug"
					edit-text="Ubah"
					>
					
					@include('components.table')
				</table-layout>
			</v-tab-item>

			<v-tab>Koordinator Utama</v-tab>
	      	<v-tab-item>
				<table-layout inline-template
					uri="{{ route('salescommission.table.korut') }}"
					:headers='@json($page->table_headers_korut)'
					no-data-text="Tidak ada data ditemukan."
					no-results-text="Tidak ada data ditemukan."
					search-text="Pencarian"
					refresh-text="Muat Ulang"
					items-per-page-all-text="Semua"
					items-per-page-text="Tampilkan"
					page-text-locale="id"
					edit-uri="salescommission.edit.korut"
					edit-uri-parameter="slug"
					edit-text="Ubah"
					>
					
					@include('components.table')
				</table-layout>
			</v-tab-item>
		@endif
		
		<v-tab>Closing Fee</v-tab>
      	<v-tab-item>
			<table-layout inline-template
				uri="{{ route('salescommission.table.closingfee') }}"
				:headers='@json($page->table_headers_closingfee)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				edit-uri="salescommission.edit.closingfee"
				edit-uri-parameter="slug"
				edit-text="Ubah"
				>
				
				@include('components.table')
			</table-layout>
		</v-tab-item>
	</v-tabs>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	@php

		if(\Auth::user()->is_admin) {
		 	$page->table_headers[] = [
	           	"text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Aksi',
	          	"align" => 'center',
	           	"sortable" => false,
	           	"value" => 'actions',
	        ];
	    }
	    
        $page->table_headers = collect($page->table_headers)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();

        //Get Point
        $page->table_headers_sales_get_point = collect($page->table_headers_sales_get_point)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();
	@endphp
		<v-tabs>
		    <v-tab>History Penukaran Point</v-tab>
		      <v-tab-item>
		        <table-layout inline-template
					uri="{{ route('tukar-point-history-sales.table', $page->id) }}"
					:headers='@json($page->table_headers)'
					no-data-text="Tidak ada data ditemukan."
					no-results-text="Tidak ada data ditemukan."
					search-text="Pencarian"
					refresh-text="Muat Ulang"
					items-per-page-all-text="Semua"
					items-per-page-text="Tampilkan"
					page-text-locale="id"
					edit-uri="tukar-point-sales.print"
					edit-uri-parameter="id"
					edit-text="Download PDF"
					edit-icon="mdi-download"
					{{-- delete-uri="tukar-point-sales.destroy"
					delete-uri-parameter="id"
					delete-text="Cancel"
					delete-confirmation-text="Apakah anda yakin untuk mengcancel penukaran point berikut ini ?"
					delete-cancel-text="Tidak"
					delete-icon="mdi-cancel" --}}
					>
					@include('components.table')
				</table-layout>
		      </v-tab-item>
		    <v-tab>History Pendapatan Point</v-tab>
		      <v-tab-item>
		      	<sales-table inline-template
					uri="{{ route('tukar-point-history-sales-get-point.table', $page->id) }}"
					:headers='@json($page->table_headers_sales_get_point)'
					no-data-text="Tidak ada data ditemukan."
					no-results-text="Tidak ada data ditemukan."
					search-text="Pencarian"
					refresh-text="Muat Ulang"
					items-per-page-all-text="Semua"
					items-per-page-text="Tampilkan"
					page-text-locale="id"
					>
					@include('components.table')
				</sales-table>
		      </v-tab-item>
		</v-tabs>
	<!-- <h3><u>History Penukaran Point</u></h3> -->
	<!-- <table-layout inline-template
		uri="{{ route('tukar-point-history-sales.table', $page->id) }}"
		:headers='@json($page->table_headers)'
		no-data-text="Tidak ada data ditemukan."
		no-results-text="Tidak ada data ditemukan."
		search-text="Pencarian"
		refresh-text="Muat Ulang"
		items-per-page-all-text="Semua"
		items-per-page-text="Tampilkan"
		page-text-locale="id"
		delete-uri="tukar-point-sales.destroy"
		delete-uri-parameter="id"
		delete-text="Cancel"
		delete-confirmation-text="Apakah anda yakin untuk mengcancel penukaran point berikut ini ?"
		delete-cancel-text="Tidak"
		delete-icon="mdi-cancel"
		>
		@include('components.table')
	</table-layout> -->

	<!-- <h3 class="mt-5"><u>History Pendapatan Point</u></h3> -->
	<!-- <sales-table inline-template
		uri="{{ route('tukar-point-history-sales-get-point.table', $page->id) }}"
		:headers='@json($page->table_headers_sales_get_point)'
		no-data-text="Tidak ada data ditemukan."
		no-results-text="Tidak ada data ditemukan."
		search-text="Pencarian"
		refresh-text="Muat Ulang"
		items-per-page-all-text="Semua"
		items-per-page-text="Tampilkan"
		page-text-locale="id"
		>
		@include('components.table')
	</sales-table> -->
 	
@endsection

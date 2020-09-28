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
        $page->table_headers_korut_get_point = collect($page->table_headers_korut_get_point)->prepend([
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
					uri="{{ route('tukar-point-history-korut.table', $page->id) }}"
					:headers='@json($page->table_headers)'
					no-data-text="Tidak ada data ditemukan."
					no-results-text="Tidak ada data ditemukan."
					search-text="Pencarian"
					refresh-text="Muat Ulang"
					items-per-page-all-text="Semua"
					items-per-page-text="Tampilkan"
					page-text-locale="id"
					edit-uri="tukar-point-korut.print"
					edit-uri-parameter="id"
					edit-text="Download PDF"
					edit-icon="mdi-download"
					{{-- delete-uri="tukar-point-korut.destroy"
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
			 	<korut-table inline-template
					uri="{{ route('tukar-point-history-korut-get-point.table', $page->id) }}"
					:headers='@json($page->table_headers_korut_get_point)'
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
		  </v-tab-item>
	</v-tabs>
@endsection

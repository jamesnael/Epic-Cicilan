@extends('app')

@section('content')

	@include('components.breadcrumbs')

	@php
		//Sales
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

        //Agent
        $page->table_headers_agent[] = [
            "text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Aksi',
            "align" => 'center',
            "sortable" => false,
            "value" => 'actions',
        ];
        $page->table_headers_agent = collect($page->table_headers_agent)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();

        //Korwil
        $page->table_headers_korwil[] = [
            "text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Aksi',
            "align" => 'center',
            "sortable" => false,
            "value" => 'actions',
        ];
        $page->table_headers_korwil = collect($page->table_headers_korwil)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();

        //Korut
        $page->table_headers_korut[] = [
            "text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Aksi',
            "align" => 'center',
            "sortable" => false,
            "value" => 'actions',
        ];
        $page->table_headers_korut = collect($page->table_headers_korut)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();
	@endphp
	<v-tabs>
	    <v-tab>Data Point Sales</v-tab>
      	<v-tab-item>
			<sales-table inline-template
				uri="{{ route('tukar-point-sales.table') }}"
				:headers='@json($page->table_headers)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				add-new-uri="{{ route('tukar-point.create') }}"
				add-new-text="Tukar Point"
				add-new-color="light-blue lighten-2"
				edit-uri="tukar-point-sales.history"
				edit-uri-parameter="id"
				edit-text="History"
				edit-icon="mdi-history"
				>
				@include('components.table')
			</sales-table>
	   	</v-tab-item>

	   	<v-tab>Data Point Sub Agent</v-tab>
      	<v-tab-item>
			<agent-table inline-template
				uri="{{ route('tukar-point-agent.table') }}"
				:headers='@json($page->table_headers_agent)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				add-new-uri="{{ route('tukar-point.create') }}"
				add-new-text="Tukar Point"
				add-new-color="light-blue lighten-2"
				edit-uri="tukar-point-agent.history"
				edit-uri-parameter="id"
				edit-text="History"
				edit-icon="mdi-history"
				>
				@include('components.table')
			</agent-table>
		</v-tab-item>

		<v-tab>Data Point Korwil</v-tab>
      	<v-tab-item>
			<korwil-table inline-template
				uri="{{ route('tukar-point-korwil.table') }}"
				:headers='@json($page->table_headers_korwil)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				add-new-uri="{{ route('tukar-point.create') }}"
				add-new-text="Tukar Point"
				add-new-color="light-blue lighten-2"
				edit-uri="tukar-point-korwil.history"
				edit-uri-parameter="id"
				edit-text="History"
				edit-icon="mdi-history"
				>
				@include('components.table')
			</korwil-table>
		</v-tab-item>
		<v-tab>Data Point Korut</v-tab>
      	<v-tab-item>
			<korut-table inline-template
				uri="{{ route('tukar-point-korut.table') }}"
				:headers='@json($page->table_headers_korut)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				add-new-uri="{{ route('tukar-point.create') }}"
				add-new-text="Tukar Point"
				add-new-color="light-blue lighten-2"
				edit-uri="tukar-point-korut.history"
				edit-uri-parameter="id"
				edit-text="History"
				edit-icon="mdi-history"
				>
				@include('components.table')
			</korut-table>
      	</v-tab-item>
	</v-tabs>
@endsection

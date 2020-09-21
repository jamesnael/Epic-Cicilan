@extends('app')

@push('table_slot')
    <template v-slot:item.prints="{ item }">
    	<v-tooltip top color="primary">
		    <template v-slot:activator="{ on, attrs }">
	    		<v-btn 
		    		icon 
		    		color="primary" 
		    		v-bind="attrs" 
		    		v-on="on"
		    		:href="ziggy('spr.print', [item['slug']]).url()"
		    		target="_blank"
	    		>
					<v-icon small>mdi-printer</v-icon>
	            </v-btn>
		    </template>
		    <span>Print Dokumen SPR</span>
		</v-tooltip>
	</template>
@endpush

@section('content')

	@include('components.breadcrumbs')

	@php
		$page->table_headers[] = [
            "text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Aksi',
            "align" => 'center',
            "sortable" => false,
            "value" => 'actions',
        ];
        $page->table_headers[] = [
            "text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Cetak',
            "align" => 'center',
            "sortable" => false,
            "value" => 'prints',
        ];

        $page->table_headers = collect($page->table_headers)->prepend([
            "text" => '#',
            "align" => 'center',
            "sortable" => false,
            "value" => 'table_index',
        ])->values();

        $page->table_headers_2[] = [
            "text" => config('app.locale', 'en') == 'en' ? 'Actions' : 'Cetak',
            "align" => 'center',
            "sortable" => false,
            "value" => 'prints',
        ];
        $page->table_headers_2 = collect($page->table_headers_2)->prepend([
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
				uri="{{ route('spr.table') }}"
				:headers='@json($page->table_headers)'
				no-data-text="Tidak ada data ditemukan."
				no-results-text="Tidak ada data ditemukan."
				search-text="Pencarian"
				refresh-text="Muat Ulang"
				items-per-page-all-text="Semua"
				items-per-page-text="Tampilkan"
				page-text-locale="id"
				edit-uri="spr.edit"
				edit-uri-parameter="slug"
				edit-text="Edit SPR"
				>
				
				@include('components.table')
			</table-layout>
		</v-tab-item>

		<v-tab>Approved</v-tab>
      	<v-tab-item>
			<table-layout inline-template
				uri="{{ route('spr.table.approved') }}"
				:headers='@json($page->table_headers_2)'
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
		</v-tab-item>
	</v-tabs>

@endsection

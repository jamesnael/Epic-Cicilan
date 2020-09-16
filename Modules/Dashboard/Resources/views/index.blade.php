@extends('app')

@section('content')
	@include('components.breadcrumbs')
	<dashboard-layout inline-template>
		<v-container fluid>
        	<v-card flat>
			    <v-card
		            elevation="5"
		            >
		            <v-card-title>
		                Notifikasi
		            </v-card-title>
		            <v-card-text>
		            	<v-list-item>
		        	      	<v-list-item-content>
		        	        	<v-list-item-title>
		        	        		<v-badge
							          class="mr-4 ml-2"
							          color="green"
							          content="{{$document ?? '0'}}"
							        >
							        </v-badge>
								 	Dokumen pengajuan klien yang belum di verifikasi
								<v-list-item-title>
		        	      	</v-list-item-content>
		        	    </v-list-item>
		        	    <v-list-item>
		        	      	<v-list-item-content>
		        	        	<v-list-item-title>
									<v-badge
							          	class="mr-4 ml-2"
							          	color="blue"
							          	content="{{$akad_kpr ?? '0'}}"
							        >
							        </v-badge>
			        	        	Akad KPR yang belum dibuat jadwal
			        	        </v-list-item-title>
		        	      	</v-list-item-content>
		        	    </v-list-item>
		        	    <v-list-item>
		        	      	<v-list-item-content>
		        	        	<v-list-item-title>
									<v-badge
							          	class="mr-4 ml-2"
							          	color="indigo"
							          	content="{{$ajb ?? '0'}}"
							        >
							        </v-badge>
			        	        	AJB yang belum dibuat jadwal
			        	        </v-list-item-title>
		        	      	</v-list-item-content>
		        	    </v-list-item>
		        	    <v-list-item>
		        	      	<v-list-item-content>
		        	        	<v-list-item-title>
		        	        		<v-badge
							          	class="mr-4 ml-2"
							          	color="red"
							          	content="{{$handover ?? '0'}}"
							        >
							        </v-badge>
							    	Serah terima unit yang belum dibuat jadwal
							    </v-list-item-title>
		        	      	</v-list-item-content>
		        	    </v-list-item>
		        	    <v-list-item>
		        	      	<v-list-item-content>
		        	        	<v-list-item-title>
		        	        		<v-badge
							          	class="mr-4 ml-2"
							          	color="purple"
							          	content="{{$installment_pending ?? '0'}}"
							        >
							        </v-badge>
							    	Pembayaran cicilan unit yang sudah jatuh tempo
							    </v-list-item-title>
		        	      	</v-list-item-content>
		        	    </v-list-item>
		            </v-card-text>
		        </v-card>

		        <v-card
		        	class="mt-4"
		            elevation="5"
		            >
		            <v-card-title>
		                Informasi Pembayaran Cicilan
		            </v-card-title>

		            <v-card-text>
		            	<v-row>
		            		<v-col
								cols="12"
		    		          	md="6"
		            		>
				            	<v-card
				            	    class="mx-auto text-center"
				            	    color="purple"
				            	    dark
				            	  >
				            	    <v-card-text>
				            	    	<div class="display-1 font-weight-thin">{{$installment_pending ?? '0'}}</div>
				            	    </v-card-text>

				            	    <v-card-text>
				            	      <div class="display-1 font-weight-thin">Cicilan Unit Yang Belum Dibayar</div>
				            	    </v-card-text>

				            	    <v-divider></v-divider>

				            	    <v-card-actions class="justify-center">
				            	      <v-btn block text>Detail</v-btn>
				            	    </v-card-actions>
				            	</v-card>
							</v-col>
							<v-col
								cols="12"
		    		          	md="6"
							>
				            	<v-card
				            	    class="mx-auto text-center"
				            	    color="green"
				            	    dark
				            	  >
				            	    <v-card-text>
				            	    	<div class="display-1 font-weight-thin">{{$installment_paid ?? '0'}}</div>
				            	    </v-card-text>

				            	    <v-card-text>
				            	      <div class="display-1 font-weight-thin">Cicilan Unit Yang Sudah Dibayar</div>
				            	    </v-card-text>

				            	    <v-divider></v-divider>

				            	    <v-card-actions class="justify-center">
				            	      <v-btn block text>Detail</v-btn>
				            	    </v-card-actions>
				            	</v-card>
			            	</v-col>   
			           	</v-row> 

			           	<v-row>
		            		<v-col
								cols="12"
		    		          	md="6"
		            		>
				            	<v-card
				            	    class="mx-auto text-center"
				            	    color="blue"
				            	    dark
				            	  >
				            	    <v-card-text>
				            	    	 <div class="display-1 font-weight-thin">Rp 5.456.789.000</div>
				            	    </v-card-text>

				            	    <v-card-text>
				            	      <div class="display-1 font-weight-thin">Total Cicilan Belum Dibayar</div>
				            	    </v-card-text>

				            	    <v-divider></v-divider>

				            	    <v-card-actions class="justify-center">
				            	      <v-btn block text>Detail</v-btn>
				            	    </v-card-actions>
				            	</v-card>
							</v-col>
							<v-col
								cols="12"
		    		          	md="6"
							>
				            	<v-card
				            	    class="mx-auto text-center"
				            	    color="red"
				            	    dark
				            	  >
				            	    <v-card-text>
				            	    	<div class="display-1 font-weight-thin">Rp 5.456.123.000</div>
				            	    </v-card-text>

				            	    <v-card-text>
				            	      <div class="display-1 font-weight-thin">Total Cicilan Sudah Dibayar</div>
				            	    </v-card-text>

				            	    <v-divider></v-divider>

				            	    <v-card-actions class="justify-center">
				            	      <v-btn block text>Detail</v-btn>
				            	    </v-card-actions>
				            	</v-card>
			            	</v-col>   
			           	</v-row> 
		            </v-card-text>
		        </v-card>

		        <v-card
		        	class="mt-4"
		            elevation="5"
		            >
		            <v-card-title>
		                Informasi Pembayaran Cicilan Bulan {{\Carbon\Carbon::now()->locale('id')->translatedFormat('F Y')}}
		            </v-card-title>

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

		            <v-card-text>
		            	<v-tabs>
	            		    <v-tab>Belum Bayar</v-tab>
	            	      	<v-tab-item>
	            				<table-layout inline-template
	            					uri=""
	            					:headers='@json($page->table_headers)'
	            					no-data-text="Tidak ada data ditemukan."
	            					no-results-text="Tidak ada data ditemukan."
	            					search-text="Pencarian"
	            					refresh-text="Muat Ulang"
	            					items-per-page-all-text="Semua"
	            					items-per-page-text="Tampilkan"
	            					page-text-locale="id"
	            					edit-uri="installment.edit"
	            					edit-uri-parameter="slug"
	            					edit-text="Edit Serah Terima Unit"
	            					>
	            					
	            					@include('components.table')
	            				</table-layout>
	            			</v-tab-item>
	            			<v-tab>Bayar</v-tab>
	            	      	<v-tab-item>
	            	      		<table-layout inline-template
	            					uri=""
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
	            			</v-tab-item>
	            		</v-tabs> 
		            </v-card-text>
		        </v-card>

		        <v-card
		        	class="mt-4"
		            elevation="5"
		            >
		            <v-card-title>
		                Jadwal PPJB, AJB, dan Handover Unit Klien
		            </v-card-title>

		            <v-card-text>
						<div>
						    <v-sheet
						      tile
						      height="54"
						      color="grey lighten-3"
						      class="d-flex"
						    >
						      <v-btn
						        icon
						        class="ma-2"
						        @click="$refs.calendar.prev()"
						      >
						       	<v-icon>mdi-chevron-left</v-icon>
						      </v-btn>
						      <v-spacer></v-spacer>
						      <v-btn
						        icon
						        class="ma-2"
						        @click="$refs.calendar.next()"
						      >
						        <v-icon>mdi-chevron-right</v-icon>
						      </v-btn>
						    </v-sheet>
						    <v-sheet height="600">
						      <v-calendar
						        ref="calendar"
						        v-model="value"
						        :weekdays="weekday"
						        :type="type"
						        :events="events"
						        :event-overlap-mode="mode"
						        :event-overlap-threshold="30"
						        :event-color="getEventColor"
						        @change="getEvents"
						      ></v-calendar>
						    </v-sheet>
						  </div>
		            </v-card-text>

	            	
		        </v-card>
		    </v-card>
	    </v-container>
    </dashboard-layout>
@endsection

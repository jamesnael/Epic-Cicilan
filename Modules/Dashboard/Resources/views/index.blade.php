@extends('app')

@section('content')
	@include('components.breadcrumbs')
	@if(Auth::user()->is_admin || Auth::user()->status == 'koordinator_utama')
		<dashboard-layout inline-template
		:events_calendar='@json($events)'>
			<v-container fluid>
	        	<v-card flat>
	        		<v-row>
	        			<v-col 
	        				cols="12"
		                    md="5">
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
					        	        		<v-btn text small href="{{ route('document-admin.index') }}">
												 	Dokumen pengajuan belum disetujui
												</v-btn>
											</v-list-item-title>
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
										        <v-btn text small href="{{ route('akad.index') }}">
						        	        		Akad KPR yang masih pending
						        	        	</v-btn>
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
										        <v-btn text small href="{{ route('ajb.index') }}">
							        	        	AJB yang masih pending
							        	        </v-btn>
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
										        <v-btn text small href="{{ route('handover.index') }}">
											    	Serah terima unit yang masih pending
											    </v-btn>
										    </v-list-item-title>
					        	      	</v-list-item-content>
					        	    </v-list-item>
					        	    <v-list-item>
					        	      	<v-list-item-content>
					        	        	<v-list-item-title class="mb-11">
					        	        		<v-badge
										          	class="mr-4 ml-2"
										          	color="purple"
										          	content="{{$installment_pending ?? '0'}}"
										        >
										        </v-badge>
										        <v-btn text small href="{{ route('installment-unit.index') }}">
											    	Pembayaran cicilan yang jatuh tempo
											    </v-btn>	
										    </v-list-item-title>
					        	      	</v-list-item-content>
					        	    </v-list-item>
					            </v-card-text>
					        </v-card>
						</v-col>

						<v-col
	        				cols="12"
		                    md="7">
					        <v-card
					            elevation="5"
					            >
					            <v-card-title>
					                Informasi Pembayaran Cicilan Bulan {{\Carbon\Carbon::now()->locale('id')->translatedFormat('F Y')}}
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
							            	    	<div class="text-h5 font-weight-thin">{{$installment_pending ?? '0'}}</div>
							            	    </v-card-text>

							            	    <v-card-text>
							            	      <div class="text-h6 font-weight-thin">Pembayaran Cicilan Unit Belum Dibayar</div>
							            	    </v-card-text>

							            	    <v-divider></v-divider>

							            	    {{-- <v-card-actions class="justify-center">
							            	      <v-btn block text>Detail</v-btn>
							            	    </v-card-actions> --}}
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
							            	    	<div class="text-h5 font-weight-thin">{{$installment_paid ?? '0'}}</div>
							            	    </v-card-text>

							            	    <v-card-text>
							            	      <div class="text-h6 font-weight-thin">Pembayaran Cicilan Unit Sudah Dibayar</div>
							            	    </v-card-text>

							            	    <v-divider></v-divider>

							            	    {{-- <v-card-actions class="justify-center">
							            	      <v-btn block text>Detail</v-btn>
							            	    </v-card-actions> --}}
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
							            	    	 <div class="text-h5 font-weight-thin">Rp {{$unpaid ? number_format($unpaid) : 0}}</div>
							            	    </v-card-text>

							            	    <v-card-text>
							            	      <div class="text-h6 font-weight-thin">Total Cicilan Belum Dibayar</div>
							            	    </v-card-text>

							            	    <v-divider></v-divider>

							            	    {{-- <v-card-actions class="justify-center">
							            	      <v-btn block text>Detail</v-btn>
							            	    </v-card-actions> --}}
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
							            	    	<div class="text-h5 font-weight-thin">Rp {{$paid ? number_format($paid) : 0}}</div>
							            	    </v-card-text>

							            	    <v-card-text>
							            	      <div class="text-h6 font-weight-thin">Total Cicilan Sudah Dibayar</div>
							            	    </v-card-text>

							            	    <v-divider></v-divider>

							            	    {{-- <v-card-actions class="justify-center">
							            	      <v-btn block text>Detail</v-btn>
							            	    </v-card-actions> --}}
							            	</v-card>
						            	</v-col>   
						           	</v-row> 
					            </v-card-text>
					        </v-card>
				        </v-col>
					</v-row>
			        <v-card
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
		            					uri="{{ route('dashboard.table') }}"
		            					:headers='@json($page->table_headers)'
		            					no-data-text="Tidak ada data ditemukan."
		            					no-results-text="Tidak ada data ditemukan."
		            					search-text="Pencarian"
		            					refresh-text="Muat Ulang"
		            					items-per-page-all-text="Semua"
		            					items-per-page-text="Tampilkan"
		            					page-text-locale="id"
		            					edit-uri="installment-unit.edit"
		            					edit-uri-parameter="slug"
		            					edit-text="Edit Serah Terima Unit"
		            					>
		            					
		            					@include('components.table')
		            				</table-layout>
		            			</v-tab-item>
		            			<v-tab>Bayar</v-tab>
		            	      	<v-tab-item>
		            	      		<table-layout inline-template
		            					uri="{{ route('dashboard-paid.table') }}"
		            					:headers='@json($page->table_headers)'
		            					no-data-text="Tidak ada data ditemukan."
		            					no-results-text="Tidak ada data ditemukan."
		            					search-text="Pencarian"
		            					refresh-text="Muat Ulang"
		            					items-per-page-all-text="Semua"
		            					items-per-page-text="Tampilkan"
		            					page-text-locale="id"
		            					edit-uri="installment-unit.edit"
		            					edit-uri-parameter="slug"
		            					edit-text="Edit Serah Terima Unit"
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
							<v-row class="fill-height">
							    <v-col>
							      <v-sheet height="64">
							        <v-toolbar flat color="white">
							          <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">
							            Today
							          </v-btn>
							          <v-btn fab text small color="grey darken-2" @click="prev">
							            <v-icon small>mdi-chevron-left</v-icon>
							          </v-btn>
							          <v-btn fab text small color="grey darken-2" @click="next">
							            <v-icon small>mdi-chevron-right</v-icon>
							          </v-btn>
							          <v-toolbar-title v-if="$refs.calendar">
							            @{{ $refs.calendar.title }}
							          </v-toolbar-title>
							          <v-spacer></v-spacer>
							          <v-menu bottom right>
							            <template v-slot:activator="{ on, attrs }">
							              <v-btn
							                outlined
							                color="grey darken-2"
							                v-bind="attrs"
							                v-on="on"
							              >
							                <span>@{{ typeToLabel[type] }}</span>
							                <v-icon right>mdi-menu-down</v-icon>
							              </v-btn>
							            </template>
							            <v-list>
							              <v-list-item @click="type = 'day'">
							                <v-list-item-title>Day</v-list-item-title>
							              </v-list-item>
							              <v-list-item @click="type = 'week'">
							                <v-list-item-title>Week</v-list-item-title>
							              </v-list-item>
							              <v-list-item @click="type = 'month'">
							                <v-list-item-title>Month</v-list-item-title>
							              </v-list-item>
							              <v-list-item @click="type = '4day'">
							                <v-list-item-title>4 days</v-list-item-title>
							              </v-list-item>
							            </v-list>
							          </v-menu>
							        </v-toolbar>
							      </v-sheet>
							      <v-sheet height="600">
							        <v-calendar
							        	
							          ref="calendar"
							          v-model="focus"
							          color="primary"
							          :events="events"
							          :event-color="getEventColor"
							          :type="type"
							          @click:event="showEvent"
							          @click:more="viewDay"
							          @click:date="viewDay"
							          @change="updateRange"
							        ></v-calendar>
							        <v-menu
							          v-model="selectedOpen"
							          :close-on-content-click="false"
							          :activator="selectedElement"
							          offset-x
							        >
							          <v-card
							            color="grey lighten-4"
							            min-width="350px"
							            flat
							          >
							            <v-toolbar
							              :color="selectedEvent.color"
							              dark
							            >
							              <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
							              <v-spacer></v-spacer>
							            </v-toolbar>
							            <v-card-text>
							            	<table width="100%" border="0" class="mt-2">
				            	  			<tr>
				            	  				<td width="35%">Nama Klien</td>
				            	  				<td>:</td>
				            	  				<td width="60%">@{{ selectedEvent.client }}</td>
				            	  			</tr>
				            	  			<tr>
				            	  				<td>Nomor Unit</td>
				            	  				<td>:</td>
				            	  				<td>@{{ selectedEvent.unit }}</td>
				            	  			</tr>
				            	  			<tr>
				            	  				<td>Lokasi Jadwal @{{selectedEvent.name}}</td>
				            	  				<td>:</td>
				            	  				<td>@{{ selectedEvent.address }}</td>
				            	  			</tr>
				            	  			<tr>
				            	  				<td>Tanggal @{{selectedEvent.name}}</td>
				            	  				<td>:</td>
				            	  				<td>@{{ reformatDateTime(selectedEvent.start, 'YYYY-MM-DD hh:mm', 'DD MMMM YYYY HH:mm') }}</td>
				            	  			</tr>
				            	  		</table>
							              {{-- <span v-html="selectedEvent.client"></span><br>
							              <span v-html="selectedEvent.unit"></span><br>
							              <span v-html="selectedEvent.address"></span><br> --}}
							            </v-card-text>
							            <v-card-actions>
							              <v-btn
							                text
							                color="secondary"
							                @click="selectedOpen = false"
							              >
							                Kembali
							              </v-btn>
							            </v-card-actions>
							          </v-card>
							        </v-menu>
							      </v-sheet>
							    </v-col>
							</v-row>
			            </v-card-text>
			        </v-card>
			    </v-card>
		    </v-container>
	    </dashboard-layout>
	@endif
@endsection

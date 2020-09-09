@extends('payment::layouts.master')

@section('content')
	<payment-form inline-template
	uri="{{ route('installment-unit.update', [$data]) }}"
	data-uri="{{ route('installment-unit.data', [$data]) }}">
	    <v-container >
            <v-card
	            elevation="5"
            	>
            	<v-card-title>
            		Informasi Data Klien
            	</v-card-title>
            	<v-card-text>
                    <v-row>
                        <v-col
                            cols="12"
                            md="6">
                            <v-text-field
                                v-model="form_data.client_number"
                                label="ID Klien"
                                :readonly="!field_state"
                                :disabled="field_state">
                            </v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            md="6">
                            <v-text-field
                                v-model="form_data.client_name"
                                label="Nama Klien"
                                :readonly="!field_state"
                                :disabled="field_state">
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="6">
                            <v-text-field
                                v-model="form_data.client_mobile_number"
                                label="Nomor Telepon"
                                :readonly="!field_state"
                                :disabled="field_state">
                            </v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            md="6">
                            <v-text-field
                                v-model="form_data.client_email"
                                label="Alamat Email"
                                :readonly="!field_state"
                                :disabled="field_state">
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="6">
                            <v-text-field
                                v-model="form_data.client_address"
                                label="Alamat Klien"
                                :readonly="!field_state"
                                :disabled="field_state">
                            </v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            md="6">
                            <v-text-field
                                v-model="form_data.sales_name"
                                label="Nama Sales"
                                :readonly="!field_state"
                                :disabled="field_state">
                            </v-text-field>
                        </v-col>
                    </v-row>
            	</v-card-text>
            </v-card>

            <v-card
            	class="mt-6"
            	elevation="5"
            	>
            	<v-card-title>
            		Informasi Data Unit
            	</v-card-title>
            	<v-card-text>
            		<v-row>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.unit_type"
            		            label="Tipe Rumah"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.unit_block"
            		            label="Blok"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.unit_number"
            		            label="Nomor Unit"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		</v-row>
            		<v-row>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.surface_area"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		            <template slot="label">
            		            	<span v-html="'Luas Kavling (m<sup>2</sup>)'"></span>
            		            </template>
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.building_area"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		            <template slot="label">
            		            	<span v-html="'Luas Bangunan (m<sup>2</sup>)'"></span>
            		            </template>
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.electrical_power"
            		            label="Daya Listrik (Watt)"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		</v-row>
            	</v-card-text>
            </v-card>

            <v-row
                class="mt-6">
                <v-col
                    cols="12"
                    md="6">
                    <v-card
                    	elevation="5"
    	            	>
    	            	<v-card-title>
    	            		Informasi Data NUP
    	            	</v-card-title>
    	            	<v-card-text>
	                        <v-row>
	                            <v-col
	                                cols="12">
	                                <v-text-field
	                                    :value="number_format(form_data.nup_amount)"
	                                    label="Total NUP"
	                                    :readonly="!field_state"
		                                :disabled="field_state">
	                                </v-text-field>
	                            </v-col>
	                            <v-col
	                                cols="12">
	                                <v-text-field
	                                    v-model="form_data.payment_method_nup"
	                                    label="Metode Pembayaran"
	                                    :readonly="!field_state"
		                                :disabled="field_state">
	                                </v-text-field>
	                            </v-col>
	                            <v-col
	                                cols="12">
	                                <v-text-field
		                                :value="reformatDateTime(form_data.nup_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
	                                    label="Tanggal Pembayaran"
	                                    :readonly="!field_state"
		                                :disabled="field_state">
	                                </v-text-field>
	                            </v-col>
	                        </v-row>
    	            	</v-card-text>
    	            </v-card>                        
                </v-col>
                <v-col
                    cols="12"
                    md="6">
                    <v-card
                    	elevation="5"
    	            	>
    	            	<v-card-title>
    	            		Informasi Data UTJ
    	            	</v-card-title>
    	            	<v-card-text>
	                        <v-row>
	                            <v-col
	                                cols="12">
	                                <v-text-field
	                                    :value="number_format(form_data.utj_amount)"
	                                    label="Total UTJ"
	                                    :readonly="!field_state"
		                                :disabled="field_state">
	                                </v-text-field>
	                            </v-col>
	                            <v-col
	                                cols="12">
	                                <v-text-field
	                                    v-model="form_data.payment_method_utj"
	                                    label="Metode Pembayaran"
	                                    :readonly="!field_state"
		                                :disabled="field_state">
	                                </v-text-field>
	                            </v-col>
	                            <v-col
	                                cols="12">
	                                <v-text-field
	                                	:value="reformatDateTime(form_data.utj_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
	                                    label="Tanggal Pembayaran"
	                                    :readonly="!field_state"
		                                :disabled="field_state">
	                                </v-text-field>
	                            </v-col>
	                        </v-row>
    	            	</v-card-text>
    	            </v-card>
                </v-col>
            </v-row>

            <v-card
                class="mt-6"
                elevation="5"
            	>
            	<v-card-title>
            		Informasi Pembayaran
            	</v-card-title>
            	<v-card-text>
            		<v-row>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.payment_type"
            		            label="Tipe Pembayaran"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            :value="number_format(form_data.total_amount)"
            		            label="Total Harga"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            :value="number_format(form_data.first_payment)"
            		            label="Pembayaran Pertama"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		</v-row>
            		<v-row>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            :value="number_format(form_data.principal)"
            		            label="Principal"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            :value="number_format(form_data.installment)"
            		            label="Cicilan per Bulan"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		    <v-col
            		        cols="12"
            		        md="4">
            		        <v-text-field
            		            v-model="form_data.installment_time"
            		            label="Lama Cicilan"
            		            :readonly="!field_state"
            		            :disabled="field_state">
            		        </v-text-field>
            		    </v-col>
            		</v-row>
            	</v-card-text>
            </v-card>

            <v-card
            	class="mt-6"
            	elevation="5"
            	>
            	<v-card-title>
            		Data Cicilan Unit
            	</v-card-title>
            	<v-card-text>
            		<v-data-table
            		    :headers='@json($table_headers)'
            		    :items="form_data.payments"
            		    :items-per-page="1000"
        		        hide-default-footer
            		    class="elevation-5"
            		>
    			    	@foreach ($table_headers as $element)
    				    	<template v-slot:header.{{$element['value']}}="{ header }">
    				    	    <strong>@{{ header.text.toUpperCase() }}</strong>
    				    	</template>
    			    	@endforeach
    			    	<template v-slot:no-data>
    				        Tidak ada data ditemukan.
    			    	</template>
    			    	<template v-slot:no-results>
    				        Tidak ada data ditemukan.
    			    	</template>
		    	    	<template v-slot:item.due_date="{ item }">
		    	    		@{{reformatDateTime(item.due_date, 'YYYY-MM-DD', 'DD MMMM YYYY')}}
		    	    	</template>
		    	    	<template v-slot:item.installment="{ item }">
		    	    		@{{number_format(item.installment)}}
		    	    	</template>
		    	    	<template v-slot:item.number_of_delays="{ item }">
		    	    		@{{item.number_of_delays}}
		    	    	</template>
                        <template v-slot:item.fine="{ item }">
                            @{{number_format(item.fine * item.number_of_delays)}}
                        </template>
		    	    	<template v-slot:item.credit="{ item }">
		    	    		@{{number_format(item.credit)}}
		    	    	</template>
		    	    	<template v-slot:item.payment_date="{ item }">
		    	    		@{{reformatDateTime(item.payment_date, 'YYYY-MM-DD', 'DD MMMM YYYY')}}
		    	    	</template>
		    	    	<template v-slot:item.actions="{ item }">
		    	    		<span v-if="item.payment == 'Uang Tanda Jadi' || item.payment == 'Akad Kredit' || item.payment_date"></span>
                            <v-dialog v-else v-model="item.dialog" persistent max-width="500">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        color="primary"
                                        small
                                        v-bind="attrs"
                                        v-on="on"
                                    >
                                        Bayar
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title class="headline">@{{item.payment}}</v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        <v-card
                                            class="mt-5"
                                            elevation="5">
                                            <v-list dense>
                                                <v-list-item>
                                                    <v-list-item-content>Jatuh Tempo:</v-list-item-content>
                                                    <v-list-item-content class="align-end">@{{ reformatDateTime(item.due_date, 'YYYY-MM-DD', 'DD MMMM YYYY') }}</v-list-item-content>
                                                </v-list-item>

                                                <v-list-item>
                                                    <v-list-item-content>Angsuran:</v-list-item-content>
                                                    <v-list-item-content class="align-end">@{{ number_format(item.installment) }}</v-list-item-content>
                                                </v-list-item>

                                                <v-list-item>
                                                    <v-list-item-content>Telat (Hari):</v-list-item-content>
                                                    <v-list-item-content class="align-end">@{{ item.number_of_delays }}</v-list-item-content>
                                                </v-list-item>

                                                <v-list-item>
                                                    <v-list-item-content>Denda:</v-list-item-content>
                                                    <v-list-item-content class="align-end">@{{ number_format(item.fine * item.number_of_delays) }}</v-list-item-content>
                                                </v-list-item>

                                                <v-divider></v-divider>

                                                <v-list-item>
                                                    <v-list-item-content><strong>Total Pembayaran:</strong></v-list-item-content>
                                                    <v-list-item-content class="align-end"><strong>@{{ number_format(item.installment + item.fine * item.number_of_delays) }}</strong></v-list-item-content>
                                                </v-list-item>
                                            </v-list>
                                        </v-card>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn text @click="item.dialog = false" :disabled="field_state">Tutup</v-btn>
                                        <v-btn
                                            color="primary"
                                            :loading="field_state"
                                            :disabled="field_state"
                                            color="secondary"
                                            @click="loader = 'field_state';postPayment(item)"
                                        >
                                            Bayar Sekarang
                                            <template v-slot:loader>
                                                <span class="custom-loader">
                                                    <v-icon light>mdi-sync</v-icon>
                                                </span>
                                            </template>
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
		    	    	</template>
            		</v-data-table>

                    <v-row
                    	class="mt-6">
                        <v-col
                            cols="12"
                            md="4">
                            <v-text-field
		                        :value="number_format(form_data.total_pembayaran)"
		                        label="Total Pembayaran"
		                        :readonly="!field_state"
		                        :disabled="field_state">
		                    </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="4">
                            <v-text-field
		                    	:value="number_format(form_data.sisa_tunggakan)"
		                        label="Sisa Tunggakan"
		                        :readonly="!field_state"
		                        :disabled="field_state">
		                    </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="4">
                            <v-text-field
		                    	:value="number_format(form_data.total_denda)"
		                        label="Total Denda"
		                        :readonly="!field_state"
		                        :disabled="field_state">
		                    </v-text-field>
                        </v-col>
                    </v-row>

            	</v-card-text>
            </v-card>

            <v-snackbar
                v-model="formAlert"
                top
                multi-line
                :color="formAlertState"
                elevation="5"
                timeout="6000"
            >
                @{{ formAlertText }}
            </v-snackbar>

            <v-overlay
	            :value="overlay">
	            <v-row
                    class="fill-height"
                    align-content="center"
                    justify="center"
                >
                    <v-col
                      	class="subtitle-1 text-center"
                      	cols="12"
                    >
                      	@{{progressText}}
                    </v-col>
                    <v-col 
	                    cols="12"
	                    class="subtitle-1 text-center">
			            <v-progress-circular indeterminate size="64"></v-progress-circular>
                    </v-col>
                </v-row>
            </v-overlay>
	    </v-container>
	</payment-form>
@endsection

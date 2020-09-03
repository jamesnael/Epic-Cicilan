<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
    			<h3 class="mt-5">Data Penjualan</h3>
	    		<v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.client_name"
				    			name="client_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state"
					    		label="Nama Klien">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.unit_type"
					    		label="Tipe Rumah"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state"
					    	>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row class="mt-4"> 
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.unit_number"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nomor Unit"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.unit_price"
				    			name="unit_price"
					    		:error-messages="errors"
					    		label="Harga Unit + PPN"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.unit_price ? number_format(form_data.unit_price) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.payment_method"
				    			name="payment_method"
					    		:error-messages="errors"
					    		label="Cara Bayar"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_name"
				    			name="sales_name"
					    		label="Nama Sales"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
				    	<v-menu
		    		        v-model="menu2"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal Transaksi" rules="">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.transaction_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
					    		:error-messages="errors"
		    		            label="Tanggal Transaksi"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker v-model="form_data.transaction_date" @input="menu2 = false">
	    		        	</v-date-picker>
	    		        </v-menu>
				    </v-col>
			    </v-row>
    			<h3 class="mt-5">Pembayaran Komisi Sub Agent</h3>
    			<v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_name"
				    			name="agency_name"
					    		:error-messages="errors"
					    		label="Nama Sub Agent"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_commission"
				    			name="agency_commission"
					    		label="Komisi Sub Agent (%)"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.pph_final"
				    			label="PPH Final (%)"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			:value="pph21"
					    		label="PPH 21 (%)"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			:value="bruto_commission"
					    		label="Komisi Bruto"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{bruto_commission ? number_format(bruto_commission) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>

			    <h4 class="mt-3">Pencairan Komisi 1</h4>
			    <v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Pencairan 1 Komisi (50%)" rules="required|numeric">
				    		<v-text-field
				    			v-model="commission_1"
				    			name="commission_1"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Pencairan 1 Komisi (50%)"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{commission_1 ? number_format(commission_1) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
				    	<v-menu
		    		        v-model="menu3"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.payment_date_1, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Pembayaran"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="payment_date_1" v-model="form_data.payment_date_1" @input="menu3 = false">
	    		        	</v-date-picker>
	    		        </v-menu>
				    </v-col>
			    </v-row>
			    <v-row class="mt-4">
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="No invoice" rules="">
				    		<v-text-field
				    		 	v-model="form_data.invoice_commission_1"
				    		 	name="invoice_commission_1"
					    		label="No Invoice"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Upload Bukti Pembayaran" rules="required">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            label="Upload Bukti Pembayaran"
				              	name="payment_proof1"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	>
			              </v-file-input>
			              <a :href="form_data.url_payment_proof_1" target="_blank" class="ml-8">
			              	<small>@{{form_data.payment_proof_1}}</small>
			              </a>
			           </validation-provider>
		          </v-col>
			    </v-row>

			    <h4 class="mt-3">Pencairan Komisi 2</h4>
			    <v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Pencairan 2 Komisi (50%)" rules="required|numeric">
				    		<v-text-field
				    			v-model="commission_2"
				    			name="commission_2"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Pencairan 2 Komisi (50%)"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{commission_2 ? number_format(commission_2) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
				    	<v-menu
		    		        v-model="menu4"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.payment_date_2, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Pembayaran"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="payment_date_2" v-model="form_data.payment_date_2" @input="menu4 = false">
	    		        	</v-date-picker>
	    		        </v-menu>
				    </v-col>
			    </v-row>
			    <v-row class="mt-4">
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="No invoice" rules="">
				    		<v-text-field
				    		 	v-model="form_data.invoice_commission_2"
					    		label="No Invoice"
					    		name="invoice_commission_2"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Upload Bukti Pembayaran" rules="">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            label="Upload Bukti Pembayaran"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="payment_proof2">
			              </v-file-input>
			              <a :href="form_data.url_payment_proof_2" target="_blank" class="ml-8">
			              	<small>@{{form_data.payment_proof_2}}</small>
			              </a>
			           </validation-provider>
		          </v-col>
			    </v-row>
			    <h3 class="mt-5">Closing Fee</h3>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.closing_fee"
				    			name="closing_fee"
					    		label="Closing Fee Unit"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.closing_fee ? number_format(form_data.closing_fee) : 0 }}</small>
				    </v-col>
			    </v-row>

			    <h4 class="mt-3">Sales</h4>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_name"
				    			name="sales_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Sales"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sales" rules="numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_sales"
				    			name="closing_fee_sales"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.closing_fee_sales ? number_format(form_data.closing_fee_sales) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
				<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6"
    		          	>
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_bank_name"
				    			name="sales_bank_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Bank"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_no_rek"
				    			name="sales_no_rek"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="No Rekening"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6"
    		          	class="mt-4">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_bank_account"
				    			name="sales_bank_account"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Rek Atas Nama"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6"
    		          	class="mt-4">
				    	<v-menu
		    		        v-model="menu5"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.sales_payment_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Pembayaran"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="sales_payment_date" v-model="form_data.sales_payment_date" @input="menu5 = false">
	    		        	</v-date-picker>
	    		        </v-menu>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6"
    		          	class="mt-4">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_invoice"
				    			name="sales_invoice"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="No Invoice"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          cols="12"
    		          md="6"
    		          class="mt-4">
			    		<validation-provider v-slot="{ errors }" name="Upload Bukti Pembayaran" rules="">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            label="Upload Bukti Pembayaran"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="sales_evidence_cf">
			              </v-file-input>
			              <a :href="form_data.url_sales_evidence" target="_blank" class="ml-8">
			              	<small>@{{form_data.sales_evidence}}</small>
			              </a>
			           </validation-provider>
		          </v-col>
			    </v-row>
				
				<h4 class="mt-3">Sub Agent</h4>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sub Agent" rules="required">
				    		<v-text-field
				    			v-model="form_data.agency_name"
				    			name="agency_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Sub Agent"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sub Agent" rules="numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_agency"
				    			name="closing_fee_agency"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.closing_fee_agency ? number_format(form_data.closing_fee_agency) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
				    <v-col
			          	cols="12"
			          	md="6">
				    	<v-menu
		    		        v-model="menu6"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.agency_payment_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Pembayaran"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="agency_payment_date" v-model="form_data.agency_payment_date" @input="menu6 = false">
	    		        	</v-date-picker>
	    		        </v-menu>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_invoice"
				    			name="agency_invoice"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="No Invoice"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
				    <v-col
    		          cols="12"
    		          md="6"
    		          class="mt-4">
			    		<validation-provider v-slot="{ errors }" name="Upload Bukti Pembayaran" rules="">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            label="Upload Bukti Pembayaran"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="agency_evidence_cf">
			              </v-file-input>
			              <a :href="form_data.url_agency_evidence" target="_blank" class="ml-8">
			              	<small>@{{form_data.agency_evidence}}</small>
			              </a>
			           </validation-provider>
		          </v-col>
			    </v-row>

			    <h4 class="mt-3">Koordinator Wilayah</h4>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Korwil" rules="required">
				    		<v-text-field
				    			v-model="form_data.korwil_name"
				    			name="korwil_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Korwil"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Korwil" rules="numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_korwil"
				    			name="closing_fee_korwil"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.closing_fee_korwil ? number_format(form_data.closing_fee_korwil) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
		          	cols="12"
		          	md="6">
				    	<v-menu
		    		        v-model="menu7"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.korwil_payment_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Pembayaran"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="korwil_payment_date" v-model="form_data.korwil_payment_date" @input="menu7 = false">
	    		        	</v-date-picker>
	    		        </v-menu>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.korwil_invoice"
				    			name="korwil_invoice"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="No Invoice"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
				    <v-col
    		          cols="12"
    		          md="6"
    		          class="mt-4">
			    		<validation-provider v-slot="{ errors }" name="Upload Bukti Pembayaran" rules="">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            label="Upload Bukti Pembayaran"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="korwil_evidence_cf">
			              </v-file-input>
			              <a :href="form_data.url_korwil_evidence" target="_blank" class="ml-8">
			              	<small>@{{form_data.korwil_evidence}}</small>
			              </a>
			           </validation-provider>
		          </v-col>
			    </v-row>

			    <h4 class="mt-3">Koordinator Utama</h4>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Koordinator Utama" rules="required">
				    		<v-text-field
				    			v-model="form_data.korut_name"
				    			name="korut_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Koordinator Utama"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Koordinator Utama" rules="numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_korut"
				    			name="closing_fee_korut"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.closing_fee_korut ? number_format(form_data.closing_fee_korut) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    </v-row>
			    <v-row>
			    	<v-col
		          	cols="12"
		          	md="6">
				    	<v-menu
		    		        v-model="menu8"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.korut_payment_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Pembayaran"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="korut_payment_date" v-model="form_data.korut_payment_date" @input="menu8 = false">
	    		        	</v-date-picker>
	    		        </v-menu>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.korut_invoice"
				    			name="korut_invoice"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="No Invoice"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
				    <v-col
    		          cols="12"
    		          md="6"
    		          class="mt-4">
			    		<validation-provider v-slot="{ errors }" name="Upload Bukti Pembayaran" rules="">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            label="Upload Bukti Pembayaran"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="korut_evidence_cf">
			              </v-file-input>
			              <a :href="form_data.url_korut_evidence" target="_blank" class="ml-8">
			              	<small>@{{form_data.korut_evidence}}</small>
			              </a>
			           </validation-provider>
		          </v-col>
			    </v-row>
	    		<v-btn
		    		class="mt-4 mr-4 white--text"
		    		color="primary"
	    		    elevation="5"
		    		:disabled="field_state"
		    		:loading="field_state"
		    		@click="submit">
		    		Simpan
	    		    <template v-slot:loader>
    		            <span class="custom-loader">
    		              	<v-icon color="white">mdi-sync</v-icon>
    		            </span>
    		        </template>
		    	</v-btn>
		      	<v-btn
		      		class="mt-4"
		      		outlined 
		      		:disabled="field_state"
    		      	@click="clear">
    		      	Ulangi
    		    </v-btn>
	    	</form>
	    </validation-observer>
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
</v-container>
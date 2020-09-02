<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
    			<h3 class="mt-5">Data Penjualan</h3>
	    		<v-row>
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
			    <v-row>
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
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Harga Unit + PPN"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.unit_price ? number_format(form_data.unit_price) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Cara Bayar" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.payment_method"
				    			name="payment_method"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
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
			    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.sales_name"
				    			name="sales_name"
					    		label="Nama Sales"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
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
			    		<v-menu
	    		        v-model="menu2"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
			    		<validation-provider v-slot="{ errors }" name="Tanggal Transaksi" rules="required">
	    		        <v-text-field
	    		        	hint="* harus diisi"
	    		        	:persistent-hint="true"
				    		:error-messages="errors"
	    		            v-model="form_data.transaction_date"
	    		            label="Tanggal Transaksi"
	    		            readonly
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
			    		</validation-provider>
    		        	</template>
    		        	<v-date-picker v-model="form_data.transaction_date" @input="menu2 = false"></v-date-picker>
				    </v-col>
			    </v-row>
    			<h3 class="mt-5">Pembayaran Komisi Sub Agent</h3>
    			<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_name"
				    			name="agency_name"
					    		:persistent-hint="true"
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
			    		<validation-provider v-slot="{ errors }" name="Komisi Sub Agent" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_commission"
				    			name="agency_commission"
					    		label="Komisi Sub Agent (%)"
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
				    			v-model="form_data.pph_final"
				    			name="pph_final"
					    		:persistent-hint="true"
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
			    		<validation-provider v-slot="{ errors }" name="Tanggal Pembayaran" rules="required">
	    		        <v-text-field
	    		        	hint="* harus diisi"
	    		        	:persistent-hint="true"
				    		:error-messages="errors"
	    		            v-model="form_data.payment_date_1"
	    		            label="Tanggal Pembayaran"
	    		            readonly
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
			    		</validation-provider>
    		        	</template>
    		        	<v-date-picker name="" v-model="form_data.payment_date_1" @input="menu3 = false"></v-date-picker>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="No invoice" rules="required|numeric">
				    		<v-text-field
				    		 	v-model="form_data.invoice_commission_1"
					    		label="No Rekening"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
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
		    		            counter 
		    		            multiple 
		    		            label="Upload Bukti Pembayaran"
		    		            v-model="form_data.payment_proof_1"
		    		            hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="payment_proof_1">
			              </v-file-input>
			           </validation-provider>
		          </v-col>
			    </v-row>
			    <v-row>
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
			    		<validation-provider v-slot="{ errors }" name="Tanggal Pembayaran" rules="required">
	    		        <v-text-field
	    		        	hint="* harus diisi"
	    		        	:persistent-hint="true"
				    		:error-messages="errors"
	    		            v-model="form_data.payment_date_1"
	    		            label="Tanggal Pembayaran"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		            readonly
	    		        ></v-text-field>
			    		</validation-provider>
    		        	</template>
    		        	<v-date-picker v-model="form_data.payment_date_1" @input="menu4 = false"></v-date-picker>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="No invoice" rules="required|numeric">
				    		<v-text-field
				    		 	v-model="form_data.invoice_commission_2"
					    		label="No Rekening"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
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
		    		            counter 
		    		            multiple 
		    		            label="Upload Bukti Pembayaran"
		    		            v-model="form_data.evidence"
		    		            hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="evidence2">
			              </v-file-input>
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
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Unit"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.closing_fee ? number_format(form_data.closing_fee) : 0 }}</small>
				    </v-col>
			    </v-row>
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
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sales" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.commission_sales"
				    			name="commission_sales"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.commission_sales ? number_format(form_data.commission_sales) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
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
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sub Agent" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.commission_agency"
				    			name="commission_agency"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.commission_agency ? number_format(form_data.commission_agency) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
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
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Korwil" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.commission_korwil"
				    			name="commission_korwil"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.commission_korwil ? number_format(form_data.commission_korwil) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
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
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Koordinator Utama" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.commission_korut"
				    			name="commission_korut"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{form_data.commission_korut ? number_format(form_data.commission_korut) : 0 }}</small>
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
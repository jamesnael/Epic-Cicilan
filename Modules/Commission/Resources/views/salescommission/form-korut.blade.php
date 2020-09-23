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
				    			v-model="form_data.payment_type"
				    			name="payment_type"
					    		:error-messages="errors"
					    		label="Tipe Pembayaran"
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

			    <!-- Pembayaran Komisi Korut -->
			    <h3 class="mt-5">Pembayaran Komisi Koordinator Utama</h3>
    			<v-row class="mt-4">
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			v-model="form_data.korut_name"
				    			name="korut_name"
					    		:error-messages="errors"
					    		label="Nama Korut"
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
				    			v-model="form_data.korut_commission"
				    			name="korut_commission"
					    		label="Komisi Korut (%)"
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
				    			v-model="form_data.korut_pph_final"
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
				    			v-model="form_data.korut_pph_21"
					    		label="PPH 21 (%)"
					    		:persistent-hint="true"
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
				    			v-model="form_data.korut_pph_23"
					    		label="PPH 23 (%)"
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
				    			:value="korut_bruto_commission"
					    		label="Komisi Bruto"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{bruto_commission ? number_format(bruto_commission) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
				
				<div>
				    <h4 class="mt-3">Pencairan Komisi 1</h4>
				    <v-row class="mt-4">
	    		        <v-col
	    		          	cols="12"
	    		          	md="6">
				    		<validation-provider v-slot="{ errors }" name="Pencairan 1 Komisi (50%)" rules="required|numeric">
					    		<v-text-field
					    			v-model="korut_commission_1"
					    			name="korut_commission_1"
						    		:persistent-hint="true"
						    		:error-messages="errors"
						    		label="Pencairan 1 Komisi (50%)"
						    		:readonly="!field_state"
						    		:disabled="field_state">
				    			</v-text-field>
				    			<small class="form-text text-muted">Rp @{{korut_commission_1 ? number_format(korut_commission_1) : 0 }}</small>
				    		</validation-provider>
					    </v-col>
					    <v-col
	    		          	cols="12"
	    		          	md="6">
					    	<v-menu
			    		        v-model="menu11"
			    		        :close-on-content-click="false"
			    		        :nudge-right="40"
			    		        transition="scale-transition"
			    		        offset-y
			    		        min-width="290px"
			    		      >
		    		        	<template v-slot:activator="{ on, attrs }">
					    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
			    		        <v-text-field
			    		        	:value="reformatDateTime(form_data.korut_payment_date_1, 'YYYY-MM-DD', 'DD MMMM YYYY')"
			    		            label="Tanggal Pembayaran"
			    		            readonly
			    		            v-bind="attrs"
			    		            v-on="on"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		        ></v-text-field>
					    		</validation-provider>
		    		        	</template>
		    		        	<v-date-picker name="korut_payment_date_1" v-model="form_data.korut_payment_date_1" @input="menu11 = false">
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
					    		 	v-model="form_data.korut_invoice_commission_1"
					    		 	name="korut_invoice_commission_1"
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
					              	name="korut_payment_proof1"
						    		:persistent-hint="true"
						    		:error-messages="errors"
					              	>
				              </v-file-input>
				              <a :href="form_data.url_korut_payment_proof_one" target="_blank" class="ml-8">
				              	<small>@{{form_data.korut_payment_proof_1}}</small>
				              </a>
				           </validation-provider>
			          </v-col>
				    </v-row>
			    </div>
				
				<div>
				    <h4 class="mt-3">Pencairan Komisi 2</h4>
				    <v-row class="mt-4">
	    		        <v-col
	    		          	cols="12"
	    		          	md="6">
				    		<validation-provider v-slot="{ errors }" name="Pencairan 2 Komisi (50%)" rules="required|numeric">
					    		<v-text-field
					    			v-model="korut_commission_2"
					    			name="korut_commission_2"
						    		:persistent-hint="true"
						    		:error-messages="errors"
						    		label="Pencairan 2 Komisi (50%)"
						    		:readonly="!field_state"
						    		:disabled="field_state">
				    			</v-text-field>
				    			<small class="form-text text-muted">Rp @{{korut_commission_2 ? number_format(korut_commission_2) : 0 }}</small>
				    		</validation-provider>
					    </v-col>
					    <v-col
	    		          	cols="12"
	    		          	md="6">
					    	<v-menu
			    		        v-model="menu12"
			    		        :close-on-content-click="false"
			    		        :nudge-right="40"
			    		        transition="scale-transition"
			    		        offset-y
			    		        min-width="290px"
			    		      >
		    		        	<template v-slot:activator="{ on, attrs }">
					    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran" rules="">
			    		        <v-text-field
			    		        	:value="reformatDateTime(form_data.korut_payment_date_2, 'YYYY-MM-DD', 'DD MMMM YYYY')"
			    		            label="Tanggal Pembayaran"
			    		            readonly
			    		            v-bind="attrs"
			    		            v-on="on"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		        ></v-text-field>
					    		</validation-provider>
		    		        	</template>
		    		        	<v-date-picker name="korut_payment_date_2" v-model="form_data.korut_payment_date_2" @input="menu12 = false">
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
					    		 	v-model="form_data.korut_invoice_commission_2"
						    		label="No Invoice"
						    		name="korut_invoice_commission_2"
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
					              	name="korut_payment_proof2">
				              </v-file-input>
				              <a :href="form_data.url_korut_payment_proof_two" target="_blank" class="ml-8">
				              	<small>@{{form_data.korut_payment_proof_2}}</small>
				              </a>
				           </validation-provider>
			          </v-col>
				    </v-row>
			    </div>
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
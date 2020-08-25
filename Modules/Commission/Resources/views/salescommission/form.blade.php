<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
    			<h3 class="mt-5">Data Penjualan</h3>
	    		<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Klien" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.client_name"
				    			name="client_name"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		label="Nama Klien">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Tipe Rumah" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.home_type"
				    			name="home_type"
					    		label="Tipe Rumah"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		:readonly="field_state"
					    		placeholder>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Blok" rules="required">
				    		<v-text-field
				    			v-model="form_data.blok"
				    			name="blok"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Blok">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="No Blok" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.no_blok"
				    			name="no_blok"
					    		label="No Blok"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state"
					    		placeholder>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Harga Unit + PPN" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.unit_price"
				    			name="unit_price"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Harga Unit + PPN">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
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
	    		        	:value="computedDateFormattedMomentjs"
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
					    		label="Cara Bayar">
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
					    		:readonly="field_state"
					    		placeholder>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
    			<h3 class="mt-5">Pembayaran Komisi Sub Agent</h3>
    			<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Sub Agent" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.sub_agent_name"
				    			name="sub_agent_name"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Sub Agent">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Komisi Agent" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.agent_commission"
				    			name="agent_commission"
					    		label="Komisi Agent"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state"
					    		placeholder>
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
				    			v-model="form_data.pencairan_1_komisi"
				    			name="pencairan_1_komisi"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Pencairan 1 Komisi (50%)">
			    			</v-text-field>
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
	    		        	:value="computedDateFormattedMomentjs"
	    		        	hint="* harus diisi"
	    		        	:persistent-hint="true"
				    		:error-messages="errors"
	    		            v-model="form_data.buy_date"
	    		            label="Tanggal Pembayaran"
	    		            readonly
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
			    		</validation-provider>
    		        	</template>
    		        	<v-date-picker v-model="form_data.buy_date" @input="menu3 = false"></v-date-picker>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          cols="12"
    		          md="12">
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
				              	name="evidence">
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
				    			v-model="form_data.pencairan_2_komisi"
				    			name="pencairan_2_komisi"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Pencairan 2 Komisi (50%)">
			    			</v-text-field>
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
	    		        	:value="computedDateFormattedMomentjs"
	    		        	hint="* harus diisi"
	    		        	:persistent-hint="true"
				    		:error-messages="errors"
	    		            v-model="form_data.buy_date2"
	    		            label="Tanggal Pembayaran"
	    		            readonly
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
			    		</validation-provider>
    		        	</template>
    		        	<v-date-picker v-model="form_data.buy_date2" @input="menu4 = false"></v-date-picker>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          cols="12"
    		          md="12">
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
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Unit" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_unit"
				    			name="closing_fee_unit"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Unit">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sales" rules="required">
				    		<v-text-field
				    			v-model="form_data.closing_fee_sales"
				    			name="closing_fee_sales"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Sales">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sales" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_sales_price"
				    			name="closing_fee_sales_price"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sub Agent" rules="required">
				    		<v-text-field
				    			v-model="form_data.closing_fee_sub_agent"
				    			name="closing_fee_sub_agent"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Sub Agent">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Sub Agent" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_sub_agent_price"
				    			name="closing_fee_sub_agent_price"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Korwil" rules="required">
				    		<v-text-field
				    			v-model="form_data.closing_fee_korwil"
				    			name="closing_fee_korwil"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Korwil">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Korwil" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_korwil_price"
				    			name="closing_fee_korwil_price"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Koordinator Utama" rules="required">
				    		<v-text-field
				    			v-model="form_data.closing_fee_main_koordinator"
				    			name="closing_fee_main_koordinator"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Closing Fee Koordinator Utama">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing Fee Koordinator Utama" rules="required|numeric">
				    		<v-text-field
				    			v-model="form_data.closing_fee_main_koordinator_price"
				    			name="closing_fee_main_koordinator_price"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		placeholder="Rp">
			    			</v-text-field>
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
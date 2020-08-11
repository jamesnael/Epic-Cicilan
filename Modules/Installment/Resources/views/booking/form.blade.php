<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Klien" rules="required">
		    		<v-select
		    			v-model="form_data.client_id" 
		              	:items="filter_client"
		              	label="Klien"
		              	name="client_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Unit" rules="required">
		    		<v-select
		    			v-model="form_data.unit_id" 
		              	:items="filter_unit"
		              	label="Unit"
		              	name="unit_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Total harga" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.total_amount"
		    			name="total_amount"
			    		label="Total Harga"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="PPN" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.ppn"
		    			name="ppn"
			    		label="PPN"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Tipe pembayaran" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.payment_type"
		    			name="payment_type"
			    		label="Tipe Pembayaran"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Metode Pembayaran" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.payment_method"
		    			name="payment_method"
			    		label="Harga Dasar"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Total DP" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.dp_amount"
		    			name="dp_amount"
			    		label="Total DP"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Pembayaran pertama" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.first_payment"
		    			name="first_payment"
			    		label="Pembayaran Pertama"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Principal" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.principal"
		    			name="principal"
			    		label="Principal"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Cicilan" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.installment"
		    			name="installment"
			    		label="Cicilan"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Lama cicilan" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.installment_time"
		    			name="installment_time"
			    		label="Lama Cicilan"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Tanggal jatuh tempo" rules="required|numeric|min:1">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.due_date"
		    			name="due_date"
			    		label="Tanggal Jatuh Tempo"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Kredit" rules="required|numeric|min:1">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.credits"
		    			name="credits"
			    		label="Kredit"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Metode pembayaran UTJ" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.payment_method_utj"
		    			name="payment_method_utj"
			    		label="Metode Pembayaran UTJ"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Total" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.amount"
		    			name="amount"
			    		label="Total"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama bank" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.bank_name"
		    			name="bank_name"
			    		label="Nama Bank"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor rekening" rules="required|numeric">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.card_number"
		    			name="card_number"
			    		label="Nomor Rekening"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Point" rules="required|numeric">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.point"
		    			name="point"
			    		label="Point"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
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
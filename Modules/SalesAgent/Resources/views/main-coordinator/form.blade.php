<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Nama koordinator utama" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.full_name"
		    			name="full_name"
			    		label="Nama Koordinator Utama"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Email" rules="required|email">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.email"
		    			name="email"
			    		label="Email"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor telepon" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.phone_number"
		    			name="phone_number"
			    		label="Nomor Telepon"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama Principal" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.principal"
		    			name="principal"
			    		label="Nama Principal"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor handphone principal" rules="required|max:15">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.no_hp_principal"
		    			name="no_hp_principal"
			    		label="Nomor Handphone Principal"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		placeholder="+62"
			    		:counter="15"
			    		v-mask="'+62############'"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Alamat" rules="max:255">
		    		<v-textarea
		    			class="mt-4"
		    			v-model="form_data.address"
		    			name="address"
			    		label="Alamat"
			    		auto-grow
		    			clearable
		    			rows="1"
				      	clear-icon="mdi-close"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-textarea>
	    		</validation-provider>
	    		<bank-input inline-template
	    			:bank-value="form_data.bank_name"
	    			bank-class="mt-4"
	    			bank-input-name="bank_name"
	    			bank-label="Nama Bank"
	    			:disabled="field_state"
	    		>
	    			@include('core::bank')
	    		</bank-input>
	    		<validation-provider v-slot="{ errors }" name="Nomor rekening" rules="numeric">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.rek_number"
		    			name="rek_number"
			    		label="Nomor Rekening"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama akun" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.account_name"
		    			name="account_name"
			    		label="Nama Pemilik Akun"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="PPN" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.ppn"
		    			name="pph_final"
			    		label="PPN"
			    		:error-messages="errors"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="PPH 21" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.pph_21"
		    			name="pph_final"
			    		label="PPH 21"
			    		:error-messages="errors"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="PPH 23" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.pph_23"
		    			name="pph_final"
			    		label="PPH 23"
			    		:error-messages="errors"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="PPH Komisi Final" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.pph_final"
		    			name="pph_final"
			    		label="PPH Komisi Final"
			    		:error-messages="errors"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
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
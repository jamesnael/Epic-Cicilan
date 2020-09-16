<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Nama klien" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.client_name"
		    			name="client_name"
			    		label="Nama Klien"
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
		    			v-model="form_data.client_email"
		    			name="client_email"
			    		label="Email"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		{{-- <validation-provider v-slot="{ errors }" name="Pekerjaan" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.profession"
		    			name="profession"
			    		label="Pekerjaan"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider> --}}
	    		<occupation-input inline-template
	    			occupation-rules="required"
	    			:occupation-value="form_data.profession"
	    			occupation-class="mt-4"
	    			occupation-input-name="profession"
	    			occupation-label="Pekerjaan"
	    			:disabled="field_state"
	    		>
	    			@include('core::occupation')
	    		</occupation-input>
	    		<validation-provider v-slot="{ errors }" name="Nomor handphone" rules="required|min:10|max:15">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.client_mobile_number"
		    			name="client_mobile_number"
			    		label="Nomor Handphone"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		placeholder="+62"
			    		:counter="15"
			    		v-mask="'+62############'"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor telepon" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.client_phone_number"
		    			name="client_phone_number"
			    		label="Nomor Telepon"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Alamat Surat Menyurat" rules="max:255">
		    		<v-textarea
		    			class="mt-4"
		    			v-model="form_data.client_address"
		    			name="client_address"
			    		label="Alamat Surat Menyurat"
			    		auto-grow
		    			clearable
		    			rows="1"
				      	clear-icon="mdi-close"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-textarea>
	    		</validation-provider>
	    		<address-input inline-template
	    			:province-value="form_data.province"
	    			province-class="mt-4"
	    			province-input-name="province"
	    			province-label="Provinsi"
	    			:city-value="form_data.city"
	    			city-class="mt-4"
	    			city-input-name="city"
	    			city-label="Kota"
	    			:disabled="field_state"
	    		>
	    			@include('core::address')
	    		</address-input>
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
<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		{{-- <validation-provider v-slot="{ errors }" name="Komisi sales" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.sales_commission"
		    			name="sales_commission"
			    		label="Komisi Sales"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state"
			    		placeholder>
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider> --}}
	    		<validation-provider v-slot="{ errors }" name="Komisi sub agent" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.agency_commission"
		    			name="agency_commission"
			    		label="Komisi Sub Agent"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Komisi koordinator wilayah" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.regional_coordinator_commission"
		    			name="regional_coordinator_commission"
			    		label="Komisi Koordinator Wilayah"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Komisi koordinator utama" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.main_coordinator_commission"
		    			name="main_coordinator_commission"
			    		label="Komisi Koordinator Utama"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Total komisi tidak boleh melebihi 100%" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
			    		label="Total"
			    		name="total"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		readonly
		    			:value="total">
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
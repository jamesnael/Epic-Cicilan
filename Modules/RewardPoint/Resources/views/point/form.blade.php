<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Tipe bangunan" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.building_type"
		    			name="building_type"
			    		label="Tipe Bangunan"
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
<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Cluster</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		</v-row>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Nama Cluster" rules="required">
				    		<v-text-field
				    			v-model="form_data.cluster_name"
				    			name="cluster_name"
					    		label="Nama Cluster"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		>
			    			</v-text-field>

			    		</validation-provider>
			    		</v-col>
			    </v-row>


			  	<v-btn
		    		class="mt-4 mr-4 white--text"
		    		type="submit"
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
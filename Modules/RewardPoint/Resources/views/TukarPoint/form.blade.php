<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Tukar Point</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		</v-row>
	    		<v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="">
				    		<v-select
			    			v-model="form_data.sales_name" 
			    			label="Nama Sales"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>
			    		</validation-provider>
			    	</v-col>
			    </v-row>
			    
			  	<v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Sub Agent" rules="">
				    		<v-text-field
			    			v-model="form_data.sub_agent"
			              	label="Sub Agent"
			              	name="sub_agent"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>


			  	<v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Koordinator Wilayah" rules="">
				    		<v-text-field
			    			v-model="form_data.koordinator_wilayah"
			              	label="Koordinator Wilayah"
			              	name="koordinator_wilayah"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>
			    
			    
			  	<v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Koordinator Utama" rules="">
				    		<v-text-field
			    			v-model="form_data.koordinator_utama"
			              	label="Koordinator Utama"
			              	name="koordinator_utama"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>
			    
			    <h3 class="mt-4">Tukar Point</h3>

			    
			  	<v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Total Point" rules="">
				    		<v-text-field
			    			v-model="form_data.total_point"
			              	label="Total Point"
			              	name="total_point"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Sisa Point" rules="">
				    		<v-text-field
			    			v-model="form_data.sisa_point"
			              	label="Sisa Point"
			              	name="sisa_point"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Kategori Reward" rules="">
				    		<v-select
			    			v-model="form_data.reward_category" 
			    			label="Kategori Reward"
			    			name="reward_category"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Nama Reward Point" rules="">
				    		<v-select
			    			v-model="form_data.nama_reward_point" 
			    			label="Nama Reward Point"
			    			name="nama_reward_point"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Redeem Point" rules="">
				    		<v-text-field
			    			v-model="form_data.reedem_point" 
			    			label="Redeem Point"
			    			name="redeem_point"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>


			    
	    	

	            <v-btn
		      		class="mt-4"
		      		outlined 
		      		:disabled="field_state">
    		      	Kembali
    		    </v-btn>
	    		 <v-dialog v-model="dialog" persistent max-width="290">
				      <template v-slot:activator="{ on, attrs }">
				        <v-btn
				          color="primary"
				          dark
				          v-bind="attrs"
				          v-on="on"
				          class="mt-4"
				        >
				          Tukar
				        </v-btn>
				      </template>
						      <v-card>
						        <v-card-title class="headline">KONFIRMASI</v-card-title>
						        <v-card-text>Point berhasil ditukarkan, Ingin menukar point lagi ?</v-card-text>
						        <v-card-actions>
						          <v-spacer></v-spacer>
						          <v-btn color="blue darken-1" text @click="dialog = false">Tidak</v-btn>
						          <v-btn color="blue darken-1" text @click="dialog = false">Iya</v-btn>
						        </v-card-actions>
						      </v-card>
			    </v-dialog>
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
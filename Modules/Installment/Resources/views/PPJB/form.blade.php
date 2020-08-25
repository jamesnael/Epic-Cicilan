<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Schedule PPJB</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		</v-row>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Klien" rules="required">
				    		<v-text-field
				    			v-model="form_data.client_name"
				    			name="client_name"
					    		hint="* harus diisi"
					    		label="Nama Klien"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
			    		</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nomor Handphone" rules="required">
				    		<v-text-field
				    			v-model="form_data.phone_number"
				    			name="phone_number"
					    		label="Nomor Handphone"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Unit" rules="required">
				    		<v-text-field
				    			v-model="form_data.unit"
				    			name="Unit"
					    		label="Unit"
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
			    		<validation-provider v-slot="{ errors }" name="Harga Unit" rules="required">
				    		<v-text-field
				    			v-model="form_data.unit_price"
				    			name="unit_price"
					    		label="Harga Unit"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="20">
			    		<validation-provider v-slot="{ errors }" name="Tanggal Pengajuan" rules="required">
				    			<v-menu
	    		        v-model="menu2"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
	    		        <v-text-field
	    		        	:value="computedDateFormattedMomentjs"
	    		            v-model="form_data.submission_date"
	    		            label="Tanggal Pengajuan"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.submission_date" @input="menu2 = false"></v-date-picker>
    		      	</v-menu>
			    		</validation-provider>
			    	</v-col>
			    </v-row>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="required">
				    		<v-select
			    			v-model="form_data.sales_name" 
			    			@input="setSelectedClient()"
			              	:items="filter_client"
			              	label="Nama Sales"
			              	name="sales_name"
			              	hint="* harus diisi"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Agent" rules="required">
				    		<v-text-field
				    			v-model="form_data.agent_name"
				    			name="agent_name"
				    			hint="* harus diisi"
					    		label="Nama Agent"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				    <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Upload Surat PPJB" rules="required">
				    		<v-file-input
				    			v-model="form_data.surat_ppjb_awal"
				    			name="surat_ppjb"
				    			hint="* harus diisi"
					    		label="Surat PPJB awal"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-file-input>
			    		</validation-provider>
			    	</v-col>

			    </v-row>

			    <h3 class="mt-4">Schedule PPJB</h3>
	    		
	    		<validation-provider v-slot="{ errors }" name="Tanggal PPJB" rules="required">
		    		<v-menu
	    		        v-model="menu3"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
	    		        <v-text-field
	    		        	:value="computedDateFormattedMomentjs"
	    		            v-model="form_data.ppjb_date"
	    		            label="Tanggal PPJB"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.ppjb_date" @input="menu3 = false"></v-date-picker>
    		      	</v-menu>
				</validation-provider>

	    		<v-row>
    		        <v-col>
			    		<validation-provider v-slot="{ errors }" name="Waktu" rules="required">
				    		<v-menu
					        ref="menu"
					        v-model="menu4"
					        :close-on-content-click="false"
					        :nudge-right="40"
					        :return-value.sync="time"
					        transition="scale-transition"
					        offset-y
					        max-width="290px"
					        min-width="290px"
					      >
					        <template v-slot:activator="{ on, attrs }">
					          <v-text-field
					            v-model="time"
					            label="Waktu"
					            hint="* harus diisi"
					            :persistent-hint="true"
					    		:error-messages="errors"
					            readonly
					            v-bind="attrs"
					            v-on="on"
					          ></v-text-field>
					        </template>
					        <v-time-picker
					          v-if="menu4"
					          v-model="time"
					          full-width
					          @click:minute="$refs.menu.save(time)"
					        ></v-time-picker>
					      </v-menu>
			    		</validation-provider>
			    	</v-col>
			    </v-row>


			    <v-row>
			    	<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Tempat" rules="required">
				    		<v-text-field
				    			v-model="form_data.ppjb_place"
				    			name="ppjb_place"
					    		label="Tempat"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>
		    	<v-row>
		    		<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Alamat Lengkap" rules="required">
			    			 <v-textarea
						      v-model="form_data.full_address"
				    			name="full_address"
					    		label="Alamat Lengkap"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
						    ></v-textarea>
			    		</validation-provider>
			    	</v-col>	
		    	</v-row>
		    	 <h3 class="mt-4">Approved PPJB</h3>
		    		
		    		<v-col
    		          	cols="12"
    		          	md="12">	
		    		<validation-provider v-slot="{ errors }" name="Approved Pembeli" rules="required">
		    			<v-select
			    			v-model="form_data.approved_pembeli" 
			              	:items="['Pending','Approved']"
			              	label="Approved Pembeli"
			              	name="approved_pembeli"
			              	hint="* harus diisi"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>

					</validation-provider>
			    	</v-col>

			    	<v-col
    		          	cols="12"
    		          	md="12">	
		    		<validation-provider v-slot="{ errors }" name="Approved Developer" rules="required">
		    			<v-select
			    			v-model="form_data.approved_developer" 
			              	:items="['Pending','Approved']"
			              	label="Approved Developer"
			              	name="approved_developer"
			              	hint="* harus diisi"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>

					</validation-provider>
			    	</v-col>

					<v-col
    		          	cols="12"
    		          	md="12">	
		    		<validation-provider v-slot="{ errors }" name="Approved Notaris" rules="required">
		    			<v-select
			    			v-model="form_data.approved_notaris" 
			              	:items="['Pending','Approved']"
			              	label="Approved Notaris"
			              	name="approved_notaris"
			              	hint="* harus diisi"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>

					</validation-provider>
			    	</v-col>

			    <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Upload Surat PPJB" rules="required">
				    		<v-file-input
				    			v-model="form_data.surat_ppjb"
				    			name="surat_ppjb"
					    		label="Upload Surat PPJB"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-file-input>
			    		</validation-provider>
			    	</v-col>



			    
	            <v-btn
		      		class="mt-4"
		      		outlined 
		      		:disabled="field_state">
    		      	Kembali
    		    </v-btn>
	    		<v-btn
		    		class="mt-4 mr-4 white--text"
		    		color="primary"
	    		    elevation="5"
		    		:disabled="field_state"
		    		:loading="field_state"
		    		@click="updateInstallment">
		    		Save
	    		    <template v-slot:loader>
    		            <span class="custom-loader">
    		              	<v-icon color="white">mdi-sync</v-icon>
    		            </span>
    		        </template>
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
<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Jadwal PPJB</h3>
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
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Unit" rules="">
				    		<v-text-field
				    			v-model="form_data.unit_type"
				    			name="unit_type"
					    		label="Unit"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		readonly>
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
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{number_format(form_data.unit_price)}}</small>
			    		</validation-provider>
				    </v-col>
			    </v-row>
				<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="12">
			    
    		          	<validation-provider v-slot="{ errors }" name="Tanggal Pengajuan" rules="required">
				    		<v-text-field
				    			:value="reformatDateTime(form_data.ppjb_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
				    			name="ppjb_date"
					    		label="Tanggal Pengajuan"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				

			    	</v-col>
			    </v-row>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="required">
				    		<v-text-field
			    			v-model="form_data.sales_name"
			              	:items="filter_client"
			              	label="Nama Sales"
			              	name="sales_name"
			              	:persistent-hint="true"
				    		:error-messages="errors"
				    		readonly
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Sub Agent" rules="">
				    		<v-text-field
				    			v-model="form_data.agent_name"
				    			name="agent_name"
				    			label="Nama Sub Agent"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>


			    <h3 class="mt-4">Jadwal PPJB</h3>
	    		
	    		<validation-provider v-slot="{ errors }" name="" rules="">
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
	    		        	class="mt-4"
	    		        	:value="reformatDateTime(form_data.ppjb_sign_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
	    		            label="Tanggal PPJB"
	    		            readonly
	    		            v-bind="attrs"
	    		            v-on="on"
	    		            :persistent-hint="true"
	    		            :error-messages="errors"
	    		            :readonly="!field_state"
	    		            :disabled="field_state">
	    		        </v-text-field>
    		        	</template>
    		        	<v-date-picker name="ppjb_sign_date" v-model="form_data.ppjb_sign_date" @input="menu3 = false" :disabled="field_state"></v-date-picker>
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
					            v-model="form_data.ppjb_time"
					            name="ppjb_time"
					            label="Waktu"
					            :persistent-hint="true"
					    		:error-messages="errors"
					            readonly
					            v-bind="attrs"
					            v-on="on"
					          ></v-text-field>
					        </template>
					        <v-time-picker
					          v-if="menu4"
					          v-model="form_data.ppjb_time"
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
				    			v-model="form_data.location"
				    			name="location"
					    		label="Tempat"
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
			    			 	clearable
						      v-model="form_data.address"
				    			name="address"
					    		label="Alamat Lengkap"
					    		auto-grow
					    		clearable
					    		clear-icon="mdi-close"
					    		rows="1"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
						    ></v-textarea>
			    		</validation-provider>
			    	</v-col>	
			    	<v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Upload Surat PPJB Awal" rules="">
				    		<v-file-input
				    			name="file_upload"
				    			label="Surat PPJB awal"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		>
			    			</v-file-input>
			    			<a :href="form_data.url_file_doc" target="_blank" class="ml-8">
		    		  	<small>@{{form_data.ppjb_doc_file_name}}</small>
		    		  </a>
			    		</validation-provider>
			    	</v-col>

		    	</v-row>

		    	 <h3 class="mt-4"
		    	 v-if="form_data.ppjb_sign_date_data !== ''"
		    	 >Approval PPJB</h3>

		    		
		    		<v-col
    		          	cols="12"
    		          	md="12">	
		    		<validation-provider v-slot="{ errors }" name="Approval Pembeli" rules="">
		    			<v-select
			    			v-model="form_data.approval_client_status" 
			              	:items="['Disetujui','Pending']"	
			              	label="Approval Pembeli"
			              	name="approval_client_status"
			              	v-if="form_data.ppjb_sign_date_data !== ''"
			              	:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>

					</validation-provider>
			    	</v-col>

			    	<v-col
    		          	cols="12"
    		          	md="12">	
		    		<validation-provider v-slot="{ errors }" name="Approval Developer" rules="">
		    			<v-select
			    			v-model="form_data.approval_developer_status" 
			              	:items="['Disetujui','Pending']"
			              	label="Approval Developer"
			              	name="approval_developer_status"
			              	v-if="form_data.ppjb_sign_date_data !== ''"
			              	:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>

					</validation-provider>
			    	</v-col>

					<v-col
    		          	cols="12"
    		          	md="12">	
		    		<validation-provider v-slot="{ errors }" name="Approval Notaris" rules="">
		    			<v-select
			    			v-model="form_data.approval_notaris_status" 
			              	:items="['Disetujui','Pending']"
			              	label="Approval Notaris"
			              	name="approval_notaris_status"
			              	v-if="form_data.ppjb_sign_date_data !== ''"
			              	:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>

					</validation-provider>
			    	</v-col>

			    <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Upload Surat PPJB" rules="">
				    		<v-file-input
				    			name="sign_upload"
					    		label="Upload Surat PPJB"
					    		v-if="form_data.ppjb_sign_date_data !== ''"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		>
			    			</v-file-input>
			    			<a :href="form_data.url_file_doc_sign" target="_blank" class="ml-8">
		    		  	<small>@{{form_data.ppjb_doc_sign_file_name}}</small>
		    		  </a>
			    		</validation-provider>
			    	</v-col>



			    
	            <v-btn
		      		class="mt-4"
		      		outlined 
		      		:disabled="field_state"
		      		:href="redirectUri">
    		      	Kembali
    		    </v-btn>
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


		    	<v-dialog v-model="dialog" persistent max-width="600px">
		    		<form method="post" id="formCancel" enctype="multipart/form-data" ref="put-form">
		    	      <template v-slot:activator="{ on, attrs }">
		    	        <v-btn
			    	      class="mt-4 mr-4"
		    	          color="red"
		    	          dark
		    	          v-bind="attrs"
		    	          v-on="on"
		    	        >
		    	          Pembatalan Pembelian Unit
		    	        </v-btn>
		    	      </template>
		    	      <v-card>
		    	        <v-card-title>
		    	          <span class="headline">Pembatalan Pembelian Unit</span>
		    	        </v-card-title>
		    	        <v-divider></v-divider>
		    	        <v-card-text>
		    	          <v-container>
		    	            <v-row>
		    	              <v-col cols="12">
		    	              	<validation-provider v-slot="{ errors }" name="Alasan pembatalan" rules="">
		    	                	<v-textarea
		    	                		v-model="cancel_reason" 
		    	                		label="Alasan Pembatalan*" 
		    	                		name="cancel_reason"
    					                hint="* harus diisi"
    					                :persistent-hint="true"
    					                :error-messages="errors"
    					                :readonly="field_state"
    					                required>
	    	                		</v-textarea>
		    	                </validation-provider>
		    	              </v-col>
		    	            </v-row>
		    	          </v-container>
		    	        </v-card-text>
		    	        <v-card-actions>
		    	          <v-spacer></v-spacer>
		    	          <v-btn outlined color="primary" elevetion="2" text @click="dialog = false">Close</v-btn>
		    	          <v-btn 
		    	          	class="white--text"
		    	          	color="green" 
		    	          	@click="cancelPpjb()"
		    	          >
		    	          	Save
		    	      	</v-btn>

		    	        </v-card-actions>
		    	      </v-card>
		    		</form>
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
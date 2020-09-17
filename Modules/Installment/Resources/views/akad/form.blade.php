<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Schedule Proses Akad KPR</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Klien" rules="">
				    		<v-text-field
				    			v-model="form_data.client_name"
				    			name="client_name"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		label="Nama Klien"
					    		:readonly="!field_state"
					    		:disabled="field_state">
					    	>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nomor Handphone" rules="">
				    		<v-text-field
				    			v-model="form_data.client_mobile_number"
				    			name="client_mobile_number"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nomor Handphone"
					    		:readonly="!field_state"
					    		:disabled="field_state">
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
				    			v-model="form_data.unit_number"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Unit"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Harga Unit" rules="">
				    		<v-text-field
				    			v-model="form_data.unit_price"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Harga Unit"
					    		:readonly="!field_state"
					    		:disabled="field_state">
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
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Sales"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Sub Agent" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_name"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Sub Agent"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
	        		<validation-provider v-slot="{ errors }" name="Tanggal PPJB" rules="">
	    	    		<v-text-field
	    	    			:value="reformatDateTime(form_data.ppjb_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
	    	    			:persistent-hint="true"
	    		    		:error-messages="errors"
	    		    		label="Tanggal PPJB"
	    		    		:readonly="!field_state"
	    		    		:disabled="field_state">
	        			</v-text-field>
	        		</validation-provider>
				</v-row>

				<h3 class="mt-4">Schedule Akad KPR</h3>
	    		<v-row>
	    			<v-col
    		          	cols="12"
    		          	md="12">
				    		<v-menu
		    		        v-model="menu2"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal Akad KPR" rules="required|min:1">
			    		        <v-text-field
			    		        	:value="reformatDateTime(form_data.akad_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
			    		        	hint="* harus diisi"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		            label="Tanggal Akad KPR"
			    		            readonly
			    		            v-bind="attrs"
			    		            v-on="on"
			    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker v-model="form_data.akad_date" @input="menu2 = false"></v-date-picker>
	    		      	</v-menu>
			    	</v-col>
	    		</v-row>
	    		<v-row>
    		        <v-col
    		          cols="12"
    		          md="6">
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
				    		<validation-provider v-slot="{ errors }" name="Waktu" rules="required|max:255">
					          <v-text-field
					            v-model="form_data.akad_time"
					            label="Waktu"
					            hint="* harus diisi"
					            :persistent-hint="true"
					    		:error-messages="errors"
					            readonly
					            v-bind="attrs"
					            v-on="on"
					          ></v-text-field>
				    		</validation-provider>
					        </template>
					        <v-time-picker
					          v-if="menu4"
					          v-model="form_data.akad_time"
					          full-width
					          @click:minute="$refs.menu.save(form_data.akad_time)"
					        ></v-time-picker>
					      </v-menu>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Tempat" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.location"
				    			name="location"
					    		label="Tempat"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:error-messages="errors"
					    		:persistent-hint="true"
					    		:readonly="field_state"
					    		>
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
			    	<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Alamat" rules="required">
				    		<v-textarea
				    			auto-grow
				    			clearable
				    			rows="1"
						      	clear-icon="mdi-close"
				    			v-model="form_data.address"
				    			name="address"
					    		label="Alamat Lengkap"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state"
					    	>
			    			</v-textarea>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>
		    	
				<v-row>
					<v-col
    		          cols="12"
    		          md="12">
					    <h3 class="mt-4">Upload Dokumen Awal</h3>
			    		<validation-provider v-slot="{ errors }" name="Dokumen Awal" rules="">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            v-model="form_data.dokumen_awal"
				              	name="dokumen_awal"
		    		            label="Pilih Dokumen"
					    		:error-messages="errors"
				            >
			              	</v-file-input>
			              	<a :href="form_data.url_dokumen_awal" target="_blank" class="ml-8">
			              		<small>@{{form_data.dokumen_awal_akad}}</small>
			              	</a>
			            </validation-provider>
		          </v-col>
		        </v-row>
				
				<div v-if="form_data.url_dokumen_awal">
					<v-row>
						<v-col
	    		          cols="12"
	    		          md="12">
						    <h3 class="mt-4">Approval Akad</h3>
				    		<validation-provider v-slot="{ errors }" name="Approval Pembeli" rules="">
								<v-select
						        v-model="form_data.approval_client_status"
						        :items="['Pending', 'Approved']"
					    		:persistent-hint="true"
					    		:error-messages="errors"
						        label="Approval Pembeli"
						        name="approval_client_status"
						      ></v-select>
							</validation-provider>
			          </v-col>
					</v-row>
					<v-row>
						<v-col
	    		          cols="12"
	    		          md="12">
				    		<validation-provider v-slot="{ errors }" name="Approval Bank" rules="">
		    		          	<v-select
						        v-model="form_data.approval_notaris_status"
						        :items="['Pending', 'Approved']"
					    		:persistent-hint="true"
					    		:error-messages="errors"
						        label="Approval Bank"
						        name="approval_notaris_status"
						      ></v-select>
						    </validation-provider>
	    		        </v-col>
	    		    </v-row>
	    		    <v-row>
						<v-col
	    		          cols="12"
	    		          md="12">
				    		<validation-provider v-slot="{ errors }" name="Approval Developer" rules="">
		    		          	<v-select
						        v-model="form_data.approval_developer_status"
						        :items="['Pending', 'Approved']"
					    		:persistent-hint="true"
					    		:error-messages="errors"
						        label="Approval Developer"
						        name="approval_developer_status"
						      ></v-select>
						   	</validation-provider>
	    		        </v-col>
	    		    </v-row>
	    		    <v-row>
						<v-col
	    		          cols="12"
	    		          md="12">
				    		<validation-provider v-slot="{ errors }" name="Dokumen akhir" rules="">
								<v-file-input 
			    		            show-size
			    		            chips 
			    		            counter 
			    		            label="Dokumen Yang Sudah Ditandatangani"
			    		            v-model="form_data.dokumen_akhir"
						    		:persistent-hint="true"
						    		:error-messages="errors"
					              	name="dokumen_akhir">
				              </v-file-input>
				              <a :href="form_data.url_dokumen_akhir" target="_blank" class="ml-8">
				              	<small>@{{form_data.dokumen_akhir_akad}}</small>
				              </a>
				            </validation-provider>
			          </v-col>
					</v-row>
					<validation-provider v-slot="{ errors }" name="Jumlah KPR" rules="required|numeric">
			    		<v-text-field
			    			class="mt-4"
			    			v-model="form_data.total_kpr"
			    			name="total_kpr"
				    		label="Jumlah KPR"
				    		hint="* harus diisi"
				    		:error-messages="errors"
				    		:persistent-hint="true"
				    		:readonly="field_state"
				    		>
		    			</v-text-field>
		    			<small class="form-text text-muted">Rp @{{ form_data.total_kpr ? number_format(form_data.total_kpr) : 0 }}</small>
		    		</validation-provider>
				</div>

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
		    	          	@click="cancelAkad()"
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
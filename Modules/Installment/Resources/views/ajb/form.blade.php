<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Schedule AJB</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		</v-row>
	    		<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Klien" rules="">
				    		<v-text-field
				    			v-model="form_data.client_name"
				    			name="client_name"
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
			    		<validation-provider v-slot="{ errors }" name="Nama Agensi" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_name"
					    		:error-messages="errors"
					    		label="Nama Agensi"
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
			    		<validation-provider v-slot="{ errors }" name="Nama Korwil" rules="required">
				    		<v-text-field
				    			v-model="form_data.korwil"
					    		:error-messages="errors"
					    		label="Nama Korwil"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Koordinator Utama" rules="">
				    		<v-text-field
				    			v-model="form_data.korut"
					    		:error-messages="errors"
					    		label="Nama Koordinator Utama"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <h3 class="mt-4">Schedule AJB</h3>
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
				    		<validation-provider v-slot="{ errors }" name="Tanggal AJB" rules="required|min:1">
			    		        <v-text-field
			    		        	:value="reformatDateTime(form_data.ajb_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
			    		        	hint="* harus diisi"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		            label="Tanggal AJB"
			    		            readonly
			    		            v-bind="attrs"
			    		            v-on="on"
			    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker v-model="form_data.ajb_date" @input="menu2 = false"></v-date-picker>
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
					            v-model="form_data.ajb_time"
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
					          v-model="form_data.ajb_time"
					          full-width
					          @click:minute="$refs.menu.save(form_data.ajb_time)"
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
		    		            counter 
		    		            label="Pilih Dokumen"
		    		            v-model="form_data.dokumen_awal"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="dokumen_awal">
			              </v-file-input>
			              <a :href="form_data.url_dokumen_awal" target="_blank" class="ml-8">
			              	<small>@{{form_data.dokumen_awal_akad}}</small>
			              </a>
			            </validation-provider>
		          </v-col>
				</v-row>

				<v-row>
					<v-col
    		          cols="12"
    		          md="12">
					    <h3 class="mt-4">Approved AJB</h3>
			    		<validation-provider v-slot="{ errors }" name="Approval Pembeli" rules="">
							<v-select
					        v-model="form_data.approval_client_status"
					        :items="items_approval"
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
					        :items="items_approval"
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
					        :items="items_approval"
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
			              	<small>@{{form_data.dokumen_akhir_ajb}}</small>
			              </a>
			            </validation-provider>
		          </v-col>
				</v-row>

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
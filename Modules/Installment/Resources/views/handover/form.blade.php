<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Jadwal Serah Terima Unit</h3>
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
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Klien"
					    		readonly>
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
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Email" rules="">
				    		<v-text-field
				    			v-model="form_data.client_email"
				    			name="client_email"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Email"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Data Unit" rules="">
				    		<v-text-field
				    			v-model="form_data.unit_type"
				    			name="unit_type"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Data Unit"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Harga Unit" rules="">
				    		<v-text-field
				    			v-model="form_data.total_amount"
				    			name="unit_price"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Harga Unit"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Cara Bayar" rules="">
				    		<v-text-field
				    			v-model="form_data.payment_method"
				    			name="payment_method"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Cara Bayar"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
		    			<v-menu
	    		        v-model="menu6"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
			    		<validation-provider v-slot="{ errors }" name="Tanggal Lunas Cicilan" rules="min:1">
	    		        <v-text-field
	    		        	:value="reformatDateTime(form_data.payment_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
	    		        	:persistent-hint="true"
				    		:error-messages="errors"
	    		            label="Tanggal Lunas Cicilan"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		            readonly
	    		            disabled
	    		        ></v-text-field>
			    		</validation-provider>
    		        	</template>
    		        	<v-date-picker name="payment_date" v-model="form_data.payment_date" @input="menu6 = false"></v-date-picker>
			    	</v-col>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    			<v-menu
		    		        v-model="menu5"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal AJB" rules="min:1">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.ajb_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		            label="Tanggal AJB"
		    		            v-bind="attrs"
		    		            v-on="on"
		    		            readonly
		    		            disabled
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="ajb_date" v-model="form_data.ajb_date" @input="menu5 = false"></v-date-picker>
			    	</v-col>
			    </v-row>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_name"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Sales"
					    		readonly>
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
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Korwil" rules="">
				    		<v-text-field
				    			v-model="form_data.regional_coordinator"
				    			name="regional_coordinator"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Korwil"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Koordinator Utama" rules="">
				    		<v-text-field
				    			v-model="form_data.main_coordinator"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Koordinator Utama"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <h3 class="mt-4">Set Jadwal Serah Terima Unit</h3>
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
				    		<validation-provider v-slot="{ errors }" name="Tanggal Serah Terima Unit" rules="required|min:1">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.handover_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		        	hint="* harus diisi"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		            label="Tanggal Serah Terima Unit"
		    		            v-bind="attrs"
		    		            v-on="on"
		    		            readonly
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="handover_date" v-model="form_data.handover_date" @input="menu2 = false"></v-date-picker>
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
					            v-model="time"
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
					          v-model="time"
					          full-width
					          @click:minute="setTime(time)"
					        ></v-time-picker>
					      </v-menu>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Lokasi" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.location"
				    			name="location"
					    		label="Lokasi"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:persistent-hint="true"
					    		:error-messages="errors"
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
				    			v-model="form_data.address"
				    			name="address"
					    		label="Alamat Lengkap"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    	>
			    			</v-textarea>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>
				<v-row>
					<v-col
    		          cols="12"
    		          md="12">
					    <h3 class="mt-4">Upload Surat Serah Terima Unit Awal</h3>
			    		<validation-provider v-slot="{ errors }" name="Dokumen Awal" rules="">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            counter 
		    		            multiple 
		    		            label="Pilih Dokumen"
		    		            v-model="form_data.handover_doc_file_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="file_upload">
			              </v-file-input>
			              <a :href="form_data.file_upload" target="_blank" class="ml-8" v-if="form_data.file_upload">
			              	<small>@{{form_data.handover_doc_file_name}}</small>
			              </a>

			           </validation-provider>
		          </v-col>
				</v-row>            
			    <h3 class="mt-4" v-if="form_data.handover_doc_file_name_data != null">Approval Serah Terima Unit</h3>
				<v-row v-if="form_data.handover_doc_file_name_data != null">
					<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Approval Pembeli" rules="">
					      <v-select
					        v-model="form_data.approval_client_status"
			                label="Approval Pembeli"
			                :items="['Disetujui', 'Pending']"
			                name="approval_client_status"
			                :persistent-hint="true"
			                :error-messages="errors"
			                :readonly="field_state">
					      ></v-select>
					</validation-provider>
		          </v-col>
				</v-row>
    		    <v-row v-if="form_data.handover_doc_file_name_data != null">
					<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Approval Estate" rules="">
	    		          	<v-select
					        v-model="form_data.approval_developer_status"
			                label="Approval Estate"
			                :items="['Disetujui', 'Pending']"
			                name="approval_developer_status"
			                :persistent-hint="true"
			                :error-messages="errors"
			                :readonly="field_state">
					      ></v-select>
					   </validation-provider>
    		        </v-col>
    		    </v-row>
				<v-row v-if="form_data.handover_doc_file_name_data != null">
					<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Approval Teknik" rules="">
	    		          	<v-select
					        v-model="form_data.approval_notaris_status"
			                label="Approval Teknik"
			                :items="['Disetujui', 'Pending']"
			                name="approval_notaris_status"
			                :persistent-hint="true"
			                :error-messages="errors"
			                :readonly="field_state">
					      ></v-select>
					    </validation-provider>
    		        </v-col>
    		    </v-row>
    		    <v-row v-if="form_data.handover_doc_file_name_data != null">
					<v-col
    		          cols="12"
    		          md="12">
    		          	<validation-provider v-slot="{ errors }" name="Nomor BAST" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.no_bast"
				    			name="no_bast"
					    		label="Nomor BAST"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:persistent-hint="true"
					    		:error-messages="errors"
							>
			    			</v-text-field>
			    		</validation-provider>
    		        </v-col>
    		    </v-row>
    		    <v-row v-if="form_data.handover_doc_file_name_data != null">
    		    	<v-col
    		          	cols="12"
    		          	md="12">
			    		<v-menu
		    		        v-model="menu7"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		    >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal Invitation BAST" rules="required|min:1">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.bast_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		        	hint="* harus diisi"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		            label="Tanggal Invitation BAST"
		    		            v-bind="attrs"
		    		            v-on="on"
		    		            readonly
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="bast_date" v-model="form_data.bast_date" @input="menu7 = false"></v-date-picker>
	    		      	</v-menu>
			    	</v-col>
    		    </v-row>
    		    <v-row v-if="form_data.handover_doc_file_name_data != null">
					<v-col
    		          cols="12"
    		          md="12">
    		          	<validation-provider v-slot="{ errors }" name="Nama Petugas" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.nama_petugas"
				    			name="nama_petugas"
					    		label="Nama Petugas"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:persistent-hint="true"
					    		:error-messages="errors"
							>
			    			</v-text-field>
			    		</validation-provider>
    		        </v-col>
    		    </v-row>
    		    <v-row v-if="form_data.handover_doc_file_name_data != null">
    		    	<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Upload Surat Serah Terima Unit yang telah ditandatangani" rules="">
			              	<v-file-input 
		    		            show-size
		    		            chips 
		    		            counter 
		    		            multiple 
		    		            label="Upload Surat Serah Terima Unit yang telah ditandatangani"
		    		            v-model="form_data.handover_doc_sign_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="sign_upload">
			              </v-file-input>
			              <a :href="form_data.sign_upload" target="_blank" class="ml-8" v-if="form_data.sign_upload">
			              	<small>@{{form_data.handover_doc_sign_name}}</small>
			              </a>
			            </validation-provider>
		            </v-col>
    		    </v-row>
	            <v-btn
		      		class="mt-4"
		      		outlined 
		      		:href="redirectUri"
		      		:disabled="field_state">
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
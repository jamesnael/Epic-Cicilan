<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Schedule Proses Akad KPR</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		</v-row>
	    		<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Klien" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.client_name"
				    			name="client_name"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		label="Nama Klien"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nomor Handphone" rules="required">
				    		<v-text-field
				    			v-model="form_data.client_mobile_number"
				    			name="client_mobile_number"
				    			hint="* harus diisi"
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
			    		<validation-provider v-slot="{ errors }" name="Unit" rules="required">
				    		<v-text-field
				    			v-model="form_data.unit"
				    			hint="* harus diisi"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Unit"
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
				    			hint="* harus diisi"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Harga Unit"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="12">
			    			<v-menu
		    		        v-model="menu3"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal PPJB" rules="required|min:1">
			    		        <v-text-field
			    		        	:value="computedDateFormattedMomentjs"
			    		        	hint="* harus diisi"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		            v-model="form_data.ppjb_date"
			    		            label="Tanggal PPJB"
			    		            readonly
			    		            v-bind="attrs"
			    		            v-on="on"
			    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker v-model="form_data.ppjb_date" @input="menu3 = false"></v-date-picker>
			    	</v-col>
			    </v-row>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="required">
				    		<v-text-field
				    			v-model="form_data.sales_name"
				    			hint="* harus diisi"
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
			    		<validation-provider v-slot="{ errors }" name="Nama Agensi" rules="required">
				    		<v-text-field
				    			v-model="form_data.agency_name"
				    			hint="* harus diisi"
				    			:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Agensi"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
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
			    		        	:value="computedDateFormattedMomentjs"
			    		        	hint="* harus diisi"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		            v-model="form_data.akad_date"
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
					          @click:minute="$refs.menu.save(time)"
					        ></v-time-picker>
					      </v-menu>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Tempat" rules="required|max:255">
				    		<v-text-field
				    			v-model="form_data.place"
				    			name="tempat"
					    		label="Tempat"
					    		hint="* harus diisi"
					    		:counter="255"
					    		:error-messages="errors"
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
					    		readonly>
			    			</v-textarea>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>
				<v-row>
					<v-col
    		          cols="12"
    		          md="12">
					    <h3 class="mt-4">Upload Dokumen Awal</h3>
			    		<validation-provider v-slot="{ errors }" name="Dokumen Awal" rules="required">
							<v-file-input 
		    		            show-size
		    		            chips 
		    		            counter 
		    		            multiple 
		    		            label="Pilih Dokumen"
		    		            v-model="form_data.dokumen_awal"
		    		            hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
				              	name="Dokumen Awal">
			              </v-file-input>
			            </validation-provider>
		          </v-col>
				</v-row>
				<v-row>
					<v-col
    		          cols="12"
    		          md="12">
					    <h3 class="mt-4">Approved Akad</h3>
			    		<validation-provider v-slot="{ errors }" name="Approval Pembeli" rules="required">
							<v-select
					        v-model="model"
					        required
					        :items="items_approval"
					        :disabled="disabled"
					        :readonly="readonly"
					        :chips="chips"
					        :multiple="multiple"
					        :append-icon="appendIcon ? 'mdi-plus' : ''"
					        :prepend-icon="prependIcon ? 'mdi-minus' : ''"
					        hint="* harus diisi"
				    		:persistent-hint="true"
				    		:error-messages="errors"
					        label="Approval Pembeli"
					      ></v-select>
						</validation-provider>
		          </v-col>
				</v-row>
				<v-row>
					<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Approval Bank" rules="required">
	    		          	<v-select
					        v-model="model"
					        required
					        :items="items_approval"
					        :disabled="disabled"
					        :readonly="readonly"
					        :chips="chips"
					        :multiple="multiple"
					        :append-icon="appendIcon ? 'mdi-plus' : ''"
					        :prepend-icon="prependIcon ? 'mdi-minus' : ''"
					        hint="* harus diisi"
				    		:persistent-hint="true"
				    		:error-messages="errors"
					        label="Approval Bank"
					      ></v-select>
					    </validation-provider>
    		        </v-col>
    		    </v-row>
    		    <v-row>
					<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Approval Developer" rules="required">
	    		          	<v-select
					        v-model="model"
					        required
					        :items="items_approval"
					        :disabled="disabled"
					        :readonly="readonly"
					        :chips="chips"
					        :multiple="multiple"
					        hint="* harus diisi"
				    		:persistent-hint="true"
				    		:error-messages="errors"
					        :append-icon="appendIcon ? 'mdi-plus' : ''"
					        :prepend-icon="prependIcon ? 'mdi-minus' : ''"
					        label="Approval Developer"
					      ></v-select>
					   	</validation-provider>
    		        </v-col>
    		    </v-row>
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
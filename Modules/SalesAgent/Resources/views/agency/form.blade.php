<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Koordinator wilayah" rules="required">
		    		<v-select
		    			v-model="form_data.regional_coordinator_id" 
		              	:items="filter_regional_coordinator"
		              	label="Koordinator Wilayah"
		              	name="regional_coordinator_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama sub agent" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.agency_name"
		    			name="agency_name"
			    		label="Nama Sub Agent"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Email sub agent" rules="required|email">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.agency_email"
		    			name="agency_email"
			    		label="Email Sub Agent"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor telepon sub agent" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.agency_phone"
		    			name="agency_phone"
			    		label="Nomor Telepon Sub Agent"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Alamat sub agent" rules="max:255">
		    		<v-textarea
		    			class="mt-4"
		    			v-model="form_data.agency_address"
		    			name="agency_address"
			    		label="Alamat Sub Agent"
			    		auto-grow
		    			clearable
		    			rows="1"
				      	clear-icon="mdi-close"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-textarea>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Province" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.province"
		    			name="province"
		    			label="Province"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Kota" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.city"
		    			name="city"
			    		label="Kota"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama bank" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.bank_name"
		    			name="bank_name"
			    		label="Nama Bank"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor rekening" rules="numeric">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.rek_number"
		    			name="rek_number"
			    		label="Nomor Rekening"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama akun" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.account_name"
		    			name="account_name"
			    		label="Nama Pemilik Akun"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="PPH Komisi Final" rules="required|between:0,100">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.pph_final"
		    			name="pph_final"
			    		label="PPH Komisi Final"
			    		:error-messages="errors"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:readonly="field_state">
			    		<v-icon slot="append">mdi-percent-outline</v-icon>
	    			</v-text-field>
	    		</validation-provider>

	    		<v-row class="mt-4">
			        <v-col
			          cols="12"
			          md="6"
			        >
			          	<validation-provider v-slot="{ errors }" name="Komisi sub agent" rules="">
				    		<v-select
				    			v-model="form_data.id_agency_commission"
				    			:items="filter_agency_commission" 
				    			@input="setSelectedAgency()"
				              	label="Komisi Sub Agent (%)"
				              	name="id_agency_commission"
				              	menu-props="auto"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state"
				            >
				            	<template slot="selection" slot-scope="data">
				            	    @{{ data.item.text }}
				            	</template>
			            	  	<template slot="item" slot-scope="data">
			            	  		<table width="100%" border="0" class="mt-2">
			            	  			<tr>
			            	  				<td width="35%">Koordinator Utama</td>
			            	  				<td>:</td>
			            	  				<td>@{{ data.item.main_coordinator_commission }} %</td>
			            	  			</tr>
			            	  			<tr>
			            	  				<td>Koordinator Wilayah</td>
			            	  				<td>:</td>
			            	  				<td>@{{ data.item.regional_coordinator_commission }} %</td>
			            	  			</tr>
			            	  			<tr>
			            	  				<td>Sub Agent</td>
			            	  				<td>:</td>
			            	  				<td>@{{ data.item.text }} %</td>
			            	  			</tr>
			            	  			<tr>
			            	  				<td>Sales</td>
			            	  				<td>:</td>
			            	  				<td>@{{ data.item.sales_commission }} %</td>
			            	  			</tr>
			            	  		</table>
			            	  	</template>
				            </v-select>
	    				</validation-provider>
			        </v-col>
			        <v-text-field
			           v-model="form_data.agency_commission"
			           v-show=false
			           name="agency_commission">
			        </v-text-field>
			        <v-col
			          cols="12"
			          md="6"
			        >
			          	<validation-provider v-slot="{ errors }" name="Komisi sales" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_commission"
				              	label="Komisi Sales (%)"
				              	name="sales_commission"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
          			    		:disabled="field_state"
				            ></<v-text-field>
	    				</validation-provider>
			        </v-col>
			    </v-row>
	    		<v-row>
			        <v-col
			          	cols="12"
			          	md="6"
			        >
			          	<validation-provider v-slot="{ errors }" name="Komisi koordinator utama" rules="required">
          		    		<v-text-field
          		    			v-model="form_data.main_coordinator_commission" 
          		              	label="Komisi Koordinator Utama (%)"
          		              	name="main_coordinator_commission"
          			    		:persistent-hint="true"
          			    		:error-messages="errors"
          			    		:readonly="!field_state"
          			    		:disabled="field_state"
          		            ></v-text-field>
          	    		</validation-provider>
			        </v-col>

			        <v-col
			          cols="12"
			          md="6"
			        >
			          	<validation-provider v-slot="{ errors }" name="Komisi koordinator wilayah" rules="">
				    		<v-text-field
				    			v-model="form_data.regional_coordinator_commission"
				              	label="Komisi Koordinator Wilayah (%)"
				              	name="regional_coordinator_commission"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
          			    		:disabled="field_state"
				            ></v-text-field>
			    		</validation-provider>
			        </v-col>
			    </v-row>
			    <validation-provider v-slot="{ errors }" name="Total komisi" rules="required|min:0">
		    		<v-text-field
		    			class="mt-4"
			    		label="Total Komisi (%)"
			    		:error-messages="errors"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:readonly="!field_state"
          			    :disabled="field_state"
			    		:value="total"
			    		>
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
        {{-- centered --}}
        top
        multi-line
        :color="formAlertState"
        elevation="5"
        timeout="6000"
    >
    	@{{ formAlertText }}
    </v-snackbar>
</v-container>
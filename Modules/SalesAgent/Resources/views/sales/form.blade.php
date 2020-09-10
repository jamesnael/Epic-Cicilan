<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Koordinator utama" rules="required">
		    		<v-autocomplete
		    			v-model="form_data.main_coordinator_id" 
		              	:items="filter_main_coordinator"
		              	label="Koordinator Utama"
		              	name="main_coordinator_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Koordinator wilayah" rules="">
		    		<v-autocomplete
		    			v-model="form_data.regional_coordinator_id" 
		              	:items="computedRegionalCoordinator"
		              	label="Koordinator Wilayah"
		              	name="regional_coordinator_id"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Sub Agent" rules="">
		    		<v-autocomplete
		    			v-model="form_data.agency_id" 
		              	:items="computedAgency"
		              	label="Sub Agent"
		              	name="agency_id"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama lengkap" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_user.full_name"
		    			name="full_name"
			    		label="Nama Lengkap"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Email" rules="required|email">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_user.email"
		    			name="email"
			    		label="Email"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-if="!dataUri" v-slot="{ errors }" name="Password" rules="required">
		    		<v-text-field
    		            v-model="form_user.password"
    		            :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
    		            :type="showPassword ? 'text' : 'password'"
    		            hint="* harus diisi minimal 8 karakter"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
    		            name="password"
    		            label="Password"
    		            counter
    		            @click:append="showPassword = !showPassword"
    		          ></v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor HP" rules="required|max:15">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_user.phone_number"
		    			name="phone_number"
			    		label="Nomor HP"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		placeholder="+62"
			    		:counter="15"
			    		v-mask="'+62############'"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Alamat" rules="max:255">
		    		<v-textarea
		    			class="mt-4"
		    			v-model="form_user.address"
		    			name="address"
			    		label="Alamat"
			    		auto-grow
		    			clearable
		    			rows="1"
				      	clear-icon="mdi-close"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-textarea>
	    		</validation-provider>
	    		<address-input inline-template
	    			:province-value="form_data.province"
	    			province-class="mt-4"
	    			province-input-name="province"
	    			province-label="Provinsi"
	    			:city-value="form_data.city"
	    			city-class="mt-4"
	    			city-input-name="city"
	    			city-label="Kota"
	    			:disabled="field_state"
	    		>
	    			@include('core::address')
	    		</address-input>
	    		{{-- <validation-provider v-slot="{ errors }" name="Province" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_user.province"
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
		    			v-model="form_user.city"
		    			name="city"
			    		label="Kota"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider> --}}
	    		<validation-provider v-slot="{ errors }" name="NIP Sales" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.sales_nip"
		    			name="sales_nip"
			    		label="NIP Sales"
			    		{{-- hint="* harus diisi" --}}
			    		{{-- :persistent-hint="true" --}}
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<br>

	    		<validation-provider v-slot="{ errors }" name="Foto KTP" rules="image">
		    		<v-file-input
		    		    accept="image/*"
		    		    prepend-icon="mdi-camera"
		    		    hint="hanya menerima file dalam format image"
			    		:persistent-hint="true"
		    		    show-size
		    		    label="Foto KTP"
		    		    name="file_ktp"
		    		  ></v-file-input>
		    		  <a :href="form_data.url_file_ktp" target="_blank" class="ml-8">
		    		  	<small>@{{form_data.file_ktp}}</small>
		    		  </a>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Foto NPWP" rules="image">
		    		<v-file-input
		    			class="mt-4"
		    		    accept="image/*"
		    		    prepend-icon="mdi-camera"
		    		    show-size
		    		    hint="hanya menerima file dalam format image"
			    		:persistent-hint="true"
		    		    label="Foto NPWP"
		    		    name="file_npwp"
		    		  ></v-file-input>
		    		  <a :href="form_data.url_file_npwp" target="_blank" class="ml-8">
		    		  	<small>@{{form_data.file_npwp}}</small>
		    		  </a>
	    		</validation-provider>

				{{-- <v-row class="mt-4">
			        <v-col
			          cols="12"
			          md="6"
			        >
			          	<validation-provider v-slot="{ errors }" name="Komisi sales" rules="">
				    		<v-autocomplete
				    			v-model="form_data.sales_commission"
				    			:items="filter_sales_commission" 
				    			@input="setSelectedSales()"
				              	label="Komisi Sales (%)"
				              	name="sales_commission"
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
			            	  				<td>@{{ data.item.agency_commission }} %</td>
			            	  			</tr>
			            	  			<tr>
			            	  				<td>Sales</td>
			            	  				<td>:</td>
			            	  				<td>@{{ data.item.text }} %</td>
			            	  			</tr>
			            	  		</table>
			            	  	</template>
				            </v-autocomplete>
	    				</validation-provider>
			        </v-col>
			        <v-col
			          cols="12"
			          md="6"
			        >
			          	<validation-provider v-slot="{ errors }" name="Komisi sub agent" rules="">
				    		<v-text-field
				    			v-model="form_data.agency_commission"
				              	label="Komisi Sub Agent (%)"
				              	name="agency_commission"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state"
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
          			    		:readonly="field_state"
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
					    		:readonly="field_state"
				            ></v-text-field>
			    		</validation-provider>
			        </v-col>
			    </v-row> --}}

			    

			    <validation-provider v-slot="{ errors }" name="Status" rules="required">
		    		<v-autocomplete
		    			v-model="form_data.status" 
		              	:items='["Aktif","Tidak Aktif"]'
		              	label="Status"
		              	name="status"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
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
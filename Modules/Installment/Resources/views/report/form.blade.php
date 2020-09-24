<v-container fluid>
    <v-card>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<v-card-title>Laporan</v-card-title>

    		<v-card-text>
		    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form" action="{{ route('report.store') }}">
		    		{{ csrf_field() }}
		    		<v-row>
					   <v-col
					      	cols="12"
					      	md="12">
							<validation-provider v-slot="{ errors }" name="Nama Laporan" rules="required">
								<v-autocomplete
									v-model="form_data.nama_laporan" 
							      	:items="listLaporan"
							      	label="Pilih Nama Laporan"
							      	name="nama_laporan"
									hint="* harus diisi"
									:persistent-hint="true"
									:error-messages="errors"
									:readonly="field_state"
							    ></v-autocomplete>
							</validation-provider>
						</v-col>
					</v-row>
					<!-- <v-row>
					   <v-col
					      	cols="12"
					      	md="12">
							<validation-provider v-slot="{ errors }" name="Nama Klien" rules="required">
								<v-autocomplete
									v-model="form_data.client_name"
							      	:items="filter_client"
							      	label="Nama Klien"
							      	name="client_name"
									hint="* harus diisi"
									:persistent-hint="true"
									:error-messages="errors"
									:readonly="field_state"
							    ></v-autocomplete>
							</validation-provider>
						</v-col>
					</v-row> -->
					<v-row>
					   <v-col
					      	cols="12"
					      	md="12">		
							<validation-provider v-slot="{ errors }" name="Nama Sales" rules="">
								<v-autocomplete
									v-model="form_data.user_name" 
									@input="setSelectedSales()"
							      	:items="filter_sales"
							      	label="Nama Sales"
							      	name="user_name"
									:error-messages="errors"
									:readonly="field_state"
							    >
							    	<template slot="selection" slot-scope="data">
							    	    @{{ data.item.text }}
							    	</template>
								  	<template slot="item" slot-scope="data">
								  		<table width="100%" class="mt-2">
								  			<tr>
								  				<td>Sales</td>
								  				<td>:</td>
								  				<td>@{{ data.item.text }}</td>
								  			</tr>
								  			<tr>
								  				<td width="25%">Sub Agent</td>
								  				<td width="25%">:</td>
								  				<td>@{{ data.item.agency_name }}</td>
								  			</tr>
								  			<tr>
								  				<td width="25%">Korwil</td>
								  				<td width="25%">:</td>
								  				<td>@{{ data.item.regional_coordinator }}</td>
								  			</tr>
								  		</table>
								  	</template>
							  		<v-divider></v-divider>
							    </v-autocomplete>
							</validation-provider>
						</v-col>
					</v-row>
					<v-row>
						<v-col
    		          	cols="12"
    		          	md="12">
				    		<validation-provider v-slot="{ errors }" name="Nama Sub Agent" rules="">
					    		<v-text-field
					    			v-model="form_data.agency_name"
					    			name="agency_name"
						    		label="Nama Sub Agent"
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
				    		<validation-provider v-slot="{ errors }" name="Nama Koordinator Wilayah" rules="">
					    		<v-text-field
					    			v-model="form_data.regional_coordinator"
					    			name="regional_coordinator"
						    		label="Nama Koordinator Wilayah"
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
							<validation-provider v-slot="{ errors }" name="Status" rules="required">
								<v-autocomplete
					    			v-model="form_data.status"
							      	:items="listStatus"
							      	label="Status"
							      	name="status"
									hint="* harus diisi"
									:persistent-hint="true"
									:error-messages="errors"
									:readonly="field_state"
							    ></v-autocomplete>
							</validation-provider>
						</v-col>
				    </v-row>
				    <v-row>
				    	<v-col
	    		          	cols="12"
	    		          	md="6">
				    			<v-menu
			    		        v-model="menu4"
			    		        :close-on-content-click="false"
			    		        :nudge-right="40"
			    		        transition="scale-transition"
			    		        offset-y
			    		        min-width="290px"
			    		      >
		    		        	<template v-slot:activator="{ on, attrs }">
					    		<validation-provider v-slot="{ errors }" name="Dari Tanggal" rules="required|min:1">
			    		        <v-text-field
			    		        	:value="reformatDateTime(from_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
				    		        prepend-icon="mdi-calendar"
						    		:error-messages="errors"
			    		            label="Dari Tanggal"
			    		            v-bind="attrs"
			    		            v-on="on"
			    		            name="from_date"
			    		            readonly
			    		        ></v-text-field>
					    		</validation-provider>
		    		        	</template>
		    		        	<v-date-picker name="from_date" v-model="from_date" @input="menu4 = false"></v-date-picker>
				    	</v-col>
				    	<v-col
	    		          	cols="12"
	    		          	md="6">
				    			<v-menu
			    		        v-model="menu3"
			    		        :close-on-content-click="false"
			    		        :nudge-right="40"
			    		        transition="scale-transition"
			    		        offset-y
			    		        min-width="290px"
			    		      >
		    		        	<template v-slot:activator="{ on, attrs }">
					    		<validation-provider v-slot="{ errors }" name="Sampai Tanggal" rules="required|min:1">
			    		        <v-text-field
			    		        	:value="reformatDateTime(until_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
				    		        prepend-icon="mdi-calendar"
			    		            label="Sampai Tanggal"
			    		            v-bind="attrs"
			    		            v-on="on"
			    		            :readonly="!field_state"
			    		            name="until_date"
			    		            :error-messages="errors">
			    		        ></v-text-field>
					    		</validation-provider>
		    		        	</template>
		    		        	<v-date-picker name="until_date" v-model="until_date" :min="from_date" @input="menu3 = false" :disabled="!from_date"></v-date-picker>

				    	</v-col>
				    </v-row>
				    <br>
				    <v-btn
			      		class="mt-5"
			      		outlined
			      		:href="redirectUri"
			      		:disabled="field_state">
	    		      	Kembali
	    		    </v-btn>
		    		<v-btn
			    		class="mt-5 mr-4 white--text"
			    		color="primary"
		    		    elevation="5"
			    		:disabled="field_state"
			    		:loading="field_state"
			    		@click="checkForm">
			    		Submit
		    		    <template v-slot:loader>
	    		            <span class="custom-loader">
	    		              	<v-icon color="white">mdi-sync</v-icon>
	    		            </span>
	    		        </template>
			    	</v-btn>
		    	</form>
		    </v-card-text>
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
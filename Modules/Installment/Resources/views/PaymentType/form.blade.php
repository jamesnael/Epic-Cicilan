<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Tipe Pembayaran</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		</v-row>
	    		<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
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
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="ID Klien" rules="required">
				    		<v-text-field
				    			v-model="form_data.id_client"
				    			name="id_client"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="ID Klien"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Email" rules="required">
				    		<v-text-field
				    			v-model="form_data.email"
				    			name="email"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Email"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
	    		<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="No handphone" rules="required">
				    		<v-text-field
				    			v-model="form_data.no_handphone"
				    			name="no_handphone"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="No Handphone"
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
				    			v-model="form_data.alamat"
				    			name="alamat"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Alamat"
					    		readonly>
			    			</v-textarea>
			    		</validation-provider>
				    </v-col>
			    </v-row>
	    		<v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
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
			    </v-row>
			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Nama Sub Agent" rules="required">
				    		<v-text-field
				    			v-model="form_data.agent_name"
				    			name="agent_name"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Sub Agent"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			       <h3 class="mt-4">Data Unit</h3>
				<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Tipe Rumah" rules="required">
				    		<v-text-field
				    			v-model="form_data.house_type"
				    			name="house_type"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Tipe Rumah"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
				<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Blok" rules="required">
				    		<v-text-field
				    			v-model="form_data.blok"
				    			name="blok"
					    		hint="* harus diisi"
					    		label="Blok"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
			    		</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Luas Kavling" rules="required">
				    		<v-text-field
				    			v-model="form_data.luas_kavling"
				    			name="luas_kavling"
					    		label="Luas Kavling"
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
			    		<validation-provider v-slot="{ errors }" name="No Blok" rules="required">
				    		<v-text-field
				    			v-model="form_data.no_blok"
				    			name="no_blok"
					    		hint="* harus diisi"
					    		label="No Blok"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
			    		</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Luas Bangunan" rules="required">
				    		<v-text-field
				    			v-model="form_data.luas_bangunan"
				    			name="luas_bangunan"
					    		label="Luas Bangunan"
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
			    		<validation-provider v-slot="{ errors }" name="Tanggal Pembelian" rules="required">
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
	    		            v-model="form_data.tanggal_pembelian"
	    		            label="Tanggal Pembelian"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.tanggal_pembelian" @input="menu2 = false"></v-date-picker>
    		      	</v-menu>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="20">
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
	    		            v-model="form_data.tanggal_PPJB"
	    		            name="tanggal_PPJB"
	    		            label="Tanggal PPJB"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.tanggal_PPJB" @input="menu3 = false"></v-date-picker>
    		      	</v-menu>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="20">
			    		<validation-provider v-slot="{ errors }" name="Tanggal Akad KPR" rules="required">
				    			<v-menu
	    		        v-model="menu4"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
	    		        <v-text-field
	    		        	:value="computedDateFormattedMomentjs"
	    		            v-model="form_data.tanggal_akad_kpr"
	    		            label="Tanggal Akad KPR"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.tanggal_akad_kpr" @input="menu4 = false"></v-date-picker>
    		      	</v-menu>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Cara Bayar Cicilan" rules="required">
				    		<v-select
			    			v-model="form_data.cara_bayar_cicilan" 
			    			@input="setSelectedClient()"
			              	:items="filter_client"
			              	label="Cara Bayar Cicilan"
			              	name="cara_bayar_cicilan"
			              	hint="* harus diisi"
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
			    		<validation-provider v-slot="{ errors }" name="Harga Unit + PPN" rules="required">
				    		<v-text-field
				    			v-model="form_data.harga_unit_dan_ppn"
				    			name="harga_unit_dan_ppn"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="Harga Unit + PPN"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>

				<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Harga Unit Exc PPN" rules="required">
				    		<v-text-field
				    			v-model="form_data.harga_unit_exc_ppn"
				    			name="harga_unit_exc_ppn"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="Harga Unit Exc PPN"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>

			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Harga Dasar" rules="required">
				    		<v-text-field
				    			v-model="form_data.harga_dasar"
				    			name="harga_dasar"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="Harga Dasar"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>

			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="PPN" rules="required">
				    		<v-text-field
				    			v-model="form_data.ppn"
				    			name="ppn"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="PPN"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>

			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="BPHTB" rules="required">
				    		<v-text-field
				    			v-model="form_data.bphtb"
				    			name="bphtb"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="BPHTB"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>

			    <v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="NUP" rules="required">
				    		<v-text-field
				    			v-model="form_data.nup"
				    			name="nup"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="NUP"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>

			    
			    
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="20">
			    		<validation-provider v-slot="{ errors }" name="Tanggal Pembayaran NUP" rules="required">
				    			<v-menu
	    		        v-model="menu5"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
	    		        <v-text-field
	    		        	:value="computedDateFormattedMomentjs"
	    		            v-model="form_data.tanggal_pembyaran_nup"
	    		            label="Tanggal Pembayaran NUP"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.tanggal_pembyaran_nup" @input="menu5 = false"></v-date-picker>
    		      	</v-menu>
			    		</validation-provider>
			    	</v-col>
			    </v-row>


			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Pembayaran NUP Via" rules="required">
				    		<v-select
			    			v-model="form_data.pembayaran_nup_via" 
			    			@input="setSelectedClient()"
			              	:items="filter_client"
			              	label="Pembayaran NUP Via"
			              	name="pembayaran_nup_via"
			              	hint="* harus diisi"
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
			    		<validation-provider v-slot="{ errors }" name="UTJ" rules="required">
				    		<v-text-field
				    			v-model="form_data.utj"
				    			name="utj"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="UTJ"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>


			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="20">
			    		<validation-provider v-slot="{ errors }" name="Tanggal Pembayaran UTJ" rules="required">
				    			<v-menu
	    		        v-model="menu6"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
	    		        <v-text-field
	    		        	:value="computedDateFormattedMomentjs"
	    		            v-model="form_data.tanggal_pembyaran_utj"
	    		            label="Tanggal Pembayaran UTJ"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.tanggal_pembyaran_utj" @input="menu6 = false"></v-date-picker>
    		      	</v-menu>
			    		</validation-provider>
			    	</v-col>
			    </v-row>


			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Pembayaran UTJ Via" rules="required">
				    		<v-select
			    			v-model="form_data.pembayaran_utj_via" 
			    			@input="setSelectedClient()"
			              	:items="filter_client"
			              	label="Pembayaran UTJ Via"
			              	name="pembayaran_utj_via"
			              	hint="* harus diisi"
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
			    		<validation-provider v-slot="{ errors }" name="Total Bayar DP1" rules="required">
				    		<v-text-field
				    			v-model="form_data.total_bayar_dp1"
				    			name="total_bayar_dp1"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					  
					    		:error-messages="errors"
					    		label="Total Bayar DP1"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>



			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="20">
			    		<validation-provider v-slot="{ errors }" name="Jatuh Tempo Cicilan" rules="required">
				    			<v-menu
	    		        v-model="menu7"
	    		        :close-on-content-click="false"
	    		        :nudge-right="40"
	    		        transition="scale-transition"
	    		        offset-y
	    		        min-width="290px"
	    		      >
    		        	<template v-slot:activator="{ on, attrs }">
	    		        <v-text-field
	    		        	:value="computedDateFormattedMomentjs"
	    		            v-model="form_data.tanggal_jatuh_tempo_cicilan"
	    		            label="Tanggal Jatuh Tempo Cicilan"
	    		            hint="* harus diisi"
	    		            :persistent-hint="true"
					    	:error-messages="errors"
					    	:readonly="field_state"
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.tanggal_jatuh_tempo_cicilan" @input="menu7 = false"></v-date-picker>
    		      	</v-menu>
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
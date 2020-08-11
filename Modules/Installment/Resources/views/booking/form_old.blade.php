<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Unit" rules="required">
		    		<v-select
		    			:v-model="form_data.unit_id" 
		              	:items="filter_unit"
		              	label="Unit"
		              	name="unit_id"
			    		hint="* harus diisi"
			    		@input="setSelectedUnit()"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Tipe rumah" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			:v-model="form_data.unit_type"
		    			name="unit_type"
			    		label="Tipe Rumah"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>

	    		<v-row>
    		        <v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Blok" rules="max:255">
				    		<v-text-field
				    			class="mt-4"
				    			:v-model="form_data.unit_block"
				    			name="unit_block"
					    		label="Blok"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Nomor unit" rules="max:255">
				    		<v-text-field
				    			class="mt-4"
				    			:v-model="form_data.unit_number"
				    			name="unit_number"
					    		label="Nomor Unit"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Luas kavling" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			:v-model="form_data.surface_area"
				    			name="surface_area"
					    		label="Luas Kavling (m2)"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Luas bangunan" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			:v-model="form_data.building_area"
				    			name="building_area"
					    		label="Luas Bangunan (m2)"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>
		    	<validation-provider v-slot="{ errors }" name="Tanggal pembelian" rules="">
		    	    <v-menu
		    	        v-model="datepicker"
		    	        :close-on-content-click="false"
		    	        :nudge-right="40"
		    	        transition="scale-transition"
		    	        offset-y
		    	        min-width="290px">
		    	        <template v-slot:activator="{ on, attrs }">
		    	          <v-text-field
			    	        class="mt-4"
		    	            v-model="date"
		    	            label="Tanggal Pembelian"
		    	            readonly
		    	            v-bind="attrs"
		    	            v-on="on"
		    	            prepend-icon="mdi-calendar"
		    	            :persistent-hint="true"
		    	            :counter="255"
		    	            :error-messages="errors"
		    	            :readonly="field_state">
		    	          ></v-text-field>
		    	        </template>
	    	        <v-date-picker v-model="date" @input="datepicker = false"></v-date-picker>
	    	      	</v-menu>
    	      	</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Cara bayar cicilan" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			name="payment_type"
			    		label="Cara Bayar Cicilan"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Harga unit + ppn" rules="numeric|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Harga Unit + PPN"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Harga unit exc ppn" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Harga Unit Except PPN"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Harga dasar" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Harga Dasar"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="PPN" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="PPN (Rp)"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="BPHTB" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="BPHTB"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="NUP" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="NUP"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran NUP" rules="">
		    	    <v-menu
		    	        v-model="datepicker"
		    	        :close-on-content-click="false"
		    	        :nudge-right="40"
		    	        transition="scale-transition"
		    	        offset-y
		    	        min-width="290px">
		    	        <template v-slot:activator="{ on, attrs }">
		    	          <v-text-field
			    	        class="mt-4"
		    	            v-model="date"
		    	            label="Tanggal Pembayaran NUP"
		    	            readonly
		    	            v-bind="attrs"
		    	            v-on="on"
		    	            prepend-icon="mdi-calendar"
		    	            :persistent-hint="true"
		    	            :counter="255"
		    	            :error-messages="errors"
		    	            :readonly="field_state">
		    	          ></v-text-field>
		    	        </template>
	    	        <v-date-picker v-model="date" @input="datepicker = false"></v-date-picker>
	    	      	</v-menu>
    	      	</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Pembayaran NUP" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Pembayaran NUP"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="UTJ" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="UTJ"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Tgl Pembayaran UTJ" rules="">
		    	    <v-menu
		    	        v-model="datepicker"
		    	        :close-on-content-click="false"
		    	        :nudge-right="40"
		    	        transition="scale-transition"
		    	        offset-y
		    	        min-width="290px">
		    	        <template v-slot:activator="{ on, attrs }">
		    	          <v-text-field
			    	        class="mt-4"
		    	            v-model="date"
		    	            label="Tgl Pembayaran UTJ"
		    	            readonly
		    	            v-bind="attrs"
		    	            v-on="on"
		    	            prepend-icon="mdi-calendar"
		    	            :persistent-hint="true"
		    	            :counter="255"
		    	            :error-messages="errors"
		    	            :readonly="field_state">
		    	          ></v-text-field>
		    	        </template>
	    	        <v-date-picker v-model="date" @input="datepicker = false"></v-date-picker>
	    	      	</v-menu>
    	      	</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Pembayaran UTJ" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Pembayaran UTJ"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Total Bayar DP 1" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Total Bayar DP 1"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Jatuh tempo cicilan" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Jatuh Tempo Cicilan"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama klien" rules="required">
		    		<v-text-field
		    			class="mt-6"
		    			name=""
			    		label="Nama Klien"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="ID klien" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="ID Klien"
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
		    			name=""
			    		label="Email"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="No. Handphone" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="No. Handphone"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Alamat" rules="max:255">
		    		<v-textarea
		    			class="mt-4"
		    			name=""
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
	    		<validation-provider v-slot="{ errors }" name="Nama sales" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Nama Sales"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama agensi" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Nama Agensi"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Point sales" rules="required">
		    		<v-text-field
		    			class="mt-4"
		    			name=""
			    		label="Point Sales"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
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
        top
        multi-line
        :color="formAlertState"
        elevation="5"
        timeout="6000"
    >
    	@{{ formAlertText }}
    </v-snackbar>
</v-container>
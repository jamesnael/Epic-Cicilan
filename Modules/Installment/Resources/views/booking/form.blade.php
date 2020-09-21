<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<h3>Data Unit</h3>
	    		<validation-provider v-slot="{ errors }" name="Tipe unit" rules="required">
		    		 <v-autocomplete
		    			class="mt-4"
		    			v-model="form_data.id_unit_type" 
		    			@input="setSelectedUnitType()"
		              	:items="filter_unit_type"
		              	label="Tipe Unit"
		              	name="id_unit_type"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
	    		</validation-provider>
	    		<v-text-field
		           v-model="form_data.unit_type"
		           v-show=false
		           name="unit_type">
		        </v-text-field>
	    		{{-- <validation-provider v-slot="{ errors }" name="Tipe rumah" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.unit_type"
		    			name="unit_type"
			    		label="Tipe Rumah"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider> --}}
	    		<v-row>
    		        <v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Blok" rules="required|max:255">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.unit_block"
				    			name="unit_block"
					    		label="Blok"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Nomor unit" rules="required|max:255">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.unit_number"
				    			name="unit_number"
					    		label="Nomor Unit"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
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
			    		<validation-provider v-slot="{ errors }" name="Luas kavling" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.surface_area"
				    			name="surface_area"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
					    		<template slot="label">
					    		    <span v-html="'Luas Kavling (m<sup>2</sup>)'"></span>
					    		</template>
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Luas bangunan" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.building_area"
				    			name="building_area"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
					    		<template slot="label">
					    		    <span v-html="'Luas Bangunan (m<sup>2</sup>)'"></span>
					    		</template>
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>
		    	<v-row>
			    	<v-col
    		          cols="12"
    		          md="12">
			    		<validation-provider v-slot="{ errors }" name="Jalan" rules="required|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.unit_address"
				    			name="unit_address"
					    		hint="* harus diisi"
					    		label="Jalan"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>
		    	<v-row>
		    		{{-- <v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="UTJ" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.utj"
				    			name="utj"
					    		label="UTJ"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{ form_data.utj ? number_format(form_data.utj) : 0 }}</small>
			    		</validation-provider>
			    	</v-col> --}}
			    	{{-- <v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Daya listrik" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.electrical_power"
				    			name="electrical_power"
					    		label="Daya Listrik (Watt)"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col> --}}
		    		<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Point" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.points"
				    			name="points"
					    		label="Point"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disable="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    	<v-col
    		          cols="12"
    		          md="6">
			    		<validation-provider v-slot="{ errors }" name="Closing fee" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.closing_fee"
				    			name="closing_fee"
					    		label="Closing Fee"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disable="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{ form_data.closing_fee ? number_format(form_data.closing_fee) : 0 }}</small>
			    		</validation-provider>
			    	</v-col>
		    	</v-row>

		    	<h3 class="mt-6">Data Tipe Program</h3>
	    		<validation-provider v-slot="{ errors }" name="Tipe program" rules="required">
		    		 <v-autocomplete
		    			class="mt-4"
		    			v-model="form_data.program_id" 
		    			@input="setSelectedProgram()"
		              	:items="filter_tipe_programs"
		              	item-text="nama_program"
              	        item-value="id"
		              	label="Tipe Program"
		              	name="program_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
	    		</validation-provider>
	    		<v-text-field
	    			class="mt-4"
	    			v-model="program.nama_program"
	    			name="nama_program"
		    		label="Nama Tipe Program"
		    		v-show="false"
		    		:readonly="!field_state"
		    		:disabled="field_state">
    			</v-text-field>
	    		<v-row
	    			class="mt-4">
    		        <v-col
    		          	cols="12"
						md="6">
						<h5>
							Harga Sudah Termasuk
						</h5>
						<div
							v-for="(el, idx) in program.harga_termasuk"
						>
							<v-text-field
								class="mt-3"
					            v-model="program.harga_termasuk[idx]"
					            name="harga_termasuk[]"
					            label=""
					            type="text"
					            :readonly="!field_state"
					            :disabled="field_state"
							></v-text-field>
						</div>
    		      	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
    		          	<h5>
	    		          	Harga Tidak Termasuk
	    		        </h5>
    		        	<div
    		        		v-for="(el, idx) in program.harga_tidak_termasuk"
    		        	>
    		        		<v-text-field
    		        			class="mt-3"
    		                    v-model="program.harga_tidak_termasuk[idx]"
    		                    name="harga_tidak_termasuk[]"
    		                    label=""
    		                    type="text"
    		                    :readonly="!field_state"
    		                    :disabled="field_state"
    		        		></v-text-field>
    		        	</div>
    		      	</v-col>
	    		</v-row>
	    		<v-text-field
	    			class="mt-4"
	    			v-model="program.gimmick"
	    			name="gimmick"
		    		label="Gimmick"
		    		:readonly="!field_state"
		    		:disabled="field_state">
    			</v-text-field>
	    		<v-text-field
	    			class="mt-4"
	    			v-model="program.keterangan_program"
	    			name="keterangan_program"
		    		label="Keterangan"
		    		:readonly="!field_state"
		    		:disabled="field_state">
    			</v-text-field>

		    	<h3 class="mt-6">Data NUP & UTJ</h3>
	    		<v-row>
	    			<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Total NUP" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.nup_amount"
				    			name="nup_amount"
					    		label="Total NUP"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{ form_data.nup_amount ? number_format(form_data.nup_amount) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
	    			<v-col
    		          	cols="12"
    		          	md="6">
    		          	<payment-method-input inline-template
    		          		payment-method-rules="required"
    		          		:payment-method-value="form_data.payment_method_nup"
    		          		payment-method-class="mt-4"
    		          		payment-method-input-name="payment_method_nup"
    		          		payment-method-label="Cara Pembayaran NUP"
    		          		:disabled="field_state"
    		          	>
    		          		@include('core::payment_method')
    		          	</payment-method-input>
			    		{{-- <validation-provider v-slot="{ errors }" name="Metode pembayaran NUP" rules="required">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.payment_method_nup"
				    			name="payment_method_nup"
					    		label="Metode Pembayaran NUP"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider> --}}
			    	</v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="6"
    		          	md="6">
				    		<v-menu
		    		        v-model="menu2"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal pembayaran NUP" rules="required">
			    		        <v-text-field
			    		        	:value="reformatDateTime(form_data.nup_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
			    		        	hint="* harus diisi"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		            label="Tanggal Pembayaran NUP"
			    		            readonly
			    		            v-bind="attrs"
			    		            v-on="on"
			    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="nup_date" v-model="form_data.nup_date" @input="menu2 = false"></v-date-picker>
	    		      	</v-menu>
			    	</v-col>
			    </v-row>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Total UTJ" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.utj_amount"
				    			name="utj_amount"
					    		label="Total UTJ"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    			<small class="form-text text-muted">Rp @{{ form_data.utj_amount ? number_format(form_data.utj_amount) : 0 }}</small>
			    		</validation-provider>
				    </v-col>
	    			<v-col
    		          	cols="12"
    		          	md="6">
    		          	<payment-method-input inline-template
    		          		payment-method-rules="required"
    		          		:payment-method-value="form_data.payment_method_utj"
    		          		payment-method-class="mt-4"
    		          		payment-method-input-name="payment_method_utj"
    		          		payment-method-label="Cara Pembayaran UTJ"
    		          		:disabled="field_state"
    		          		hint="* harus diisi"
    		          		:persistent-hint="true"
    		          	>
    		          		@include('core::payment_method')
    		          	</payment-method-input>
			    		{{-- <validation-provider v-slot="{ errors }" name="Metode pembayaran UTJ" rules="required">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.payment_method_utj"
				    			name="payment_method_utj"
					    		label="Metode Pembayaran UTJ"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider> --}}
			    	</v-col>
			    </v-row>
			    <v-row>
				    <v-col
    		          	cols="12"
    		          	md="4">
				    		<v-menu
		    		        v-model="menu"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal Pembayaran UTJ" rules="required">
			    		        <v-text-field
			    		        	class="mt-4"
			    		        	:value="reformatDateTime(form_data.utj_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
			    		        	hint="* harus diisi"
			    		        	:persistent-hint="true"
						    		:error-messages="errors"
			    		            label="Tanggal Pembayaran UTJ"
			    		            readonly
			    		            v-bind="attrs"
			    		            v-on="on"
			    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="utj_date" v-model="form_data.utj_date" @input="menu = false"></v-date-picker>
	    		      	</v-menu>
			    	</v-col>
			    	<v-col
    		          	cols="12"
    		          	md="4">
    		          	<bank-input inline-template
    		          		:bank-value="form_data.bank_name"
    		          		bank-class="mt-4"
    		          		bank-input-name="bank_name"
    		          		bank-label="Nama Bank"
    		          		:disabled="field_state"
    		          	>
    		          		@include('core::bank')
    		          	</bank-input>
			    		{{-- <validation-provider v-slot="{ errors }" name="Nama bank" rules="">
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
			    		</validation-provider> --}}
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="4">
			    		<validation-provider v-slot="{ errors }" name="Nomor rekening" rules="numeric">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.card_number"
				    			name="card_number"
					    		label="Nomor Rekening"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>

			    <h3 class="mt-4">Data Cicilan Unit</h3>
			    <v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Tipe pembayaran" rules="required">
				    		<v-autocomplete
				    			class="mt-4"
				    			v-model="payment_type" 
				              	:items="['Hard Cash', 'Installments', 'KPR/KPA']"
				              	label="Tipe Pembayaran"
				              	@change="paymentType"
				              	name="payment_type"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state"
				            ></v-autocomplete>
			    		</validation-provider>
			    	</v-col>
		    		<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="Nama pembayaran" rules="required">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.payment_method"
				    			name="payment_method"
					    		label="Nama Pembayaran"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:counter="255"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
			    	{{-- <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="PPN" rules="required|numeric|min:0">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.ppn"
				    			name="ppn"
					    		label="PPN"
					    		hint="* harus diisi"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col> --}}
			    </v-row>
			   
	    		<validation-provider v-slot="{ errors }" name="Total harga + ppn" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="total_amount"
		    			name="total_amount"
			    		label="Total Harga + PPN"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    			<small class="form-text text-muted">Rp @{{total_amount ? number_format(total_amount) : 0 }}</small>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="DP" rules="numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-if="payment_type == 'KPR/KPA'"
		    			v-model="dp_amount"
		    			name="dp_amount"
			    		label="Total DP"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    			<small v-if="payment_type == 'KPR/KPA'" class="form-text text-muted">Rp @{{dp_amount ? number_format(dp_amount) : 0 }}</small>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Pembayaran pertama" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="first_payment"
		    			name="first_payment"
			    		label="Pembayaran Pertama"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    			<small class="form-text text-muted">Rp @{{ first_payment ? number_format(first_payment) : 0 }}</small>
	    		</validation-provider>

	    		<validation-provider v-slot="{ errors }" name="Total cicilan yang harus dibayar" rules="required|numeric|min:0">

		    		<v-text-field
		    			class="mt-4"
		    			v-model="principal"
		    			name="principal"
			    		label="Total Cicilan Yang Harus Dibayar"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="!field_state"
			    		:disabled="field_state">
	    			</v-text-field>
	    			<small class="form-text text-muted">Rp @{{ principal ? number_format(principal) : 0 }}</small>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Lama cicilan" rules="required|numeric|min:1">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="installment_time"
		    			name="installment_time"
			    		label="Lama Cicilan"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Tanggal jatuh tempo" rules="required">
		    		<v-autocomplete
		    			class="mt-4"
		    			v-model="form_data.due_date" 
		              	:items="['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']"
		              	label="Tanggal Jatuh Tempo"
		              	name="due_date"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Cicilan per bulan" rules="required|numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="installment"
		    			name="installment"
			    		label="Cicilan Per Bulan"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="!field_state"
			    		:disabled="field_state">
	    			</v-text-field>
	    			<small class="form-text text-muted">Rp @{{ installment ? number_format(installment) : 0 }}</small>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Kredit" rules="numeric|min:0">
		    		<v-text-field
		    			class="mt-4"
		    			v-if="payment_type == 'KPR/KPA'"
		    			v-model="credits"
		    			name="credits"
			    		label="Kredit"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="!field_state"
			    		:disabled="field_state">
	    			</v-text-field>
	    			<small v-if="payment_type == 'KPR/KPA'" class="form-text text-muted">Rp @{{ credits ? number_format(credits) : 0 }}</small>
	    		</validation-provider>

	    		
			    <h3>Data Klien</h3>
	    		<validation-provider v-slot="{ errors }" name="Klien" rules="required">
		    		<v-autocomplete
		    			class="mt-4"
		    			v-model="form_data.client_id" 
		    			@input="setSelectedClient()"
		              	:items="filter_client"
		              	label="Klien"
		              	name="client_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-autocomplete>
	    		</validation-provider>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.client_number"
					    		label="ID Klien"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.client_name"
				    			name="client_name"
					    		label="Nama Klien"
					    		:persistent-hint="true"
					    		:error-messages="errors"
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
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.client_phone_number"
					    		label="Nomor Telepon"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.client_mobile_number"
				    			name="client_name"
					    		label="Nomor Handphone"
					    		:persistent-hint="true"
					    		:error-messages="errors"
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
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.client_email"
					    		label="Email"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.client_address"
					    		label="Alamat Klien"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
			    </v-row>
			    
			    <h3>Data Sales</h3>
	    		<validation-provider v-slot="{ errors }" name="Sales" rules="required">
		    		<v-autocomplete
		    			class="mt-4"
		    			v-model="form_data.sales_id" 
		    			@input="setSelectedSales()"
		              	:items="filter_sales"
		              	label="Sales"
		              	name="sales_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
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
	            	  				<td width="25%">Koordinator Utama</td>
	            	  				<td width="5%">:</td>
	            	  				<td>@{{ data.item.main_coordinator }}</td>
	            	  			</tr>
	            	  			<tr>
	            	  				<td>Koordinator Wilayah</td>
	            	  				<td>:</td>
	            	  				<td>@{{ data.item.regional_coordinator }}</td>
	            	  			</tr>
	            	  			<tr>
	            	  				<td>Sub Agent</td>
	            	  				<td>:</td>
	            	  				<td>@{{ data.item.agency_name }}</td>
	            	  			</tr>
	            	  		</table>
	            	  	</template>
            	  		<v-divider></v-divider>
		            </v-autocomplete>
	    		</validation-provider>
	    		<v-row>
			    	<v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.sales_name"
					    		label="Nama Sales"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.agency_name"
					    		label="Nama Sub Agent"
					    		:persistent-hint="true"
					    		:error-messages="errors"
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
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.main_coordinator"
					    		label="Koordinator Utama"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
			    	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
			    		<validation-provider v-slot="{ errors }" name="" rules="">
				    		<v-text-field
				    			class="mt-4"
				    			v-model="form_data.regional_coordinator"
					    		label="Koordinator Wilayah"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		:readonly="!field_state"
					    		:disabled="field_state">
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
	        		<v-text-field
	    	           v-model="form_data.agent_id"
	    	           v-show=false
	    	           name="agent_id">
	    	        </v-text-field>
	    	        <v-text-field
	    	           v-model="form_data.main_coor_id"
	    	           v-show=false
	    	           name="main_coor_id">
	    	        </v-text-field>
	    	        <v-text-field
	    	           v-model="form_data.regional_coor_id"
	    	           v-show=false
	    	           name="regional_coor_id">
	    	        </v-text-field>
			    </v-row>
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
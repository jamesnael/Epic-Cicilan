<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Schedule Surat Pemesanan Rumah</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
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
				</v-row>
				<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Unit" rules="">
				    		<v-text-field
				    			v-model="form_data.unit_type"
				    			name="unit_type"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Unit"
					    		readonly>
			    			</v-text-field>
			    		</validation-provider>
				    </v-col>
				</v-row>
				<v-row>
    		        <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="">
				    		<v-text-field
				    			v-model="form_data.sales_name"
				    			name="sales_name"
					    		:persistent-hint="true"
					    		:error-messages="errors"
					    		label="Nama Sales"
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
		    		        v-model="menu4"
		    		        :close-on-content-click="false"
		    		        :nudge-right="40"
		    		        transition="scale-transition"
		    		        offset-y
		    		        min-width="290px"
		    		      >
	    		        	<template v-slot:activator="{ on, attrs }">
				    		<validation-provider v-slot="{ errors }" name="Tanggal Cetak" rules="required|min:1">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.print_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		        	hint="* harus diisi"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		            label="Tanggal Cetak"
		    		            v-bind="attrs"
		    		            v-on="on"
		    		            readonly
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="print_date" v-model="form_data.print_date" @input="menu4 = false"></v-date-picker>
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
				    		<validation-provider v-slot="{ errors }" name="Tanggal Kirim" rules="min:1">
		    		        <v-text-field
		    		        	:value="reformatDateTime(form_data.sent_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Kirim"
		    		            v-bind="attrs"
		    		            v-on="on"
		    		            v-if="form_data.print_date_data !== null"
		    		            :readonly="!field_state"
		    		            :error-messages="errors">
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="sent_date" v-model="form_data.sent_date" @input="menu3 = false" :disabled="field_state"></v-date-picker>

			    	</v-col>
			    </v-row>
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
				    		<validation-provider v-slot="{ errors }" name="Tanggal Terima" rules="min:1">
		    		        <v-text-field
					    		:error-messages="errors"
		    		        	:value="reformatDateTime(form_data.received_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
		    		            label="Tanggal Terima"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-if="form_data.sent_date_data !== null"
		    		            v-on="on"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker name="received_date" v-model="form_data.received_date" @input="menu2 = false"></v-date-picker>
			    	</v-col>
			    </v-row>
			    <v-row v-if="form_data.received_date_data !== null">
					<v-col
    		          cols="12"
    		          md="12">
					    <h3 class="mt-4">Approval SPR (Surat Pemesanan Rumah)</h3>
			    		<validation-provider v-slot="{ errors }" name="Approval Status" rules="">
							<v-select
							class="mt-2"
					        v-model="form_data.approval_status"
			                label="Approval Status"
			                :items="['Disetujui', 'Pending']"
			                name="approval_status"
			                :persistent-hint="true"
			                :error-messages="errors"
			                :readonly="field_state">
					      ></v-select>
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
		    	          	@click="cancelSpr()"
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
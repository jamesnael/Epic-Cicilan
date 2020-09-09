<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Kategori reward" rules="required">
		    		<v-select
		    			v-model="form_data.category_reward_id" 
		              	:items="filter_category"
		              	label="Kategori Reward"
		              	name="category_reward_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nama Reward" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.reward_name"
		    			name="reward_name"
			    		label="Nama Reward"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		{{-- <validation-provider v-slot="{ errors }" name="Reedem point" rules="required|numeric">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.redeem_point"
		    			name="redeem_point"
			    		label="Reedem Point"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider> --}}
	    		<v-row align="center" class="mt-4">
			        <v-checkbox
			          hide-details
			          v-model="main_coordinator"
			          class="shrink mr-2 mt-0"
			        ></v-checkbox>
		    		<validation-provider v-slot="{ errors }" name="Reedem point koordinator utama" :rules="{'numeric': true, 'required': main_coordinator}">
				        <v-text-field
					      v-model="form_data.redeem_point_main_coordinator"
				          label="Reedem Point Koordinator Utama"
				          name="redeem_point_main_coordinator"
				          :error-messages="errors"
			    		  :readonly="field_state"
				        >
				        </v-text-field>
					</validation-provider>
				</v-row>
	    		<v-row align="center" class="mt-4">
			        <v-checkbox
				        v-model="regional_coordinator"
			          	hide-details
			          	class="shrink mr-2 mt-0"
			        ></v-checkbox>
		    		<validation-provider v-slot="{ errors }" name="Reedem point koordinator wilayah" :rules="{'numeric': true, 'required': regional_coordinator}">
			        <v-text-field
			          v-model="form_data.redeem_point_regional_coordinator"
			          label="Reedem Point Koordinator Wilayah"
			          name="redeem_point_regional_coordinator"
			          :error-messages="errors"
		    		  :readonly="field_state"
			        >
			        </v-text-field>
					</validation-provider>
			    </v-row>
	    		<v-row align="center" class="mt-4">
			        <v-checkbox
				        v-model="agency"
			          	hide-details
			          	class="shrink mr-2 mt-0"
			        ></v-checkbox>
					<validation-provider v-slot="{ errors }" name="Reedem point agency" :rules="{'numeric': true, 'required': agency}">
				        <v-text-field
				          v-model="form_data.redeem_point_agency"
				          label="Reedem Point Sub Agent"
				          name="redeem_point_agency"
				          :error-messages="errors"
			    		  :readonly="field_state"
				        >
				        </v-text-field>
					</validation-provider>
			    </v-row>
	    		<v-row align="center" class="mt-4">
			        <v-checkbox
				        v-model="sales"
				        hide-details
			          	class="shrink mr-2 mt-0"
			        ></v-checkbox>
					<validation-provider v-slot="{ errors }" name="Reedem point sales" :rules="{'numeric': true, 'required': sales}">
				        <v-text-field
				          v-model="form_data.redeem_point_sales"
				          label="Reedem Point Sales"
				          name="redeem_point_sales"
				          :error-messages="errors"
			    		  :readonly="field_state"
				        >
				        </v-text-field>
					</validation-provider>
			    </v-row>
	    		<validation-provider v-slot="{ errors }" name="Keterangan" rules="">
		    		<v-textarea
		    			class="mt-4"
		    			v-model="form_data.description"
		    			name="description"
			    		label="Deskripsi"
			    		auto-grow
		    			clearable
		    			rows="1"
				      	clear-icon="mdi-close"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-textarea>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Status" rules="required">
		    		<v-select
		    			v-model="form_data.status" 
		              	:items="listStatus"
		              	label="Status"
		              	name="status"
		              	hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
		            ></v-select>
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
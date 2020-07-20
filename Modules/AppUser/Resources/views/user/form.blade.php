<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Nama lengkap" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.full_name"
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
		    			v-model="form_data.email"
		    			name="email"
			    		label="Email"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-if="!slug" v-slot="{ errors }" name="Password" rules="required">
		    		<v-text-field
    		            v-model="form_data.password"
    		            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
    		            :rules="[rules.required, rules.min]"
    		            :type="show1 ? 'text' : 'password'"
    		            hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
    		            name="password"
    		            label="Password"
    		            hint="minimal 8 characters"
    		            counter
    		            @click:append="show1 = !show1"
    		          ></v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Hak akses user" rules="required">
		    		<v-select
		    			v-model="form_data.role_id" 
		              	:items="filter_role"
		              	label="Hak Akses User"
		              	hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Nomor telepon" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.phone_number"
		    			name="phone_number"
			    		label="Nomor Telepon"
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
		    			v-model="form_data.address"
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
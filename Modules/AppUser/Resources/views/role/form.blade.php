<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
		    	<v-card
	              elevation="5"
	              >
	              <v-card-title>
	                Informasi Data User
	              </v-card-title>
	              <v-card-text>
	                <v-row>
	                    <v-col
	                        cols="12"
	                        md="4">
	                        <v-text-field
	                            v-model="form_data.full_name"
	                            label="Nama Lengkap"
	                            :readonly="!field_state"
	                            :disabled="field_state">
	                        </v-text-field>
	                    </v-col>
	                    <v-col
	                        cols="12"
	                        md="4">
	                        <v-text-field
	                            v-model="form_data.email"
	                            label="Email"
	                            :readonly="!field_state"
	                            :disabled="field_state">
	                        </v-text-field>
	                    </v-col>
	                    <v-col
	                        cols="12"
	                        md="4">
	                        <v-text-field
	                            v-model="form_data.phone_number"
	                            label="Nomor HP"
	                            :readonly="!field_state"
	                            :disabled="field_state">
	                        </v-text-field>
	                    </v-col>
	                </v-row>
	                <v-row>
	                    <v-col
	                        cols="12"
	                        md="4">
	                        <v-text-field
	                            v-model="form_data.address"
	                            :readonly="!field_state"
	                            :disabled="field_state"
	                            label="Alamat">
	                        </v-text-field>
	                    </v-col>
	                    <v-col
	                        cols="12"
	                        md="4">
	                        <v-text-field
	                            v-model="form_data.province"
	                            :readonly="!field_state"
	                            :disabled="field_state"
	                            label="Provinsi">
	                        </v-text-field>
	                    </v-col>
	                    <v-col
	                        cols="12"
	                        md="4">
	                        <v-text-field
	                            v-model="form_data.city"
	                            label="Kota"
	                            :readonly="!field_state"
	                            :disabled="field_state">
	                        </v-text-field>
	                    </v-col>
	                </v-row>
	              </v-card-text>
	            </v-card>

	            <v-card
	              class="mt-6"
	              elevation="5"
	              >
	              <v-card-title>
	                Hak Akses User
	              </v-card-title>
	              <v-card-text>
	                <v-row>
	                    <v-col
	                        cols="12"
	                        md="4">
			              	<h4>Hak Akses</h4>
	                    </v-col>
	                    <v-col
	                        cols="12"
	                        md="4">
	                        <div class="my-2 mb-4">
                                <v-btn depressed small color="primary" @click.prevent="selectAll" large>Pilih Semua</v-btn>
                            </div>
                            <v-divider class="my-4"></v-divider>
							<div v-if="refreshCK">
	                            <div v-for="(element, menu) in filter_menu">

	                            	<h3 class="my-4">@{{menu}}</h3>

	                            	<div v-if="element['has_child'] == 'true'">
		                            	<div v-for="(parent, key) in element['submenu']">
		                            		<h4>@{{parent.menu}}</h4>
			                            	<div v-for="(child, key) in parent['routes']">
					                            <v-checkbox
						                            class="mb-4"
						                            v-model="form_data.hak_akses"
						                            :label="child.title"
						                            color="indigo darken-3"
						                            :value="child.uri"
						                            name="hak_akses[]"
						                            hide-details
						                        ></v-checkbox>
			                            	</div>
	                            		</div>
	                            		<v-divider></v-divider>
	                            	</div>
	                            	<div v-else >
		                            	<div v-for="(el, key) in element['routes']">
				                            <v-checkbox
					                            class="mb-4"
					                            v-model="form_data.hak_akses"
					                            :label="el.title"
					                            color="indigo darken-3"
					                            :value="el.uri"
					                            name="hak_akses[]"
					                            hide-details
					                        ></v-checkbox>
		                            	</div>
			                            <v-divider></v-divider>
	                            	</div>
	                            </div>
                            </div>
	                    </v-col>
	                </v-row>
	              </v-card-text>
	            </v-card>

	    		<v-btn
		      		class="mt-4"
		      		outlined 
		      		:disabled="field_state"
    		      	:href="redirectUri">
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
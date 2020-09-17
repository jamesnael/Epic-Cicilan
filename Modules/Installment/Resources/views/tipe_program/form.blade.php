<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Nama tipe program" rules="required|max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.nama_program"
		    			name="nama_program"
			    		label="Nama Tipe Program"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:disabled="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<v-row
	    			class="mt-4">
    		        <v-col
    		          	cols="12"
						md="6">
						<h5>
							Harga Sudah Termasuk
							<v-tooltip
								top
								color="primary">
						      	<template v-slot:activator="{ on, attrs }">
						        	<v-btn
							        	icon
							        	class="float-right"
							        	small
							        	color="primary"
							        	v-on:click="addHargaInclude"
							        	v-bind="attrs"
				        	          	v-on="on">
						        	    <v-icon>mdi-plus</v-icon>
						            </v-btn>
						      	</template>
							    <span>Tambah</span>
						    </v-tooltip>
						</h5>
						<div
							v-for="(el, idx) in form_data.harga_termasuk"
						>
							<v-text-field
								class="mt-3"
					            v-model="form_data.harga_termasuk[idx]"
					            name="harga_termasuk[]"
					            clearable
					            label=""
					            type="text"
					            append-outer-icon="mdi-delete-circle-outline"
					            @click:append-outer="removeHargaInclude(idx)"
					            :disabled="field_state"
							></v-text-field>
						</div>
    		      	</v-col>
    		        <v-col
    		          	cols="12"
    		          	md="6">
    		          	<h5>
	    		          	Harga Tidak Termasuk
	          				<v-tooltip
	          					top
	          					color="primary">
	          			      	<template v-slot:activator="{ on, attrs }">
	          			        	<v-btn
	          				        	icon
	          				        	class="float-right"
	          				        	small
	          				        	color="primary"
	          				        	v-on:click="addHargaExclude"
	          				        	v-bind="attrs"
	          	        	          	v-on="on">
	          			        	    <v-icon>mdi-plus</v-icon>
	          			            </v-btn>
	          			      	</template>
	          				    <span>Tambah</span>
	          			    </v-tooltip>
	    		        </h5>
    		        	<div
    		        		v-for="(el, idx) in form_data.harga_tidak_termasuk"
    		        	>
    		        		<v-text-field
    		        			class="mt-3"
    		                    v-model="form_data.harga_tidak_termasuk[idx]"
    		                    name="harga_tidak_termasuk[]"
    		                    clearable
    		                    label=""
    		                    type="text"
    		                    append-outer-icon="mdi-delete-circle-outline"
    		                    @click:append-outer="removeHargaExclude(idx)"
    		                    :disabled="field_state"
    		        		></v-text-field>
    		        	</div>
    		      	</v-col>
	    		</v-row>
	    		<validation-provider v-slot="{ errors }" name="Gimmick" rules="max:255">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.gimmick"
		    			name="gimmick"
			    		label="Gimmick"
			    		:persistent-hint="true"
			    		:counter="255"
			    		:error-messages="errors"
			    		:disabled="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<v-textarea
	    			class="mt-4"
	    			v-model="form_data.keterangan"
	    			name="keterangan"
		    		label="Keterangan"
		    		auto-grow
	    			clearable
	    			rows="1"
			      	clear-icon="mdi-close"
		    		:disabled="field_state">
    			</v-textarea>
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
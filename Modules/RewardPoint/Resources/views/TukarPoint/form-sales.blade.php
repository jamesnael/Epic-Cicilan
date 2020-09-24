<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Data Tukar Point Sales</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Level" rules="">
				   <v-text-field
				    	v-model="sales_level"
				    	label="level"
				        name="level"
				        v-show=""
					    :error-messages="errors"
	            	></v-text-field>
			    </validation-provider>
			  	<v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">		
		    		<validation-provider v-slot="{ errors }" name="Nama Sales" rules="required">
		    		<v-autocomplete
		    			class="mt-4"
		    			v-model="form_data.user_name" 
		    			@input="setSelectedSales()"
		              	:items="filter_sales"
		              	label="Nama Sales"
		              	name="user_name"
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
	            	  				<td width="25%">Sub Agent</td>
	            	  				<td width="25%">:</td>
	            	  				<td>@{{ data.item.agency_name }}</td>
	            	  			</tr>	
	            	  		</table>
	            	  	</template>
            	  		<v-divider></v-divider>
		            </v-autocomplete>
	    		</validation-provider>
				
			    </v-row>
			  	
			    <h3 class="mt-4"
			    	v-if="form_data.user_name !== ''">Jumlah Point</h3>
			    
			  	<v-row v-if="form_data.user_name !== ''">
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Total Point" rules="">
				    		<v-text-field
			    			v-model="form_data.total_point"
			    			label="Total Point"
			              	name="total_point"
				    		:error-messages="errors"
				    		:readonly="!field_state"
				    		:disabled="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			   
			    <v-row v-if="form_data.user_name !== ''">
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Point Yang Bisa Ditukar" rules="">
				    		<v-text-field
			    			v-model="form_data.sisa_point"
			              	label="Point Yang Bisa Ditukar"
			              	name="exchange_point"
				    		:error-messages="errors"
				    		:readonly="!field_state"
				    		:disabled="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>
			    <h3 class="mt-4"
			    	v-if="form_data.user_name !== ''">Pilih Reward</h3>


			    <v-row v-if="form_data.user_name !== ''">
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Kategori reward" rules="required" 
		    			 >
		    		<v-autocomplete
		    			v-model="form_data.category_reward_id"
		              	:items="filter_category"
		              	label="Kategori Reward"
		              	name="category_reward_id"
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
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Nama Reward Point" rules="required" v-if="form_data.user_name !== ''" >
				    		<v-autocomplete
			    			v-model="form_data.reward_points"
			    			@input="setRedeemPointSales()"
			    			:items="computedRewardSales" 
			    			label="Nama Reward Point"
			    			name="reward_point_id"
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
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Redeem Point" rules="required" v-if="form_data.user_name !== '' ">
				    		<v-text-field
			    			v-model="form_data.redeem_point_sales" 
			    			label="Redeem Point"
			    			name="redeem_point"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="!field_state"
				    		:disabled="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    		</v-col>
			    </v-row>
			    <v-btn
		      		class="mt-4"
		      		outlined 
		      		:disabled="field_state"
		      		:href="redirectUri"
		      		>
    		      	Kembali
    		    </v-btn>
    		     <v-dialog
			      v-model="dialog2"
			      max-width="290"
			      v-if="form_data.sisa_point < form_data.redeem_point_sales"
			    >
			    	<template v-slot:activator="{ on, attrs }">
				        <v-btn
				          color="primary"
				          class="mt-4"
				          dark
				          v-bind="attrs"
				          v-on="on"			    		
				        >
				          Submit
				        </v-btn>
			      	</template>
				      <v-card>
				        <v-card-title class="headline">Warning</v-card-title>

				        <v-card-text>
				        	Maaf point anda tidak cukup untuk menukarkan reward ini.
				        </v-card-text>

				        <v-card-actions>
				          <v-spacer></v-spacer>

				          <v-btn
				            color="blue darken-1"
				            text
				            @click="dialog2 = false,form_data.reward_points = null,form_data.redeem_point_sales = '-'"

				          >
				            Tutup
				          </v-btn>
				        </v-card-actions>
				      </v-card>
				    </v-dialog>
	    		
				    <v-dialog
				    	v-model="dialog1"
				    	persistent
				    	max-width="500px"
				    	v-if="form_data.sisa_point >= form_data.redeem_point_sales"
				    >
					    <template v-slot:activator="{ on, attrs }">
					        <v-btn
					          color="primary"
					          class="mt-4"
					          dark
					          v-bind="attrs"
					          v-on="on"
					          @click="submit"
				    		
					        >
					          Submit
					        </v-btn>
					    </template>
				    	<v-card>
				    		<v-card-title>
				  				<span class="headline"></span>
							</v-card-title>
							<v-card-text>
							    <v-row align="center" justify="center">
									<v-icon size="100" color="green darken-2">mdi-bell-check-outline</v-icon>
							    </v-row>
							    <v-row align="center" justify="center" class="mt-2">
									<p class="text-md-h6 text-xs-h6 black--text text-center">
										Tukar Point Berhasil Dilakukan
									</p>
								</v-row>
								<p class="text-center mt-2">Apakah anda ingin menukar point lagi ?</p>
								<br>
							    <v-row align="center" justify="center">
									<v-btn color="grey lighten-4" class="black--text mx-2" :href="redirectUri">Tidak</v-btn>
							        <v-btn color="blue darken-2" class="white--text mx-2" :href="createUri">Ya</v-btn>
								</v-row>
							</v-card-text>
				    	</v-card>
				    </v-dialog>
				</template>
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
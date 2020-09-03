<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Data Tukar Point</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		</v-row>
	    		<v-row>
    		      <v-col
    		          	cols="12"
    		          	md="12">		
		    		<validation-provider v-slot="{ errors }" name="Level" rules="required">
		    			<v-select
			    			v-model="form_data.level" 
			              	:items="['Sales','Agent','Korwil','Korut']"
			              	label="Level"
			              	name="level"
			              	v-on="on"
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
		    		<validation-provider v-slot="{ errors }" name="Username" rules="required" v-if="form_data.level == 'Sales'">
		    		<v-select
		    			class="mt-4"
		    			v-model="form_data.user_name" 
		    			@input="setSelectedSales()"
		              	:items="filter_sales"
		              	label="Sales"
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
	            	  			<tr>
	            	  				<td width="25%">Total Point</td>
	            	  				<td width="25%">:</td>
	            	  				<td>@{{ data.item.total_point }}</td>
	            	  			</tr>
	            	  		</table>
	            	  	</template>
            	  		<v-divider></v-divider>
		            </v-select>
	    		</validation-provider>
					<validation-provider v-slot="{ errors }" name="Nama Agent" rules="required" v-if="form_data.level == 'Agent'">
		    			<v-select
			    			v-model="form_data.user_name"
		    				@input="setSelectedSubAgent()" 
			              	label="Nama Agent"
			              	:items="filter_agency"
			              	name="user_name"
			              	v-on="on"
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
	            	  				<td>Agent</td>
	            	  				<td>:</td>
	            	  				<td>@{{ data.item.text }}</td>
	            	  			</tr>
	            	  			<tr>
	            	  				<td width="25%">Koordinator Wilayah</td>
	            	  				<td width="25%">:</td>
	            	  				<td>@{{ data.item.regional }}</td>
	            	  			</tr>
	            	  			<tr>
	            	  				<td width="25%">Total Point</td>
	            	  				<td width="25%">:</td>
	            	  				<td>@{{ data.item.total_point }}</td>
	            	  			</tr>
	            	  		</table>
	            	  	</template>
            	  		<v-divider></v-divider>

			            	</v-select>
					</validation-provider>
					<validation-provider v-slot="{ errors }" name="Nama Korwil" rules="required" v-if="form_data.level == 'Korwil'">
		    			<v-select
			    			v-model="form_data.user_name" 
			              	label="Nama Korwil"
			              	@input="setSelectedKorwil()" 
			              	:items="filter_korwil"
			              	name="user_name"
			              	v-on="on"
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
	            	  				<td>Koordinator Wilayah</td>
	            	  				<td>:</td>
	            	  				<td>@{{ data.item.text }}</td>
	            	  			</tr>
	            	  			<tr>
	            	  				<td width="25%">Koordinator Utama</td>
	            	  				<td width="25%">:</td>
	            	  				<td>@{{ data.item.maincoor }}</td>
	            	  			</tr>
	            	  			<tr>
	            	  				<td width="25%">Total Point</td>
	            	  				<td width="25%">:</td>
	            	  				<td>@{{ data.item.total_point }}</td>
	            	  			</tr>
	            	  		</table>
	            	  	</template>
            	  		<v-divider></v-divider>

			            	</v-select>
					</validation-provider>
					<validation-provider v-slot="{ errors }" name="Nama Korut" rules="required" v-if="form_data.level == 'Korut'">
		    			<v-select
			    			v-model="form_data.user_name" 
			              	label="Nama Korut"
			              	:items="filter_korut"
			              	name="user_name"
			              	v-on="on"
			              	:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-select>
					</validation-provider>
			    	</v-col>
			    </v-row>
			  	
			    <h3 class="mt-4">Tukar Point</h3>

			    
			  	<v-row>
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

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Point Yang Bisa Ditukar" rules="">
				    		<v-text-field
			    			v-model="form_data.exchange_point"
			              	label="Point Yang Bisa Ditukar"
			              	name="exchange_point"
				    		:error-messages="errors"
				    		:readonly="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    	</v-col>
			    </v-row>

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Kategori reward" rules="required" 
		    			 >
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
			    	</v-col>
			    </v-row>

			    <v-row>
    		       <v-col
    		          	cols="12"
    		          	md="12">
			    		<validation-provider v-slot="{ errors }" name="Nama Reward Point" rules="" >
				    		<v-select
			    			v-model="form_data.reward_points"
			    			@input="setRewardPoint()"
			    			:items="computedCategoryName" 
			    			label="Nama Reward Point"
			    			name="reward_point_id"
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
			    		<validation-provider v-slot="{ errors }" name="Redeem Point" rules="" v-if="form_data.level == 'Sales'">
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
			    		<validation-provider v-slot="{ errors }" name="Redeem Point" rules="" v-if="form_data.level == 'Agent'">
				    		<v-text-field
			    			v-model="form_data.redeem_point_agency" 
			    			label="Redeem Point"
			    			name="redeem_point"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="!field_state"
				    		:disabled="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    		<validation-provider v-slot="{ errors }" name="Redeem Point" rules="" v-if="form_data.level == 'Korwil'"> 
				    		<v-text-field
			    			v-model="form_data.redeem_point_regional_coordinator" 
			    			label="Redeem Point"
			    			name="redeem_point"
				    		:persistent-hint="true"
				    		:error-messages="errors"
				    		:readonly="!field_state"
				    		:disabled="field_state"
			            	></v-text-field>
			    		</validation-provider>
			    		<validation-provider v-slot="{ errors }" name="Redeem Point" rules="" v-if="form_data.level == 'Korut'">
				    		<v-text-field
			    			v-model="form_data.redeem_point_main_coordinator" 
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
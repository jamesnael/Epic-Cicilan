<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
    		<h3>Input Schedule SPR</h3>
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
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
		    		        	:value="computedDateFormattedMomentjs"
		    		        	hint="* harus diisi"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		            v-model="form_data.print_date"
		    		            label="Tanggal Cetak"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker v-model="form_data.print_date" @input="menu4 = false"></v-date-picker>
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
				    		<validation-provider v-slot="{ errors }" name="Tanggal Kirim" rules="required|min:1">
		    		        <v-text-field
		    		        	:value="computedDateFormattedMomentjs"
		    		        	hint="* harus diisi"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		            v-model="form_data.send_date"
		    		            label="Tanggal Kirim"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker v-model="form_data.send_date" @input="menu3 = false"></v-date-picker>
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
				    		<validation-provider v-slot="{ errors }" name="Tanggal Terima" rules="required|min:1">
		    		        <v-text-field
		    		        	:value="computedDateFormattedMomentjs"
		    		        	hint="* harus diisi"
		    		        	:persistent-hint="true"
					    		:error-messages="errors"
		    		            v-model="form_data.get_date"
		    		            label="Tanggal Terima"
		    		            readonly
		    		            v-bind="attrs"
		    		            v-on="on"
		    		        ></v-text-field>
				    		</validation-provider>
	    		        	</template>
	    		        	<v-date-picker v-model="form_data.get_date" @input="menu2 = false"></v-date-picker>
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
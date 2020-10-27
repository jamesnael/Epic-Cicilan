@extends('app')

@section('content')

	@include('components.breadcrumbs')
	<import-form inline-template
		uri="{{ route('import-booking') }}"
		redirect-uri="{{ route('booking.index') }}"
	>
		<v-card
		  elevation="2"
		>
			<v-container fluid>
			    <v-card flat>
			    	<validation-observer ref="observer" v-slot="{ validate, reset }">
				    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
				    		<h3>Import Data Booking</h3>
				    		<v-row>
			    		        <v-col
			    		          cols="12"
			    		          md="12">
					    			<validation-provider v-slot="{ errors }" name="file import data booking" rules="image">
	    					    		<v-file-input
	    					    		    hint="* harus diisi"
	    						    		:persistent-hint="true"
	    					    		    show-size
	    					    		    label="File Import Data Booking"
	    					    		    name="file_import"
	    					    		  ></v-file-input>
	    				    		</validation-provider>
						    	</v-col>
						    </v-row>
				    		<v-btn
					    		class="mt-4 mr-4 white--text"
					    		color="primary"
				    		    elevation="5"
					    		:disabled="field_state"
					    		:loading="field_state"
					    		@click="submit">
					    		Import
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
			    		      	:href="redirectUri">
			    		      	Kembali
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
		</v-card>
	</import-form>
@endsection

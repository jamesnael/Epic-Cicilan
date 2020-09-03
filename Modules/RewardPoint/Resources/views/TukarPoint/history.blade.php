@extends('app')

@section('content')

	@include('components.breadcrumbs')
	<tukarpoint-history inline-template
		redirect-uri="{{ route('tukar-point.index') }}"
	>
		<v-card
		    class="mx-auto"
		    outlined
		  >
			    <v-list-item three-line>
			      <v-list-item-content>
			        <v-list-item-title class="headline mb-1">History</v-list-item-title>
			        <v-list-item-subtitle>Data Riwayat Tukar Point</v-list-item-subtitle>
			      </v-list-item-content>
			    </v-list-item>
				<v-container fluid>
				    <v-data-table
					    :headers="headers"
					    :items="desserts"
				    	:items-per-page="10"
				   		class="elevation-1"
				  	></v-data-table>
				</v-container>
			    <v-card-actions>
			      <v-btn
		      		class="mt-4"
		      		outlined
		      		:href="redirectUri">
			      	Kembali
			      </v-btn>
			    </v-card-actions>
		  </v-card>
	</tukarpoint-history>
 
@endsection

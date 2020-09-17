@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<booking-form inline-template
	uri="{{ route('booking.store') }}"
	redirect-uri="{{ route('booking.index') }}"
	:filter_sales='@json($sales)'
	:filter_client='@json($client)'
	:filter_unit_type='@json($unit)'
	:filter_tipe_programs='@json($tipe_programs)'>
		@include('installment::booking.form')
	</booking-form>

@endsection

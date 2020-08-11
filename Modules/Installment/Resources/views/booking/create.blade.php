@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<booking-form inline-template
	uri="{{ route('booking.store') }}"
	redirect-uri="{{ route('booking.index') }}"
	:filter_unit='@json($unit)'
	:filter_client='@json($client)'>
		@include('installment::booking.form')
	</booking-form>

@endsection

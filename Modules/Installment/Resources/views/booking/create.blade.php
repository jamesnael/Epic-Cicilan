@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<booking-form inline-template
	uri="{{ route('booking.store') }}"
	redirect-uri="{{ route('booking.index') }}">
		@include('installment::booking.form')
	</booking-form>

@endsection

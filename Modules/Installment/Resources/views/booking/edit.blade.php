@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<booking-form inline-template
	uri="{{ route('booking.update', [$data->slug]) }}"
	redirect-uri="{{ route('booking.index') }}"
	data-uri="{{ route('booking.data', [$data->slug]) }}">
		@include('installment::booking.form')
	</booking-form>

@endsection

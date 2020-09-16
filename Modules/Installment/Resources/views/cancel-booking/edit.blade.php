@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<cancel-booking inline-template
	uri="{{ route('cancel-booking.update', [$data->slug]) }}"
	redirect-uri="{{ route('cancel-booking.index') }}"
	data-uri="{{ route('cancel-booking.data', [$data->slug]) }}"
	:filter_sales='@json($sales)'
	:filter_client='@json($client)'
	:filter_unit_type='@json($unit)'>
		@include('installment::cancel-booking.form')
	</cancel-booking>

@endsection

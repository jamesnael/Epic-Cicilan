@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<paymenttype-form inline-template
	uri="{{ route('PaymentType.store') }}"
	redirect-uri="{{ route('PaymentType.index') }}"
	:filter_sales='@json($sales)'
	:filter_client='@json($client)'>
		@include('installment::paymenttype.form')
	</paymenttype-form>

@endsection

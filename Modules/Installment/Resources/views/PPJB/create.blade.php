@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<booking-form inline-template
	uri="{{ route('PPJB.store') }}"
	redirect-uri="{{ route('PPJB.index') }}"
	:filter_sales='@json($sales)'
	:filter_client='@json($client)'>
		@include('installment::PPJB.form')
	</booking-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<ajb-form inline-template
	uri="{{ route('ajb.store') }}"
	redirect-uri="{{ route('ajb.index') }}"
	:filter_sales='@json($sales)'
	:filter_client='@json($client)'>
		@include('installment::ajb.form')
	</ajb-form>

@endsection

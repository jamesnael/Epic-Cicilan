@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<sales-form inline-template
	uri="{{ route('sales.store') }}"
	redirect-uri="{{ route('sales.index') }}"
	:filter_agency='@json($agency)'
	:filter_main_coordinator='@json($main_coordinator)'
	:filter_regional_coordinator='@json($regional_coordinator)'
	:filter_sales_commission='@json($sales_commission)'>
		@include('salesagent::sales.form')
	</sales-form>

@endsection

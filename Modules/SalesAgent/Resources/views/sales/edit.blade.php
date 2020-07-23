@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<sales-form inline-template
	uri="{{ route('sales.update', [$data->slug]) }}"
	redirect-uri="{{ route('sales.index') }}"
	data-uri="{{ route('sales.data', [$data->slug]) }}"
	:filter_agency='@json($agency)'
	:filter_main_coordinator='@json($main_coordinator)'
	:filter_regional_coordinator='@json($regional_coordinator)'
	:filter_regional_coordinator_commission='@json($regional_coordinator_commission)'
	:filter_main_coordinator_commission='@json($main_coordinator_commission)'
	:filter_agency_commission='@json($agency_commission)'
	:filter_sales_commission='@json($sales_commission)'>
		@include('salesagent::sales.form')
	</sales-form>

@endsection

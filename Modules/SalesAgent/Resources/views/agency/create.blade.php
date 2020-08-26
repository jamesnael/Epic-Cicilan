@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<salesagent-agency-form inline-template
	uri="{{ route('agencies.store') }}"
	redirect-uri="{{ route('agencies.index') }}"
	:filter_regional_coordinator='@json($regional_coordinator)'
	:filter_agency_commission='@json($agency_commission)'>
		@include('salesagent::agency.form')
	</salesagent-agency-form>

@endsection

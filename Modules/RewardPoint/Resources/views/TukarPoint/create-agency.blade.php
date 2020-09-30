@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tukarpoint-form inline-template
	uri="{{ route('tukar-point.store') }}"
	redirect-uri="{{ route('tukar-point.index') }}"
	create-uri="{{ route('tukar-point-agency.create') }}"
	:filter_category='@json($category)'

	:filter_reward_sales='@json($reward_name_sales)'
	:filter_reward_agency='@json($reward_name_agency)'
	:filter_reward_regional_coordinator='@json($reward_name_regional_coordinator)'
	:filter_reward_main_coordinator='@json($reward_name_main_coordinator)'

	:filter_sales='@json($sales_name)'
	:filter_agency='@json($agency_name)'
	:filter_korut='@json($korut_name)'
	:filter_korwil='@json($korwil_name)'
	>
		@include('rewardpoint::TukarPoint.form-agency')
	</tukarpoint-form>
 	
@endsection

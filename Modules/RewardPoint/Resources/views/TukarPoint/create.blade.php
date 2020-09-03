@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tukarpoint-form inline-template
	uri="{{ route('tukar-point.store') }}"
	redirect-uri="{{ route('tukar-point.index') }}"
	:filter_category='@json($category)'
	:filter_reward='@json($reward_name)'
	:filter_sales='@json($sales_name)'
	:filter_agency='@json($agency_name)'
	:filter_korut='@json($korut_name)'
	:filter_korwil='@json($korwil_name)'
	>
		@include('rewardpoint::TukarPoint.form')
	</tukarpoint-form>
 	
@endsection

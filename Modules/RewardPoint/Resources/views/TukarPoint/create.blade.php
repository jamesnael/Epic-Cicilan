@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tukarpoint-form inline-template
	uri="{{ route('tukar-point.store') }}"
	redirect-uri="{{ route('tukar-point.index') }}"
	:filter_category='@json($category)'
	:filter_reward='@json($reward_name)'
	>
		@include('rewardpoint::TukarPoint.form')
	</tukarpoint-form>
 	
@endsection

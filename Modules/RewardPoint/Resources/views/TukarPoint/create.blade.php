@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tukarpoint-form inline-template
	uri="{{ route('tukar-point.store') }}"
	redirect-uri="{{ route('tukar-point.index') }}">
		@include('rewardpoint::TukarPoint.form')
	</tukarpoint-form>
 	
@endsection

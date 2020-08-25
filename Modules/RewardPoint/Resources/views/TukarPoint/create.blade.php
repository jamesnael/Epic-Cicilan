@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tukarpoint-form inline-template
	uri="{{ route('TukarPoint.store') }}"
	redirect-uri="{{ route('TukarPoint.index') }}">
		@include('rewardpoint::TukarPoint.form')
	</tukarpoint-form>
 	
@endsection

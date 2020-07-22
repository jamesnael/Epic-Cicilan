@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<regional-coordinator-form inline-template
	uri="{{ route('regional-coordinator.store') }}"
	redirect-uri="{{ route('regional-coordinator.index') }}"
	:filter_main_coordinator='@json($main_coordinator)'>
		@include('salesagent::regional-coordinator.form')
	</regional-coordinator-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<regional-coordinator-form inline-template
	uri="{{ route('regional-coordinator.store') }}"
	redirect-uri="{{ route('regional-coordinator.index') }}">
		@include('salesagent::sales.regional-coordinator.form')
	</regional-coordinator-form>

@endsection

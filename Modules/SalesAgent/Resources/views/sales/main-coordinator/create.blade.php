@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<main-coordinator-form inline-template
	uri="{{ route('main-coordinator.store') }}"
	redirect-uri="{{ route('main-coordinator.index') }}">
		@include('salesagent::sales.main-coordinator.form')
	</main-coordinator-form>

@endsection

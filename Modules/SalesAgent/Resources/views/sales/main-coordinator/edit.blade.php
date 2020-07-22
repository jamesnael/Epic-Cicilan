@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<main-coordinator-form inline-template
	uri="{{ route('main-coordinator.update', [$data->slug]) }}"
	redirect-uri="{{ route('main-coordinator.index') }}"
	data-uri="{{ route('main-coordinator.data', [$data->slug]) }}">
		@include('salesagent::sales.main-coordinator.form')
	</main-coordinator-form>

@endsection

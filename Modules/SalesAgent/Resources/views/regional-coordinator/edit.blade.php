@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<regional-coordinator-form inline-template
	uri="{{ route('regional-coordinator.update', [$data->slug]) }}"
	redirect-uri="{{ route('regional-coordinator.index') }}"
	data-uri="{{ route('regional-coordinator.data', [$data->slug]) }}">
		@include('salesagent::regional-coordinator.form')
	</regional-coordinator-form>

@endsection

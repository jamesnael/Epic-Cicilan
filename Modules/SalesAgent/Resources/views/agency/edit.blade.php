@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<salesagent-agency-form inline-template
	uri="{{ route('agencies.update', [$data->slug]) }}"
	redirect-uri="{{ route('agencies.index') }}"
	data-uri="{{ route('agencies.data', [$data->slug]) }}"
	:filter_regional_coordinator='@json($regional_coordinator)'>
		@include('salesagent::agency.form')
	</salesagent-agency-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<salesagent-agency-form inline-template
	uri="{{ route('agencies.store') }}"
	redirect-uri="{{ route('agencies.index') }}">
		@include('salesagent::agency.form')
	</salesagent-agency-form>

@endsection

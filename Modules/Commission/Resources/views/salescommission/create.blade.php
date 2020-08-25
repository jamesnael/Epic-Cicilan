@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<salescommission-form inline-template
	uri="{{ route('salescommission.store') }}"
	redirect-uri="{{ route('salescommission.index') }}">
		@include('commission::salescommission.form')
	</salescommission-form>

@endsection

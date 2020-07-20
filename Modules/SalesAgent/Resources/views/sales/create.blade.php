@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<sales-form inline-template
	uri="{{ route('sales.store') }}"
	redirect-uri="{{ route('sales.index') }}"
	:filter_user='@json($user)'
	:filter_agency='@json($agency)'
	slug="">
		@include('salesagent::sales.form')
	</sales-form>

@endsection

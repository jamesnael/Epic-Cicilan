@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<sales-form inline-template
	uri="{{ route('sales.store') }}"
	redirect-uri="{{ route('sales.index') }}"
	:filter_agency='@json($agency)'>
		@include('salesagent::sales.form')
	</sales-form>

@endsection

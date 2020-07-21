@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<sales-form inline-template
	uri="{{ route('sales.update', [$data->slug]) }}"
	redirect-uri="{{ route('sales.index') }}"
	data-uri="{{ route('sales.data', [$data->slug]) }}"
	:filter_agency='@json($agency)'>
		@include('salesagent::sales.form')
	</sales-form>

@endsection

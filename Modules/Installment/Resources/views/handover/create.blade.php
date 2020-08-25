@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<handover-form inline-template
	uri="{{ route('handover.store') }}"
	redirect-uri="{{ route('handover.index') }}"
	:filter_sales='@json($sales)'
	:filter_client='@json($client)'>
		@include('installment::handover.form')
	</handover-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<akad-form inline-template
	uri="{{ route('akad.store') }}"
	redirect-uri="{{ route('akad.index') }}"
	:filter_sales='@json($sales)'
	:filter_client='@json($client)'>
		@include('installment::akad.form')
	</akad-form>

@endsection

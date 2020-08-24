@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<commission-form inline-template
	uri="{{ route('commission.store') }}"
	redirect-uri="{{ route('commission.index') }}">
		@include('commission::commission.form')
	</commission-form>

@endsection

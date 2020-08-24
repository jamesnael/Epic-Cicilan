@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<client-form inline-template
	uri="{{ route('client.store') }}"
	redirect-uri="{{ route('client.index') }}">
		@include('installment::client.form')
	</client-form>

@endsection

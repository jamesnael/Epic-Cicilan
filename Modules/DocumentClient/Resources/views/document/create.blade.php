@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<document-form inline-template
	uri="{{ route('document.store') }}"
	redirect-uri="{{ route('document.index') }}"
	:filter_client='@json($client)'>
		@include('documentclient::document.form')
	</document-form>

@endsection

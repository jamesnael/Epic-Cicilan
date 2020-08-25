@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<document-form inline-template
	uri="{{ route('document.update', [$data->slug]) }}"
	redirect-uri="{{ route('document.index') }}"
	data-uri="{{ route('document.data', [$data->slug]) }}"
	:filter_client='@json($client)'>
		@include('documentclient::document.form')
	</document-form>

@endsection

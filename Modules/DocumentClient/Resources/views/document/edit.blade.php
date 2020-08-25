@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<document-form inline-template
	slug="{{ $data->slug }}"
	uri="{{ route('document.update', [$data->slug]) }}"
	redirect-uri="{{ route('document.index') }}"
	data-uri="{{ route('document.data', [$data->slug]) }}">
		@include('documentclient::document.form')
	</document-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<document-admin-form inline-template
	slug="{{ $data->slug }}"
	uri="{{ route('document-admin.update', [$data->slug]) }}"
	redirect-uri="{{ route('document-admin.index') }}"
	data-uri="{{ route('document-admin.data', [$data->slug]) }}">
		@include('documentclient::document-admin.form')
	</document-admin-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<document-admin-form inline-template
	uri="{{ route('document-admin.store') }}"
	redirect-uri="{{ route('document-admin.index') }}">
		@include('documentclient::document-admin.form')
	</document-admin-form>

@endsection

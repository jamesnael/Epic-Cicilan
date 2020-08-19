@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<document-admin-form inline-template
	uri="{{ route('document-admin.update', [$data->slug]) }}"
	redirect-uri="{{ route('document-admin.index') }}"
	data-uri="{{ route('document-admin.data', [$data->slug]) }}"
	:filter_client='@json($client)'>
		@include('installment::document-admin.form')
	</document-admin-form>

@endsection

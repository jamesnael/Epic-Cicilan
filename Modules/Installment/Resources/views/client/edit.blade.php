@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<client-form inline-template
	uri="{{ route('client.update', [$data->slug]) }}"
	redirect-uri="{{ route('client.index') }}"
	data-uri="{{ route('client.data', [$data->slug]) }}">
		@include('installment::client.form')
	</client-form>

@endsection

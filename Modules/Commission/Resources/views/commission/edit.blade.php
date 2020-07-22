@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<commission-form inline-template
	uri="{{ route('commission.update', [$data->slug]) }}"
	redirect-uri="{{ route('commission.index') }}"
	data-uri="{{ route('commission.data', [$data->slug]) }}">
		@include('commission::commission.form')
	</commission-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<ajb-form inline-template
	slug="{{$data->slug}}"
	uri="{{ route('ajb.update', [$data->slug]) }}"
	redirect-uri="{{ route('ajb.index') }}"
	data-uri="{{ route('ajb.data', [$data->slug]) }}">
		@include('installment::ajb.form')
	</ajb-form>

@endsection

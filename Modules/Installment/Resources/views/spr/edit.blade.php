@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<spr-form inline-template
	uri="{{ route('spr.update', [$data->slug]) }}"
	redirect-uri="{{ route('spr.index') }}"
	data-uri="{{ route('spr.data', [$data->slug]) }}">
		@include('installment::spr.form')
	</spr-form>

@endsection

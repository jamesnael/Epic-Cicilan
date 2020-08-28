@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<ppjb-form inline-template
	uri="{{ route('PPJB.update', [$data->slug]) }}"
	redirect-uri="{{ route('PPJB.index') }}"
	data-uri="{{ route('PPJB.data', [$data->slug]) }}">
		@include('installment::PPJB.form')
	</ppjb-form>

@endsection

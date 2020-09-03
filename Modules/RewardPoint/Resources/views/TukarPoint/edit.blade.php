@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tukarpoint-form inline-template
	uri="{{ route('tukar-point.update', [$data->slug]) }}"
	redirect-uri="{{ route('tukar-point.index') }}"
	data-uri="{{ route('tukar-point.data', [$data->slug]) }}">
		@include('installment::tukarpoint.form')
	</tukarpoint-form>

@endsection

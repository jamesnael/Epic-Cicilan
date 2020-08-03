@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<unit-form inline-template
	uri="{{ route('unit.update', [$data->slug]) }}"
	redirect-uri="{{ route('unit.index') }}"
	data-uri="{{ route('unit.data', [$data->slug]) }}">
		@include('installment::unit.form')
	</unit-form>

@endsection

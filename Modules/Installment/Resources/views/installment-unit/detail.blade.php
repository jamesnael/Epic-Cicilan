@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<installment-unit-form inline-template
	uri="{{ route('installment-unit.update', [$data->slug]) }}"
	redirect-uri="{{ route('installment-unit.index') }}"
	data-uri="{{ route('installment-unit.data', [$data->slug]) }}">
		@include('installment-unit::installment-unit.form')
	</installment-unit-form>

@endsection

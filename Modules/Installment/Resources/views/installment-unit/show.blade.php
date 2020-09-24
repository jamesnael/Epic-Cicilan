@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<installment-unit-form inline-template
	uri="{{ route('installment-unit.update', [$data->slug]) }}"
	redirect-uri="{{ route('installment-unit.index') }}"
	:filter_payment_method='@json($payment_method)'
	data-uri="{{ route('installment-unit.data', [$data->slug]) }}">
		@include('installment::installment-unit.form-detail')
	</installment-unit-form>

@endsection

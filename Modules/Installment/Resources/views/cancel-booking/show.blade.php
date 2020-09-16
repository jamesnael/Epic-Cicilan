@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<installment-form inline-template
	uri="{{ route('installment.update', [$data->slug]) }}"
	redirect-uri="{{ route('installment.index') }}"
	data-uri="{{ route('installment.data', [$data->slug]) }}">
		@include('installment::installment.form')
	</installment-form>

@endsection

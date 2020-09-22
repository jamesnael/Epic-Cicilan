@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<report-form inline-template
	uri="{{ route('report.update', [$data->slug]) }}"
	redirect-uri="{{ route('report.index') }}"
	data-uri="{{ route('report.data', [$data->slug]) }}">
		@include('installment::report.form')
	</report-form>

@endsection

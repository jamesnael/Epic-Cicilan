@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<handover-form inline-template
	uri="{{ route('handover.update', [$data->slug]) }}"
	redirect-uri="{{ route('handover.index') }}"
	data-uri="{{ route('handover.data', [$data->slug]) }}">
		@include('installment::handover.form')
	</handover-form>

@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<akad-form inline-template
	uri="{{ route('akad.update', [$data->slug]) }}"
	redirect-uri="{{ route('akad.index') }}"
	data-uri="{{ route('akad.data', [$data->slug]) }}">
		@include('installment::akad.form')
	</akad-form>

@endsection

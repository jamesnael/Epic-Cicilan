@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<salescommission-form inline-template
	uri="{{ route('salescommission.update', [$data->slug]) }}"
	redirect-uri="{{ route('salescommission.index') }}"
	data-uri="{{ route('salescommission.data', [$data->slug]) }}"
	pph21="{{$pph_21}}">
		@include('commission::salescommission.form')
	</salescommission-form>

@endsection

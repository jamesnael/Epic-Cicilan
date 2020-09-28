@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<cluster-form inline-template
	uri="{{ route('cluster.update', [$data->slug]) }}"
	redirect-uri="{{ route('cluster.index') }}"
	data-uri="{{ route('cluster.data', [$data->slug]) }}">
		@include('installment::Cluster.form')
	</cluster-form>

@endsection

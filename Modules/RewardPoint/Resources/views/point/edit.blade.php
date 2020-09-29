@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<point-form inline-template
	uri="{{ route('point.update', [$data->slug]) }}"
	redirect-uri="{{ route('point.index') }}"
	data-uri="{{ route('point.data', [$data->slug]) }}"
	:filter_cluster='@json($cluster_name)'>
		@include('rewardpoint::point.form')
	</point-form>

@endsection

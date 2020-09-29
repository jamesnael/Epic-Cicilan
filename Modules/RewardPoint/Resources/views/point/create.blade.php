@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<point-form inline-template
	uri="{{ route('point.store') }}"
	redirect-uri="{{ route('point.index') }}"
	:filter_cluster='@json($cluster_name)'>
	@include('rewardpoint::point.form')
	</point-form>

@endsection

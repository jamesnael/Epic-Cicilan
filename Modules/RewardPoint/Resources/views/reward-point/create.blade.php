@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<reward-point-form inline-template
	uri="{{ route('reward-point.store') }}"
	redirect-uri="{{ route('reward-point.index') }}">
		@include('rewardpoint::reward-point.form')
	</reward-point-form>

@endsection

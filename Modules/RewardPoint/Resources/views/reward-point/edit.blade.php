@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<reward-point-form inline-template
	uri="{{ route('reward-point.update', [$data->slug]) }}"
	redirect-uri="{{ route('reward-point.index') }}"
	data-uri="{{ route('reward-point.data', [$data->slug]) }}">
		@include('rewardpoint::reward-point.form')
	</reward-point-form>

@endsection

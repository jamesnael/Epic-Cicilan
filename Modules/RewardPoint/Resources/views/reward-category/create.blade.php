@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<reward-category-form inline-template
	uri="{{ route('reward-category.store') }}"
	redirect-uri="{{ route('reward-category.index') }}">
		@include('rewardpoint::reward-category.form')
	</reward-category-form>

@endsection

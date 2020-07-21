@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<reward-category-form inline-template
	uri="{{ route('reward-category.update', [$data->slug]) }}"
	redirect-uri="{{ route('reward-category.index') }}"
	data-uri="{{ route('reward-category.data', [$data->slug]) }}">
		@include('rewardcategory::reward-category.form')
	</reward-category-form>

@endsection

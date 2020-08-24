@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<user-form inline-template
	uri="{{ route('users.update', [$data->slug]) }}"
	redirect-uri="{{ route('users.index') }}"
	data-uri="{{ route('users.data', [$data->slug]) }}"
	:filter_role='@json($role)'
	:slug='@json($data->slug)'>
		@include('appuser::user.form')
	</user-form>

@endsection

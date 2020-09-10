@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<user-form inline-template
	slug=""
	uri="{{ route('users.store') }}"
	redirect-uri="{{ route('users.index') }}"
	:filter_role='@json($role)'>
		@include('appuser::user.form')
	</user-form>

@endsection

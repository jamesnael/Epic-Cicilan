@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<role-form inline-template
	uri="{{ route('role.store') }}"
	redirect-uri="{{ route('role.index') }}"
	:filter_menu='@json($menu)'
	>
		@include('appuser::role.form')
	</role-form>

@endsection

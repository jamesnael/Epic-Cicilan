@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<role-form inline-template
	uri="{{ route('role.update', [$data->slug]) }}"
	redirect-uri="{{ route('role.index') }}"
	data-uri="{{ route('role.data', [$data->slug]) }}"
	:hak_akses='@json($data->hak_akses)'
	:filter_menu='@json($menu)'
	:slug='@json($data->slug)'>
		@include('appuser::role.form')
	</role-form>

@endsection

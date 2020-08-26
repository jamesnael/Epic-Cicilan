@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<spr-form inline-template
	uri="{{ route('spr.store') }}"
	redirect-uri="{{ route('spr.index') }}"
	>
		@include('installment::spr.form')
	</spr-form>

@endsection

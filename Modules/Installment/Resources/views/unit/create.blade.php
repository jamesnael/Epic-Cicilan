@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<unit-form inline-template
	uri="{{ route('unit.store') }}"
	redirect-uri="{{ route('unit.index') }}">
		@include('installment::unit.form')
	</unit-form>

@endsection

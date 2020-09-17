@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tipe-program-form inline-template
	uri="{{ route('tipe-program.store') }}"
	redirect-uri="{{ route('tipe-program.index') }}">
		@include('installment::tipe_program.form')
	</tipe-program-form>

@endsection

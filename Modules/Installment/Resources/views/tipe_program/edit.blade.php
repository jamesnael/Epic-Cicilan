@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<tipe-program-form inline-template
		uri="{{ route('tipe-program.update', [$data->slug]) }}"
		redirect-uri="{{ route('tipe-program.index') }}"
		data-uri="{{ route('tipe-program.data', [$data->slug]) }}">
		@include('installment::tipe_program.form')
	</tipe-program-form>

@endsection

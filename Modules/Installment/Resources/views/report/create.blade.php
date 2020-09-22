@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<report-form inline-template
		uri="{{ route('report.store') }}"
		redirect-uri="{{ route('report.index') }}"
		create-uri="{{ route('report.create') }}"
		:filter_sales='@json($sales)'
		:filter_client='@json($client)'
	>
		@include('installment::report.form')
	</report-form>
 	
@endsection

@extends('app')

@section('content')

	@include('components.breadcrumbs')

	<cluster-form inline-template
	uri="{{ route('cluster.store') }}"
	redirect-uri="{{ route('cluster.index') }}"
	>
		@include('installment::Cluster.form')
	</cluster-form>

@endsection

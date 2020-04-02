@extends('disburse::layouts.main')

@section('page-style')
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/table-datatables-scroller.min.js')}}" type="text/javascript"></script>
@endsection

@section('content')
	<h1>Ini Dashboard</h1>
@endsection

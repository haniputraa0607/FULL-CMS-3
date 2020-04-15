<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$idUserFrenchisee = session('id_user_franchise');
?>
@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

	<script>
		$(document).ready(function () {
			datatables();

			$("#date_end").datepicker({
				dateFormat: 'dd-mm-yy',
			}).on("change", function(e) {
				var startDate = $('#date_start').val();
				startDate = startDate.split("-").reverse().join("-");
				startDate = startDate.replace(/\s/g, '');
				startDate = new Date(startDate);
				var endDate = e.target.value;
				endDate = new Date(endDate.split("-").reverse().join("-"));
				if(endDate.getTime() < startDate.getTime()){
					$('#date_start').val(e.target.value);
				}

				datatables();
				dataDashboard();
			});
			$("#date_start").datepicker({
				dateFormat: 'dd-mm-yy',
			}).on("change", function(e) {
				var endDate = $('#date_end').val();
				endDate = endDate.split("-").reverse().join("-");
				endDate = endDate.replace(/\s/g, '');
				endDate = new Date(endDate);
				var startDate = e.target.value;
				startDate = new Date(startDate.split("-").reverse().join("-"));
				if(endDate.getTime() < startDate.getTime()){
					$('#date_end').val(e.target.value);
				}

				datatables();
				dataDashboard();
			});
		});

		function datatables(){
			$("#tbodyListFail").empty();
			var data_display = 25;
			var token  = "{{ csrf_token() }}";
			var url = "{{url('disburse/list-datatable/fail')}}";
			var dt = 0;
			var tab = $.fn.dataTable.isDataTable( '#tableListFail' );
			if(tab){
				$('#tableListFail').DataTable().destroy();
			}

			var outlet = $("#fitler_outlet").val();
			var fitler_date = $("#fitler_date").val();
			var start_date = $("#date_start").val();
			var end_date = $("#date_end").val();
			var data = {
				_token : token,
				id_outlet : outlet,
				fitler_date : fitler_date,
				start_date : start_date,
				end_date : end_date
			};

			$('#tableListFail').DataTable( {
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": false,
				"bInfo": true,
				"iDisplayLength": data_display,
				"bProcessing": true,
				"serverSide": true,
				"searching": false,
				"ajax": {
					url : url,
					dataType: "json",
					type: "POST",
					data: data,
					"dataSrc": function (json) {
						return json.data;
					}
				},
				columnDefs: [
					{
						targets: 0,
						render: function ( data, type, row, meta ) {
							var detailUrl = "{{ url('disburse/detail') }}/"+data;
							var data = '<a href="' + detailUrl + '" target="_blank" class="btn btn-block green btn-xs">Detail</a>';
							return data;
						}
					}
				]
			});
		}

		function dataDashboard(){
			var token  = "{{ csrf_token() }}";
			var url = "{{url('disburse/dashboard')}}";
			var outlet = $("#fitler_outlet").val();
			var fitler_date = $("#fitler_date").val();
			var start_date = $("#date_start").val();
			var end_date = $("#date_end").val();
			var data = {
				_token : token,
				id_outlet : outlet,
				fitler_date : fitler_date,
				start_date : start_date,
				end_date : end_date
			};

			$.ajax({
				type : "POST",
				url : url,
				data : data,
				success : function(result) {
					$("#nom_success").empty();
					$("#nom_fail").empty();
					$("#nom_trx").empty();

					if (result.status === "success") {
						$("#nom_success").append('<span data-counter="counterup" data-value="'+result.nominal_success+'">Rp '+result.format_nominal_success+'</span>');
						$("#nom_fail").append('<span data-counter="counterup" data-value="'+result.nominal_fail+'">Rp '+result.format_nominal_fail+'</span>');
						$("#nom_trx").append('<span data-counter="counterup" data-value="'+result.nominal_trx+'">Rp '+result.format_nominal_trx+'</span>');
					}else{
						$("#nom_success").append('<span data-counter="counterup" data-value="0">Rp 0</span>');
						$("#nom_fail").append('<span data-counter="counterup" data-value="0">Rp 0</span>');
						$("#nom_trx").append('<span data-counter="counterup" data-value="0">Rp 0</span>');
					}
				},
				error: function (jqXHR, exception) {
					toastr.warning('Failed get data dashboard');
				}
			});
		}

		$('#fitler_date').change(function(){
			var value_date = $("#fitler_date").val();
			if(value_date === 'specific_date'){
				document.getElementById('div_specific_date').style.display = 'block';
			}else{
				document.getElementById('div_specific_date').style.display = 'none';
			}

			datatables();
			dataDashboard();
		});

		$('#fitler_outlet').change(function(){
			datatables();
			dataDashboard();
		});
	</script>
@endsection

@extends(($idUserFrenchisee == NULL ? 'layouts.main' : 'disburse::layouts.main'))

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="/">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<span>{{ $title }}</span>
				@if (!empty($sub_title))
					<i class="fa fa-circle"></i>
				@endif
			</li>
			@if (!empty($sub_title))
				<li>
					<span>{{ $sub_title }}</span>
				</li>
			@endif
		</ul>
	</div><br>

	<h1 class="page-title" style="margin-top: 0px;">
		{{$sub_title}}
	</h1>
	@include('layouts.notifications')
	<div class="row">
		<div class="col-md-4">
			<select id="fitler_outlet" class="form-control select2" name="brand" style="width: 100%">
				<option value="all" selected>All Outlet</option>
				@foreach($outlets as $val)
					<option value="{{$val['id_outlet']}}">{{$val['outlet_code']}} - {{$val['outlet_name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-4">
			<select id="fitler_date" class="form-control select2" name="brand" style="width: 100%">
				<option value="all" selected>All Date</option>
				<option value="today">Today</option>
				<option value="specific_date">Specific Date</option>
			</select>
		</div>
	</div>

	<div class="row" style="margin-top: 1%;display: none" id="div_specific_date">
		<div class="col-md-4">
			<div class="input-group">
				<input type="text" class="form-control form-control-inline date-picker" name="date_start" id="date_start" data-date-format="dd-mm-yyyy" value="@if(isset($date_start)) {{$date_start}} @else {{date('d-m-Y', strtotime(date('d-m-Y'). ' - 1 days'))}} @endif" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
				</span>
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<input type="text" class="form-control form-control-inline date-picker" name="date_end"  id="date_end"  data-date-format="dd-mm-yyyy" value="@if(isset($date_end)) {{$date_end}} @else {{date('d-m-Y', strtotime(date('d-m-Y'). ' - 1 days'))}} @endif" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
				</span>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 3%;">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green" href="#">
				<div class="visual">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<div class="details">
					<div class="number" id="nom_success">
						<span data-counter="counterup" data-value="{{$nominal_success}}">Rp {{number_format($nominal_success)}}</span>
					</div>
					<div class="desc"> Nominal Success </div>
				</div>
			</a>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 red" href="#">
				<div class="visual">
					<i class="fa fa-bar-chart-o"></i>
				</div>
				<div class="details">
					<div class="number" id="nom_fail">
						<span data-counter="counterup" data-value="{{$nominal_fail}}">Rp {{number_format($nominal_fail)}}</span>
					</div>
					<div class="desc"> Nominal Failed </div>
				</div>
			</a>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="nom_trx">
						<span data-counter="counterup" data-value="{{$nominal_trx}}">Rp {{number_format($nominal_trx)}}</span>
					</div>
					<div class="desc"> Nominal Transaction </div>
				</div>
			</a>
		</div>
	</div>

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject font-red sbold uppercase">List Failed</span>
			</div>
		</div>
		<div class="portlet-body form">
			<table class="table table-striped table-bordered table-hover" id="tableListFail">
				<thead>
				<tr>
					<th scope="col" width="10%"> Action </th>
					<th scope="col" width="30%"> Outlet </th>
					<th scope="col" width="30%"> Date </th>
					<th scope="col" width="10%"> Nominal </th>
					<th scope="col" width="25%"> Bank Name </th>
					<th scope="col" width="25%"> Account Number </th>
					<th scope="col" width="25%"> Recipient Name </th>
				</tr>
				</thead>
				<tbody id="tbodyListFail"></tbody>
			</table>
		</div>
	</div>
@endsection
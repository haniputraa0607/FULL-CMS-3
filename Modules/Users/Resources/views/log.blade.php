@extends('layouts.main')

@section('page-style')
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script>
	function centang(no){
		alert(no);
	}
	
	function checkUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = true;
		}
	}
	
	function uncheckUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = false;
		}
	}
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
		</li>
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		@if(!Session::has('form'))
		<form role="form" action="{{ url('user/activity') }}" method="post">
			{{ csrf_field() }}
			@include('filter-log') 
		</form>
		@endif
	</div>
	<div class="col-md-12">
		<div class="portlet light portlet-fit bordered" >
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-red sbold uppercase"><i class="fa fa-list"></i> {{$table_title}} </span>
				</div>
			</div>
			<div class="portlet-body">
				@if(Session::has('form'))
					<?php
						$search_param = Session::get('form');
						$search_param = array_filter($search_param);
					?>
					<div class="alert alert-block alert-success fade in">
						<button type="button" class="close" data-dismiss="alert"></button>
						<h4 class="alert-heading">Displaying search result with parameter(s):</h4>
						@if(isset($search_param['conditions']))
						@foreach($search_param['conditions'] as $row)
							<p>{{ucwords(str_replace("_"," ",$row['subject']))}} 
							@if($row['parameter'] != "") {{str_replace("-"," - ",$row['operator'])}}{{str_replace("-"," - ",$row['parameter'])}}
							@else : {{str_replace("-"," - ",$row['operator'])}}
							@endif
							</p>
						@endforeach
						@endif
						<br>
						<p>
							<a href="{{ url('user/search/reset') }}" class="btn yellow">Reset</a>
						</p>
					</div>
				@endif
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-bottom:20px;">
					<div class="col-md-4" style="padding-left:0px;padding-right:0px;">
						<a href="#" class="btn btn md yellow" onClick="checkUsers();">Check All</a>
						<a href="#" class="btn btn md red" onClick="uncheckUsers();">Uncheck All</a>
					</div>
					<form action="{{ url('user/activity') }}" method="post">
					{{ csrf_field() }}
					<div class="col-md-2" style="padding-left:0px;padding-right:0px;">
						<select name="take" class="form-control select2">
							<option value="10" @if($take == 10) selected @endif>Show 10 Data</option>
							<option value="50" @if($take == 50) selected @endif>Show 50 Data</option>
							<option value="100" @if($take == 100) selected @endif>Show 100 Data</option>
							<option value="9999999999" @if($take == 9999999999) selected @endif>Show ALL Data</option>
						</select>
					</div>
					<div class="col-md-3" style="padding-left:0px;padding-right:0px;">
						<select name="order_field" class="form-control select2">
							<option value="id" @if($order_field == 'id_log_activity') selected @endif>Order by ID</option>
							<option value="name" @if($order_field == 'name') selected @endif>Order by Name</option>
							<option value="phone" @if($order_field == 'phone') selected @endif>Order by Phone</option>
							<option value="email" @if($order_field == 'email') selected @endif>Order by Email</option>
							<option value="address" @if($order_field == 'subject') selected @endif>Order by Subject</option>
							<option value="gender" @if($order_field == 'created_at') selected @endif>Order by Created At</option>
							<option value="birthday" @if($order_field == 'status') selected @endif>Order by Status</option>
							<option value="city_name" @if($order_field == 'request') selected @endif>Order by Request</option>
							<option value="province_name" @if($order_field == 'response') selected @endif>Order by Response</option>
						</select>
					</div>
					<div class="col-md-2" style="padding-left:0px;padding-right:0px">
						<select name="order_method" class="form-control select2">
							<option value="desc" @if($order_method == 'desc') selected @endif>Desc</option>
							<option value="asc" @if($order_method == 'asc') selected @endif>Asc</option>
						</select>
					</div>
					<div class="col-md-1" style="padding-left:0px;padding-right:0px;text-align:right">
						<button type="submit" class="btn yellow">Show</button>
					</div>
					</form>
				</div>
				<div class="col-md-12" style="text-align:right;margin-right:0px;padding-right:0px;margin-bottom:20px;">
					<a href="{{ url('user/activity/export') }}" class="btn yellow">Export User Data (.xls)</a>
				</div>
				<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th scope="col" style="width:450px !important"> No </th>
								<th scope="col"> Actions </th>
								<th scope="col"> Date Time </th>
								<th scope="col"> Name </th>
								<th scope="col"> Phone </th>
								<th scope="col"> Status </th>
								<th scope="col"> Subject </th>
								<th scope="col"> Email </th>
								<th scope="col"> Request </th>
								<th scope="col"> Response </th>
								<th scope="col"> IP </th>
								<th scope="col"> User Agent </th>
								
							</tr>
						</thead>
						<tbody>
							<form action="{{ url('user') }}" method="post">
							{{ csrf_field() }}
							@if(!empty($content))
								@foreach($content as $no => $data)
								
								@if($data['response_status'] == 'fail')
								<tr style="color:red">
								@else
								<tr>
								@endif
									<td> {{$no+1}}
									</td>
									<td>
									<a class="btn btn-block green btn-xs" href="{{ url('user/detail', $data['phone']) }}"><i class="icon-pencil"></i> Detail </a>
									<a class="btn btn-block red btn-xs" href="{{ url('user/delete', $data['phone']) }}" data-toggle="confirmation" data-placement="top"><i class="icon-tag"></i> Delete </a>
									</td>
									<td> {{str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($data['created_at'])))}} </td>
									<td> {{str_replace(" ","&nbsp;", $data['name'])}} </td>
									<td> {{$data['phone']}} </td>
									<td> {{$data['response_status']}} </td>
									<td> {{str_replace(" ","&nbsp;", $data['subject'])}} </td>
									<td> {{str_replace(" ","&nbsp;", $data['email'])}} </td>
									<td> {{str_replace(" ","&nbsp;", $data['request'])}} </td>
									<td> {{substr(str_replace(" ","&nbsp;", $data['response']), 0, 350)}} </td>
									<td> {{$data['ip']}} </td>
									<td> {{str_replace(" ","&nbsp;", $data['useragent'])}} </td>
								</tr>
								@endforeach
							@else
								<td colspan="12" style="text-align:center"> Data is empty</td>
							@endif
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:20px">
				<div class="col-md-5" style="padding-left:0px;padding-right:0px;">
					
				</div>
				<div class="col-md-3" style="padding-left:0px;padding-right:0px;">
					
				</div>
				<div class="col-md-4" style="padding-left:0px;padding-right:0px;">
					<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
						<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
							@if($page <= 1) <li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
							@else <li class="page-first"><a href="{{url('user')}}/activity/{{$page-1}}">«</a></li>
							@endif
							
							@if($last == $total) <li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
							@else <li class="page-last"><a href="{{url('user')}}/activity/{{$page+1}}">»</a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>
			</form>
			
		</div>
	</div>
</div>
@endsection
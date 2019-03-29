<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
 @extends('layouts.main-closed')

@section('page-style')
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection

@section('page-plugin')
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script src="{{Cdn::asset('kk-ass/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
	function checkAll(var1,var2){
		for(x=1;x<=var2;x++){
			var value = document.getElementById('module_'+var1).checked;
			if(value == true){
				document.getElementById(var1+'_'+x).checked = true;
			} else {
				document.getElementById(var1+'_'+x).checked = false;
			}
		}
	}
	
	function checkSingle(var1,var2){
		var compare=0;
		var2 = $('.checkbox'+var1).length;
		for(x=1;x<=var2;x++){
			var value = document.getElementById(var1+'_'+x).checked;
			if(value == true){
				compare = compare + 1;
			}
		}
		console.log(var2+ ' ' +compare)
		if(compare == var2){
			document.getElementById('module_'+var1).checked = true;
		} else {
			document.getElementById('module_'+var1).checked = false;
		}
	}
	
	 $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_2').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_3').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_4').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
	$(document).ready(function() {
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	});
	
	function scheduleIdStore(id_outlet){
		document.getElementById('id_outlet_schedule').value = id_outlet;
	}
	
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
	
	function viewLogDetail(url, status, request, response, ip, useragent){
		document.getElementById("log-url").value = url;
		document.getElementById("log-status").value = status;
		document.getElementById("log-request").innerHTML = request;
		document.getElementById("log-response").innerHTML = response;
		document.getElementById("log-ip").value = ip;
		document.getElementById("log-useragent").value = useragent;
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
		<div class="profile">
			<div class="tabbable-line tabbable-full-width">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#overview" data-toggle="tab"> Account Overview </a>
					</li>
					<li>
						<a href="#profileupdate" data-toggle="tab"> Account Update </a>
					</li>
					<li>
						<a href="#permission" data-toggle="tab"> Access Permission </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="overview">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4 profile-info">
										<h1 class="font-blue sbold uppercase">{{$profile['name']}}</h1>
										<div class="portlet sale-summary">
											<div class="portlet-title"> 
												<div class="caption font-blue sbold"> {{$profile['level']}} </div>
											</div>
											<div class="portlet-body">
												<ul class="list-unstyled">
													<li>
														<span class="sale-info"> Level 
															<i class="fa fa-img-up"></i>
														</span>
														@if($profile['level'] == 'Super Admin')
															<span class="sale-num font-red sbold">Super Admin</span>
														@endif
														@if($profile['level'] == 'Admin') 
															<span class="sale-num font-red sbold">Admin</span>
														@endif
														@if($profile['level'] == 'Customer') 
															<span class="sale-num font-blue sbold">Customer</span>
														@endif
														@if($profile['level'] == 'Admin Outlet') 
															<span class="sale-num font-blue sbold">Admin Outlet</span>
														@endif
													</li>
													<li>
														<span class="sale-info"> Phone 
															<i class="fa fa-img-up"></i>
														</span>
														@if($profile['phone_verified']==1)
															<span class="sale-num font-blue">verified</span>
														@else
															<span class="sale-num font-red">not verified</span>
														@endif
													</li>
													<li>
														<span class="sale-info"> Email
															<i class="fa fa-img-down"></i>
														</span>
														@if($profile['email_verified']==1)
															<span class="sale-num font-blue">verified</span>
														@else
															<span class="sale-num font-red">not verified</span>
														@endif
													</li>
												</ul>
											</div>
										</div>
										<ul class="list-group">
											<li class="list-group-item" style="padding: 5px !important;" title="User Phone number & Provider">
												<i class="fa fa-mobile-phone"></i> {{$profile['phone']}} ({{$profile['provider']}}) </li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Email">
												<i class="fa fa-envelope-o"></i> {{$profile['email']}} </li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Gender">
												@if($profile['gender'] == 'Male')<i class="fa fa-male"></i> {{$profile['gender']}} </li>@else<i class="fa fa-female"></i> {{$profile['gender']}} </li>
												@endif
											<li class="list-group-item" style="padding: 5px !important;" title="User City & Province">
												<i class="fa fa-map"></i> {{$profile['city_name']}}, {{$profile['province_name']}} </li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Relationship">
												<i class="fa fa-heart"></i> {{$profile['relationship']}} </li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Birthday">
												<i class="fa fa-birthday-cake"></i> @if($profile['birthday']){{date("d F Y", strtotime($profile['birthday']))}} @endif</li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Register date & time">
												<i class="fa fa-registered"></i> {{date("d F Y", strtotime($profile['created_at']))}} </li>
										</ul>
									</div>
									<!--end col-md-8-->
									<div class="col-md-8">
										@if(isset($log))
										<h4 class="font-blue sbold uppercase" style="margin-top: 0px;margin-bottom: 50px;font-size: 24px;">Latest Activity Log</h4>
										<div class="tabbable-line tabbable-custom-profile">
											<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
												<ul class="feeds">
													@foreach($log as $logs)
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	@if($logs['response_status'] == 'fail')
																		<div class="label label-danger">
																			<i class="fa fa-exclamation-circle"></i>
																		</div>
																	@else
																		<div class="label label-success">
																			<i class="fa fa-check-square"></i>
																		</div>
																	@endif
																</div>
																<div class="cont-col2">
																	<div class="desc"> {{$logs['subject']}} 
																		@if($logs['response_status'] == 'fail')
																		<span class="label label-danger label-sm"> Failed
																		</span>
																		@else
																		<span class="label label-success label-sm"> Success
																		</span>
																		@endif
																		 from IP {{$logs['ip']}}
																		 
																		 <?php 
																		 $request =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['request']))));
																		 
																		 $response =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['response']))));
																		 ?>
																		<span class="label label-info label-sm" data-toggle="modal" href="#logModal" onClick="viewLogDetail('{{$logs['url']}}','{{$logs['response_status']}}', '{{$request}}','{{$response}}','{{$logs['ip']}}','{{$logs['useragent']}}')"> <i class="fa fa-info-circle"></i> Details
																		
																		</span>
																	</div>
																</div>
															</div>
														</div>
														<div class="col2" style="width: 190px;margin-left: -190px;">
															<div class="date"> {{date("d F Y H:i:s", strtotime($logs['created_at']))}} </div>
														</div>
													</li>
													@endforeach
												</ul>
											</div>
										</div>
										@endif
										<div class="col-md-12 row" style="margin-top:30px">
										<h4 class="font-blue sbold uppercase">HISTORY</h4>
											<div class="tabbable-line tabbable-full-width">
												<ul class="nav nav-tabs">
													<li class="active">
														<a href="#portlet_comments_1" data-toggle="tab"> Transaction </a>
													</li>
													@if(MyHelper::hasAccess([18], $configs))
														<li>
															<a href="#portlet_comments_4" data-toggle="tab"> Point </a>
														</li>
													@endif
												</ul>
											</div>
											<div class="tab-content" style="margin-top:20px">
												<div class="tab-pane active" id="portlet_comments_1">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($profile['transactions']))
															<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
																<thead>
																  <tr>
																	  <th>Date</th>
																	  <th>Receipt Number</th>
																	  <th>Total Price</th>
																	  <th>Payment Status</th>
																	  <th>Actions</th>
																  </tr>
																</thead>
																<tbody>
																	@foreach($profile['transactions'] as $res)
																		<tr>
																			<td>{{ date('d F Y H:i', strtotime($res['created_at'])) }}</td>
																			<td>{{ $res['transaction_receipt_number'] }}</td>
																			<td>Rp {{ number_format($res['transaction_grandtotal']) }}</td>
																			<td>{{ $res['transaction_payment_status'] }}</td>
																			<td>
																				<a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail/'.$res['id_transaction'].'/'.$res['trasaction_type']) }}"><i class="icon-pencil"></i> Detail </a>
																			</td>
																		</tr>
																	@endforeach
																</tbody>
															</table>
														@else
															Transaction is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>
												@if(MyHelper::hasAccess([18], $configs))
													<div class="tab-pane" id="portlet_comments_4">
														<div class="row">
															<div class="col-lg-12 col-xs-12 col-sm-12">
																<div class="portlet light ">
																	<div class="portlet-body">
																		<div class="row number-stats margin-bottom-30">
																			<div class="col-md-6 col-sm-6 col-xs-6">
																				<div class="stat-left">
																					<div class="stat-number">
																						<div class="title" style="color: red"> Voucher </div>
																						<div class="number"> Voucher </div>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6">
																				<div class="stat-right">
																					<div class="stat-number">
																						<div class="title" style="color: blue"> Transaction </div>
																						<div class="number"> Trx </div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<table class="table table-striped table-bordered table-hover dt-responsive" id="sample_4">
																			<thead>
																				<tr class="uppercase">
																					<th> Source </th>
																					<th> Point </th>
																					<th> Date </th>
																					<th> Time </th>
																					<th> Detail </th>
																				</tr>
																			</thead>
																			@if(!empty($profile['point']))
																				@foreach ($profile['point'] as $point)
																					<tr @if ($point['source'] == 'voucher') style="color: red" @else style="color: blue" @endif >
																						<td> {{ ucwords($point['source']) }} </td>
																						<td> {{ $point['point'] }} </td>
																						<td> {{ date('d F Y', strtotime($point['created_at'])) }} </td>
																						<td> {{ date('H:i:s', strtotime($point['created_at'])) }} </td>
																						@if ($point['source'] != 'voucher')
																							<td> {{ $point['detail_product']['transaction_receipt_number'] }} </td>
																						@else
																							<td> {{ $point['detail_product']['trx_id'] }} </td>
																						@endif
																						
																					</tr>
																				@endforeach
																			@endif
																		</table>
																	</div>
																</div>
															</div>
														</div>
													</div>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--tab_1_2-->
					<div class="tab-pane" id="profileupdate">
						<div class="row profile-account">
							<div class="col-md-3">
								<ul class="ver-inline-menu tabbable margin-bottom-10">
									<li class="active">
										<a data-toggle="tab" href="#tab_1-1">
											<i class="fa fa-cog"></i> Personal info </a>
										<span class="after"> </span>
									</li>
									<li>
										<a data-toggle="tab" href="#tab_2-2">
											<i class="fa fa-picture-o"></i> Change Photo </a>
									</li>
									<li>
										<a data-toggle="tab" href="#tab_3-3">
											<i class="fa fa-lock"></i> Change Password </a>
									</li>
								</ul>
							</div>
							<div class="col-md-9">
								<div class="tab-content">
									<div id="tab_1-1" class="tab-pane active">
										<form role="form" action="{{url('user/detail')}}/{{$profile['phone']}}" method="POST">
										{{ csrf_field() }}
											<div class="form-group">
												<label class="control-label">Name</label>
												<input type="text" name="name" placeholder="User Name (Required)" class="form-control" value="{{$profile['name']}}" /> 
											</div>
											<div class="form-group">
												<label class="control-label">Phone</label>
												<input type="text" name="phone" placeholder="Phone Number(Required & Unique)" class="form-control" value="{{$profile['phone']}}" />
											</div>
											<div class="form-group">
												<label class="control-label">Email</label>
												<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" value="{{$profile['email']}}" />
											</div>
											<div class="form-group">
												<label class="control-label">City</label>
												<select name="id_city" class="form-control input-sm select2" placeholder="Search City">
													<option value="">Select...</option>
													@if(isset($city))
														@foreach($city as $row)
															<option value="{{$row['id_city']}}" @if(isset($profile['id_city'])) @if($row['id_city'] == $profile['id_city']) selected @endif @endif>{{$row['city_name']}}</option>
														@endforeach
													@endif
												</select>
											</div>
											<div class="form-group">
												<label class="control-label">Gender</label>
												<select name="gender" class="form-control input-sm select2">
													<option value="">Select...</option>
													<option value="Male" @if(isset($profile['gender'])) @if($profile['gender'] == 'Male') selected @endif @endif>Male</option>
													<option value="Female" @if(isset($profile['gender'])) @if($profile['gender'] == 'Female') selected @endif @endif>Female</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label">Relationship</label>
												<select name="relationship" class="form-control input-sm select2">
													<option value="">Select...</option>
													<option value="-" {{ ($profile['relationship']=="" ? "selected" : "") }}>-</option>
						                            <option value="In a Relationship" {{ ($profile['relationship']=="In a Relationship" ? "selected" : "") }}>In a Relationship</option>
						                            <option value="Complicated" {{ ($profile['relationship']=="Complicated" ? "selected" : "") }}>Complicated</option>
						                            <option value="Jomblo" {{ ($profile['relationship']=="Jomblo" ? "selected" : "") }}>Jomblo</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label">Birthday</label>
												<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
													<input type="text" class="form-control form-filter input-sm date-picker" readonly name="birthday" placeholder="From"  value="{{date('d/m/Y', strtotime($profile['birthday']))}}">
													<span class="input-group-btn">
														<button class="btn btn-sm default" type="button">
															<i class="fa fa-calendar"></i>
														</button>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Phone Verified</label>
												<div class="mt-radio-inline">
													<label class="mt-radio">
														<input type="radio" name="phone_verified" id="optionsRadios1" value="1" @if($profile['phone_verified'] == '1') checked @endif > Verified
														<span></span>
													</label>
													<label class="mt-radio">
														<input type="radio" name="phone_verified" id="optionsRadios2" value="0" @if($profile['phone_verified'] == '0') checked @endif> Not Verified
														<span></span>
													</label>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Email Verified</label>
												<div class="mt-radio-inline">
													<label class="mt-radio">
														<input type="radio" name="email_verified" id="optionsRadios3" value="1" @if($profile['email_verified'] == '1') checked @endif > Verified
														<span></span>
													</label>
													<label class="mt-radio">
														<input type="radio" name="email_verified" id="optionsRadios4" value="0" @if($profile['email_verified'] == '0') checked @endif> Not Verified
														<span></span>
													</label>
												</div>
											</div>
											<div class="margiv-top-10">
												<button class="btn green"> Save Changes </button>
											</div>
										</form>
									</div>
									<div id="tab_2-2" class="tab-pane">
										<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" >
										{{ csrf_field() }}
											<div class="margin-top-10">
												<button class="btn green"> Save Changes </button>
											</div>
										</form>
									</div>
									<div id="tab_3-3" class="tab-pane">
										<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" method="POST">
										{{ csrf_field() }}
											<div class="form-group">
												<label class="control-label">New Password</label>
												<input type="password" class="form-control" name="password_new" /> </div>
											<div class="form-group">
												<label class="control-label">Re-type New Password</label>
												<input type="password" class="form-control" name="password_new_confirmation" /> </div>
											<div class="margin-top-10">
												<button class="btn green"> Save Changes </button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!--end col-md-9-->
						</div>
					</div>
					<!--end tab-pane-->
					<div class="tab-pane" id="permission">
						<div class="row">
							<h1 style="text-align:center;">{{$profile['name']}} has access as <b>{{$profile['level']}}</b>.</h1>
							<h3 style="text-align:center;"><b>{{$profile['level']}}</b> 
							@if($profile['level'] == 'Super Admin') has access to All Features.@endif
							@if($profile['level'] == 'Admin') has access to limited features.@endif
							@if($profile['level'] == 'Customer') has no access to backend.@endif
							@if($profile['level'] == 'Admin Outlet') has access to manage delivery, pickup and outlet enquiry @endif
							
							</h3>
							
							<h3 style="text-align:center;margin-bottom:50px">Do You want to change {{$profile['name']}}'s access level?</h3>
							
							@if($profile['level'] != 'Customer')
							<div class="col-md-4">
								<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" style="text-align:center;">
								{{ csrf_field() }}
									<input type="password" class="form-control" width="30%" name="password_level" placeholder="Enter Your current PIN" required>
									<input type="hidden" class="form-control" name="level" value="Customer">
									<button class="btn btn-lg green btn-block"> Yes! Be a Customer <i class="fa fa-user "></i> </button>
								</form>
							</div>
							@endif
							
							@if($profile['level'] != 'Admin')
							<div class="col-md-4">
								<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" style="text-align:center;">
								{{ csrf_field() }}
									<input type="password" class="form-control" width="30%" name="password_level" placeholder="Enter Your current PIN" required>
									<input type="hidden" class="form-control" name="level" value="Admin">
									<button class="btn btn-lg yellow btn-block"> Yes! Be an Admin <i class="fa fa-user-plus "></i> </button>
								</form>
							</div>
							@endif
							
							@if($profile['level'] != 'Super Admin' && Session::get('level') == 'Super Admin')
							<div class="col-md-4">
								<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" style="text-align:center;">
								{{ csrf_field() }}
									<input type="password" class="form-control" width="30%" name="password_level" placeholder="Enter Your current PIN" required>
									<input type="hidden" class="form-control" name="level" value="Super Admin">
									<button class="btn btn-lg red btn-block"> Yes! Be a Super Admin <i class="fa fa-user-secret "></i> </button>
								</form>
							</div>
							@endif
							
@if($profile['level'] == 'Admin')
	<div class="col-md-12" style="margin-top:30px">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-dark sbold uppercase font-blue">Admin Access Permission</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" method="POST" class="form-horizontal" style="text-align:center;">
				{{ csrf_field() }}
					<div class="form-body">
						<?php
						$arrmodule = [];
						foreach($featuresall as $all){
							array_push($arrmodule, $all['feature_module']);
						}
						$arrmodule = array_unique($arrmodule);
						?>
						@foreach($arrmodule as $key => $module)
						<div class="form-group">
							<label class="col-md-3 control-label"  style="margin-top: 10px;">{{$module}}</label>
							<div class="md-checkbox-inline col-md-9" style="text-align:left">
								<?php $x = 1; $y=0?>
								@foreach($featuresall as $key2 => $feature)
									@if($feature['feature_module'] == $module)
										<?php
										$stat = false;
										foreach($features as $userfeature){
											if($feature['id_feature'] == $userfeature){
												$stat = true;
												$y++;
											}
										}
										?>
										<div class="md-checkbox">
											<input type="checkbox" id="{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}_{{$x}}" name="module[]" value="{{$feature['id_feature']}}" class="md-check checkbox{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}" onChange="checkSingle('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x}}')" @if($stat==true) checked @endif>
											<label for="{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}_{{$x}}">
												<span></span>
												<span class="check" style="margin-top: 10px;"></span>
												<span class="box" style="margin-top: 10px;"></span> {{$feature['feature_type']}}
											</label>
										</div>
										<?php $x++;?>
									@endif
								@endforeach
								<div class="md-checkbox">
									<input type="checkbox" class="md-check" onChange="checkAll('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x-1}}')" id="module_{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}" @if($y==$x-1) checked @endif>
									<label for="module_{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}">
										<span></span>
										<span class="check" style="margin-top: 10px;" onChange="checkAll('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x-1}}')"></span>
										<span class="box" style="margin-top: 10px;"></span> All {{$module}}
									</label>
								</div>
							</div>
						</div>
						@endforeach
						<div class="form-group">
							<label class="col-md-3 control-label">Your Password</label>
							<div class="col-md-4">
								<input type="password" class="form-control" width="30%" name="password_permission" placeholder="Enter Your current PIN" required style="width: 91.3%;">
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-4 col-md-5">
									<button class="btn btn-lg blue btn-block"> Change Permission <i class="fa fa-check-circle "></i> </button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="logModal" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Request & Response Detail</h4>
			</div>
			<div class="modal-body form">
				<form role="form">
					<div class="form-body">
						<div class="form-group">
							<label>URL</label>
							<input type="text" class="form-control" readonly id="log-url">
						</div>
						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" readonly id="log-status">
						</div>
						<div class="form-group">
							<label>IP Address</label>
							<input type="text" class="form-control" readonly id="log-ip">
						</div>
						<div class="form-group">
							<label>User Agent</label>
							<input type="text" class="form-control" readonly id="log-useragent">
						</div>
						<div class="form-group">
							<label>Request</label>
							<textarea class="form-control" rows="4" readonly id="log-request"></textarea>
						</div>
						<div class="form-group">
							<label>Response</label>
							<textarea class="form-control" rows="4" readonly id="log-response"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection
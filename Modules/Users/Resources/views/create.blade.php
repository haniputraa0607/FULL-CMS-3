@extends('layouts.main')

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
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
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
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">New User Account</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('user/create')}}" method="POST">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Name
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="name" placeholder="User Name (Required)" class="form-control" required /> 
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Phone
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon seluler" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="phone" placeholder="Phone Number (Required & Unique)" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Email
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Email user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    PIN
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="PIN terdiri dari 6 digit angka" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="password" name="pin" placeholder="6 digits PIN (Leave empty to autogenerate)" class="form-control mask_number" maxlength="6" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Sent PIN to User?
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah akan mengirimkan PIN ke user (Yes/No)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="sent_pin" class="form-control input-sm select2" data-placeholder="Yes / No" required>
									<option value="">Select...</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    City
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_city" class="form-control input-sm select2" placeholder="Search City" data-placeholder="Choose Users City" required>
									<option value="">Select...</option>
									@if(isset($city))
										@foreach($city as $row)
											<option value="{{$row['id_city']}}">{{$row['city_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Gender
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Jenis kelamin user (laki-laki/perempuan)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="gender" class="form-control input-sm select2" data-placeholder="Male / Female" required>
									<option value="">Select...</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Relationship
							    <i class="fa fa-question-circle tooltips" data-original-title="User relationship" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="relationship" class="form-control input-sm select2" data-placeholder="Relationship">
									<option value="">Select...</option>
									<option value="-">-</option>
		                            <option value="In a Relationship">In a Relationship</option>
		                            <option value="Complicated">Complicated</option>
		                            <option value="Jomblo">Jomblo</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Birthday
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lahir user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
									<input type="text" class="form-control form-filter input-sm date-picker" readonly name="birthday" placeholder="Birthday Date" required>
									<span class="input-group-btn">
										<button class="btn btn-sm default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Level
							    <span class="required" aria-required="true"> * </span>  
							    <i class="fa fa-question-circle tooltips" data-original-title="Hak akses yang diberikan ke user (admin/ customer)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="level" class="form-control input-sm select2">
									<option value="Admin">Admin</option>
									<option value="Customer" selected>Customer</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
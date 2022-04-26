
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
            // library initialization
            $('[data-switch=true]').bootstrapSwitch();
			
			$.ajax({
				type: "GET",
				url: "getTag",
				dataType: "json",
				success: function(data){
					if (data.status == 'fail') {
						$.ajax(this)
						return
					}
					productLoad = 1;
					$.each(data, function( key, value ) {
						$('#selectService').append("<option id='service"+value.id_doctor_service+"' value='"+value.doctor_service_name+"'>"+value.doctor_service_name+"</option>");
					});
					$('#multipleProduct').prop('required', true)
					$('#multipleProduct').prop('disabled', false)
				},
				complete: function(data){
					doctor_service = JSON.parse('{!!json_encode($service)!!}')
					$.each(doctor_service, function( key, value ) {
						$("#doctor_service"+value.doctor_service.doctor_service_name+"").attr('selected', true)
					});
				}
			});

			$("#selectService").select2({
				placeholder: "Input Service",
				tags: true
			});
		});
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Doctor</a>
		</li>
	</ul>
</div>
<br>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">New Doctor</span>
				</div>
			</div>
			<div class="portlet-body form">
				@if(isset($doctor))
				<form role="form" class="form-horizontal" action="{{ url('/doctor', $doctor['id_doctor'])}}/update"" method="POST">
					@method('PUT')
				@else 
				<form role="form" class="form-horizontal" action="{{url('doctor/store')}}" method="POST" enctype="multipart/form-data">
				@endif
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Name
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama doctor" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-6">
								<input type="text" name="doctor_name" placeholder="Doctor Name (Required)" value="{{isset($doctor) ? $doctor['doctor_name'] : ''}}" class="form-control" required />
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
							<div class="col-md-4">
								<input type="text" name="doctor_phone" placeholder="Phone Number (Required & Unique)" value="{{isset($doctor) ? $doctor['doctor_phone'] : ''}}" class="form-control" required autocomplete="new-password" />
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
							<div class="col-md-4">
								<input type="password" name="pin" placeholder="6 digits PIN (Leave empty to autogenerate)" class="form-control mask_number" maxlength="6" autocomplete="new-password" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Clinic
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Pilih klinik dokter" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-6">
								<select name="id_doctor_clinic" class="form-control input-sm select2" data-placeholder="Select Clinic..." required>
									<option value="">Select Clinic...</option>
									@if(isset($clinic))
										@foreach($clinic as $row)
											<option value="{{$row['id_doctor_clinic']}}" 
											{{isset($doctor) ? $doctor['id_doctor_clinic'] == $row['id_doctor_clinic'] ? "selected" : '' : ''}}>
											{{$row['doctor_clinic_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						{{--<div class="form-group">
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
						</div>--}}
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Session Price
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan harga sesi" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-4">
								<input type="text" name="doctor_session_price" placeholder="Session Price (Required)" value="{{isset($doctor) ? $doctor['doctor_session_price'] : ''}}" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Specialist
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Pilih specialist dokter" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-6">
								<select name="doctor_specialist[]" id="selectService" class="form-control input-sm select2-multiple select2-hidden-accessible" multiple="multiple" data-placeholder="Select specialist..." required>
									<option value="">Select Specialist...</option>
									@if(isset($specialist))
										@if(isset($doctor))
											@foreach($specialist as $key => $row)
												@php $selected = (in_array($row['id_doctor_specialist'], $selected_id_specialist) ? 'selected' : ''); @endphp
												<option value="{{$row['id_doctor_specialist']}}"
												{{isset($doctor) ? $selected : ''}}>
												{{$row['doctor_specialist_name']}}</option>
											@endforeach
										@else
											@foreach($specialist as $key => $row)
												<option value="{{$row['id_doctor_specialist']}}">
												{{$row['doctor_specialist_name']}}</option>
											@endforeach
										@endif
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Service
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Pilih service dokter" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-6">
								<select name="doctor_service[]" id="selectService" class="form-control input-sm select2-multiple select2-hidden-accessible" multiple="multiple" data-placeholder="Select service..." required>
									<option value="">Select Service...</option>
									@if(isset($service))
										@if(isset($doctor))
											@foreach($service as $row)
												@php $selected = (in_array($row['doctor_service_name'], $doctor['doctor_service']) ? 'selected' : ''); @endphp
												<option value="{{$row['doctor_service_name']}}"}}
												{{isset($doctor) ? $selected : ''}}>
												{{$row['doctor_service_name']}}</option>
											@endforeach
										@else
											@foreach($service as $row)
												<option value="{{$row['doctor_service_name']}}"}}>
												{{$row['doctor_service_name']}}</option>
											@endforeach
										@endif
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Status Account <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input data-switch="true" type="checkbox" name="is_active" data-on-text="Active" data-off-text="Deactive" checked/>
                            </div>
                        </div>
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-3 control-label">
									Id Photo
									<i class="fa fa-question-circle tooltips" data-original-title="Foto Professional Dokter" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
										<img src="https://www.cs.emory.edu/site/media/rg5">
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 100px;"> </div>
									<div>
										<span class="btn default btn-file">
											<span class="fileinput-new"> Select image </span>
											<span class="fileinput-exists"> Change </span>
											<input type="file" accept="image/*" id="field_image" class="file" name="doctor_photo">
										</span>
										<a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-icon right">
							<label class="col-md-3 control-label"> </label>
						</div>
						<div class="col-md-9">
							<div class="form-actions">
								{{ csrf_field() }}
								<button type="submit" class="btn blue" id="checkBtn">{{isset($doctor) ? 'Update' : 'Create'}}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

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

			$('.price').each(function() {
				var input = $(this).val();
				var input = input.replace(/[\D\s\._\-]+/g, "");
				input = input ? parseInt( input, 10 ) : 0;

				$(this).val( function() {
					return ( input === 0 ) ? "" : input.toLocaleString( "id" );
				});
			});

			$( ".price" ).on( "keyup", numberFormat);
			function numberFormat(event){
				var selection = window.getSelection().toString();
				if ( selection !== '' ) {
					return;
				}

				if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
					return;
				}
				var $this = $( this );
				var input = $this.val();
				var input = input.replace(/[\D\s\._\-]+/g, "");
				input = input ? parseInt( input, 10 ) : 0;

				$this.val( function() {
					return ( input === 0 ) ? "" : input.toLocaleString( "id" );
				});
			}

			$( ".price" ).on( "blur", checkFormat);
			function checkFormat(event){
				var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
				if(!$.isNumeric(data)){
					$( this ).val("");
				}
			}

			var max_fields = 10;
			var wrapper = $(".container1");
			var add_button = $(".add_form_field");

			var x = 1;
			$(add_button).click(function(e) {
				e.preventDefault();
				if (x < max_fields) {
					x++;
					$(wrapper).append('<div><div class="col-md-8" style="margin-top:10px;"><input type="text" name="practice_experience_place[]" placeholder="Practice Experience Place" class="form-control" required /></div><div class="col-md-4" style="margin-top:10px;"> <a href="#" class="delete">Delete</a> </div> </div>'); //add input box
				} else {
					alert('You Reached the limits')
				}
			});

			$(wrapper).on("click", ".delete", function(e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove();
				x--;
			})
		});
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="#">Home</a>
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
</div>
<br>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="tab-content">
			<div class="tabbable-line tabbable-full-width">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#overview" data-toggle="tab"> Info Personal </a>
					</li>
					@if(isset($doctor))
					<li>
						<a href="#password" data-toggle="tab"> Change Password </a>
					</li>
					@endif
				</ul>
			</div>
			<div class="tab-pane active" id="overview">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							@if(isset($doctor))
								<span class="caption-subject bold uppercase">Detail Doctor</span>
							@else
								<span class="caption-subject bold uppercase">New Doctor</span>
							@endif
						</div>
					</div>
					<div class="portlet-body form">
						@if(isset($doctor))
						<form role="form" class="form-horizontal" action="{{ url('/doctor', $doctor['id_doctor'])}}/update"" method="POST" enctype="multipart/form-data">
							@method('PUT')
							<input name="id_doctor" value="{{$doctor['id_doctor']}}" class="form-control hidden" />
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
									<div class="col-md-7">
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
									<div class="col-md-7">
										<input type="text" name="doctor_phone" placeholder="Phone Number (Required & Unique)" value="{{isset($doctor) ? $doctor['doctor_phone'] : ''}}" class="form-control" required autocomplete="new-password" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										ID Card Number
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Nomor Kartu Identitas" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="id_card_number" placeholder="Id Card Number (Required)" value="{{isset($doctor) ? $doctor['id_card_number'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Address
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Alamat" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<textarea type="text" name="address" placeholder="Input your address here..." class="form-control">{{isset($doctor) ? $doctor['address'] : ''}}</textarea> 
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
									<div class="col-md-7">
										<select name="gender" class="form-control input-sm select2" data-placeholder="Male / Female" required>
											<option value="">Select...</option>
											<option value="Male" {{isset($doctor) ? $doctor['gender'] == "Male" ? "selected" : '' : ''}}>Male</option>
											<option value="Female" {{isset($doctor) ? $doctor['gender'] == "Female" ? "selected" : '' : ''}}>Female</option>
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
									<div class="col-md-7">
										<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
											<input type="text" class="form-control form-filter input-sm date-picker" name="birthday" placeholder="Birthday Date" required>
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
										Celebrate
										<i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<select name="celebrate" class="form-control input-sm select2" placeholder="Search Celebrate" data-placeholder="Choose Users Celebrate">
											<option value="">Select...</option>
											@if(isset($celebrate))
												@foreach($celebrate as $row)
													<option value="{{$row}}" {{isset($doctor) ? $doctor['celebrate'] == $row ? "selected" : '' : ''}}>{{$row}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								@if(!isset($doctor))
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Password
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="password" name="pin" placeholder="Minimum 8 digits karakter (Leave empty to autogenerate)" minlength="8" class="form-control mask_number" autocomplete="new-password" required />
									</div>
								</div>
								@endif
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Sent Password to Doctor?
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah akan mengirimkan password ke user (Yes/No)" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-4">
										<select name="sent_pin" class="form-control input-sm select2" data-placeholder="Yes / No" required>
											<option value="">Select...</option>
											<option value="Yes" @if(old('sent_pin') == 'Yes') selected @endif>Yes</option>
											<option value="No" @if(old('sent_pin') == 'No') selected @endif>No</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Outlet Clinic
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih klinik dokter" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<select name="id_outlet" class="form-control input-sm select2" data-placeholder="Select Outlet Clinic..." required>
											<option value="">Select Outlet Clinic...</option>
											@if(isset($outlet))
												@foreach($outlet as $row)
													<?php
														$selected = '';
														if((isset($doctor) && $doctor['id_outlet'] == $row['id_outlet']) || (!empty($id_outlet) && $id_outlet == $row['id_outlet'])){
															$selected = 'selected';
														}
													?>
													<option value="{{$row['id_outlet']}}" {{$selected}}>{{$row['outlet_name']}}</option>
												@endforeach
											@endif
										</select>
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
									<div class="col-md-7">
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
									<div class="col-md-7">
										<select name="doctor_service[]" id="selectService" class="form-control input-sm select2-multiple select2-hidden-accessible" multiple="multiple" data-placeholder="Select service..." required>
											<option value="">Select Service...</option>
											@if(isset($service))
												@if(isset($doctor) && $doctor['doctor_service'] != null)
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
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Session Price
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan harga sesi" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-4">
										<input type="text" name="doctor_session_price" placeholder="Session Price (Required)" value="{{isset($doctor) ? $doctor['doctor_session_price'] : ''}}" class="form-control price" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Practice Experience
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan jumlah tahun praktek" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="practice_experience" placeholder="Practice Experience Years / Months (Required)" value="{{isset($doctor) ? $doctor['practice_experience'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Practice Experience Place
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan jumlah tahun praktek" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<div class="container1">
											<button class="add_form_field btn btn-success" style="margin-bottom:10px;">Add New Field &nbsp; 
												<span style="font-weight:bold;">+ </span>
											</button>
											@if(isset($doctor) && $doctor['practice_experience_place'] != null)
												@foreach($doctor['practice_experience_place'] as $exp)
													<div><div class="col-md-8" style="margin-bottom:10px;"><input type="text" name="practice_experience_place[]" placeholder="Practice Experience Place (Required)" class="form-control" value="{{$exp}}" required /></div><div class="col-md-4" style="margin-top:10px;"> <a href="#" class="delete">Delete</a> </div></div>
												@endforeach
											@else
												<div><div class="col-md-8"><input type="text" name="practice_experience_place[]" placeholder="Practice Experience Place (Required)" class="form-control" required /></div></div>
											@endif
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Alumni
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan alumni doctor" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="alumni" placeholder="Alumni Doctor (Required)" value="{{isset($doctor) ? $doctor['alumni'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Registration Certificate Number
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Nomor Sertifikat" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="registration_certificate_number" placeholder="Registration Certificate Number (Required)" value="{{isset($doctor) ? $doctor['registration_certificate_number'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Practice Lisence Number
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Surat Izin Praktek" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="practice_lisence_number" placeholder="Practice Lisence Number (Required)" value="{{isset($doctor) ? $doctor['practice_lisence_number'] : ''}}" class="form-control" required />
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
											<span class="required" aria-required="true"> (300*300) </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Foto Professional Dokter" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
												<img src="@if(!empty($doctor['doctor_photo'])) {{env('STORAGE_URL_API').$doctor['doctor_photo']}} @else https://www.cs.emory.edu/site/media/rg5 @endif">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 300px;"> </div>
											<div>
												<span class="btn default btn-file">
													<span class="fileinput-new"> Select image </span>
													<span class="fileinput-exists"> Change </span>
													<input type="file" accept="image/*" id="field_image" class="file" name="doctor_photo" value="{{isset($doctor) ? $doctor['doctor_photo'] : ''}}">
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
			@if(isset($doctor))
			<div class="tab-pane" id="password">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
								<span class="caption-subject bold uppercase">Detail Doctor</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form role="form" class="form-horizontal" action="{{ url('/doctor', $doctor['id_doctor'])}}/update-password"" method="POST" enctype="multipart/form-data">
							@method('PUT')
							<input name="id_doctor" value="{{$doctor['id_doctor']}}" class="form-control hidden" />
							{{ csrf_field() }}
							<div class="form-body">
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Password
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="password" name="pin" placeholder="Minimum 8 digits karakter (Leave empty to autogenerate)" minlength="8" class="form-control mask_number" autocomplete="new-password" required />
									</div>
								</div>
							</div>
							<div class="form-body">
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Re-Type Password
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="password" name="pin" placeholder="Minimum 8 digits karakter (Leave empty to autogenerate)" minlength="8" class="form-control mask_number" required />
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
										<button type="submit" class="btn blue" id="checkBtn">Update</button>
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
@endsection
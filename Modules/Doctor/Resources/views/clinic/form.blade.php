
@extends('layouts.main')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Clinic</a>
		</li>
	</ul>
</div>
<br>
@include('layouts.notifications')
    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Clinic Form</span>
						</div>
					</div>
					<div class="portlet-body">
						@if(isset($clinic))
						<form role="form" class="form-horizontal" action="{{ url('/doctor/clinic', $clinic['id_doctor_clinic'])}}" method="POST">
							@method('PUT')
						@else 
						<form role="form" class="form-horizontal" action="{{ url('doctor/clinic') }}" method="POST">
						@endif
							<div class="form-group col-md-12">
								<label class="control-label col-md-4">Clinic Name
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title=" yang diperoleh user ketika melengkapi data profil" data-container="body"></i>
								</label>
								<div class="fileinput fileinput-new col-md-4">
									@if(isset($clinic))
									<input class="form-control" type="hidden" name="id_doctor_clinic" value="{{$clinic['id_doctor_clinic']}}" required>
									@endif
									<input class="form-control" type="text" name="doctor_clinic_name" value="{{ isset($clinic) ? $clinic['doctor_clinic_name'] : old('doctor_clinic_name') }}" required>
								</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
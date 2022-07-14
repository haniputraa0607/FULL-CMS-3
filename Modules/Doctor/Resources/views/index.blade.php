<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')
@include('filter-v2')

@section('page-style')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dropleft .dropdown-menu{
        	top: -100% !important;
        	left: -180px !important;
        	right: auto;
        }
		.btn-group > .dropdown-menu::after, .dropleft > .dropdown-toggle > .dropdown-menu::after, .dropdown > .dropdown-menu::after {
            opacity: 0;
		}
		.btn-group > .dropdown-menu::before, .dropleft > .dropdown-toggle > .dropdown-menu::before, .dropdown > .dropdown-menu::before {
            opacity: 0;
		}
        .modal-open .select2-container--open { z-index: 999999 !important; width:100% !important; }
    </style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	@yield('filter_script')
<script>
    rules={
        all_transaction:{
            display:'All Doctor',
            operator:[],
            opsi:[]
        },
        doctor_name:{
            display:'Name',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
            placeholder:'Doctor Name'
        },
		doctor_phone:{
            display:'Phone',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
            placeholder:'Doctor Phone'
        },
		outlet:{
            display:'Outlet',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
            placeholder:'Outlet Clinic'
        },
		doctor_session_price:{
            display:'Session Price',
            operator:[
                ['=','='],
                ['<','<'],
                ['>','>'],
                ['<=','<='],
                ['>=','>=']
            ],
            opsi:[],
            placeholder:'Session Price'
        },
    };
    var table;
</script>
	<script>
		function removeDoctor(params, data) {
			var btn = $(params).parent().parent().parent().before().children()
			$.blockUI({ message: '<h1> Please Wait...</h1>' })
			console.log("test");
			$.post( "{{ url('doctor/delete') }}", { id_doctor: data, _token: "{{ csrf_token() }}" })
			.done(function( data ) {
				if (data.status == 'success') {
					toastr.info("Success delete");
				} else {
					toastr.warning(data.messages[0]);
				}
				$('#table-doctor').DataTable().ajax.reload(null, false);
				$.unblockUI();
			});
		}

		$(document).ready(function() {
			$('#table-doctor').dataTable({
				ajax: {
					url : "{{url()->current()}}",
					type: 'GET',
					data: function (data) {
						console.log(data);
						const info = $('#table-doctor').DataTable().page.info();
						data.page = (info.start / info.length) + 1;
					},
					dataSrc: (res) => {
						$('#list-filter-result-counter').text(res.total);
						return res.data;
					}
				},
				serverSide: true,
				columns: [
					{
						data: "doctor_name",
					},
					{
						data: "doctor_phone",
					},
					{
						data: "outlet.outlet_name",
					},
					{
						data: "doctor_session_price", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
					},
					{
						data: "id_doctor",
						render: function(value, type, row) {
							return `
								@if(MyHelper::hasAccess([330], $grantedFeature))
								<a href="{{url('doctor')}}/${value}/edit" class="btn yellow btn-sm" style="margin-bottom:5px">Edit</a>
								@endif
								@if(MyHelper::hasAccess([331], $grantedFeature))
								${row.is_complete ? '' : `<a href="javascript:;" onclick="removeDoctor(this, ${value})" class="btn red btn-sm"> Remove </a>`}
								@endif
							`;
						},
					}
				],
				searching: false
			});
		})
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
	@include('layouts.notifications')
	@yield('filter_view')

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered" >
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase"><i class="fa fa-list"></i> {{$title}} </span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-hover" id="table-doctor">
							<thead>
							<tr>
								<th scope="col"> Name </th>
								<th scope="col"> Phone </th>
								<th scope="col"> Outlet </th>
								<th scope="col"> Session Price</th>
								<th> </th>
							</tr>
							</thead>
							<tbody>
	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
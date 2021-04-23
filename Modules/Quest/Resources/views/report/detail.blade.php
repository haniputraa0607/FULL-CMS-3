@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        td {
            height: 25px;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            datatables();
        });

        function datatables(){
            $("#tbodyListUser").empty();
            var data_display = 10;
            var token  = "{{ csrf_token() }}";
            var url = "{{ url('quest/report/list-user/'.$detail['info']['id_quest_enc']) }}";

            var dt = 0;
            var tab = $.fn.dataTable.isDataTable( '#tableListUser' );
            if(tab){
                $('#tableListUser').DataTable().destroy();
            }

            var data = {
                _token : token
            };

            $('#tableListUser').DataTable( {
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
                    type: "get",
                    data: data,
                    "dataSrc": function (json) {
                        return json.data;
                    }
                }
            });
        }

    </script>
@endsection

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

    @include('layouts.notifications')

    <div class="row">
        <div class="col-md-7">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold uppercase ">Quest Information</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <table>
                        <tr>
                            <td width="60%">Image</td>
                            <td>
                            	<img src="{{ env('STORAGE_URL_API').$detail['info']['image'] }}" style="height: 100px">
                            </td>
                        </tr>
                        <tr>
                            <td width="60%">Name</td>
                            <td>{{ $detail['info']['name'] }}</td>
                        </tr>
                        <tr>
                            <td width="60%">Short Description</td>
                            <td>{{ $detail['info']['short_description'] }}</td>
                        </tr>
                        <tr>
                            <td width="60%">Start Date</td>
                            <td>
                            	{{date('d F Y H:i', strtotime($detail['info']['date_start']))}}
                        	</td>
                        </tr>
                        <tr>
                            <td width="60%">End Date</td>
                            <td>
                            	{{$detail['info']['date_end'] ? date('d F Y H:i', strtotime($detail['info']['date_end'])) : '-'}}
                        	</td>
                        </tr>
                        <tr>
                        	@php
                        		$benefit = null;
                        		switch ($detail['info']['quest_benefit']['benefit_type']) {
                        			case 'voucher':
                        				$benefit = '('.$detail['info']['quest_benefit']['deals']['deals_title'].')';
                        				break;
                        			
                        			default:
                        				$benefit = '('.number_format($detail['info']['quest_benefit']['value'],0,',','.').')';
                        				break;
                        		}
                        	@endphp
                            <td width="60%">Benefit</td>
                            <td>
                            	{{ $detail['info']['quest_benefit']['benefit_type'] }}&nbsp{{ $benefit }}
                            </td>
                        </tr>
                        <tr>
                            <td width="60%">Total Rule</td>
                            <td>{{ $detail['info']['total_rule'] }}</td>
                        </tr>
                        <tr>
                            <td width="60%">Total User</td>
                            <td>{{ $detail['info']['total_user'] }}</td>
                        </tr>
                        <tr>
                            <td width="60%">Total User Complete</td>
                            <td>{{ $detail['info']['total_user_complete'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold uppercase">List User</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <table class="table table-striped table-bordered table-hover" id="tableListUser">
                        <thead>
                        <tr>
                            <th scope="col" width="30%"> Name </th>
                            <th scope="col" width="30%"> Phone </th>
                            <th scope="col" width="30%"> Email </th>
                            <th scope="col" width="30%"> Date Claim </th>
                            <th scope="col" width="30%"> Date Complete </th>
                            <th scope="col" width="10%"> Date Claim Benefit </th>
                            <th scope="col" width="25%"> Status </th>
                            <th scope="col" width="25%"> Claim Benefit Status </th>
                            <th scope="col" width="25%"> Total Rule Complete</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyListUser"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5 profile-info">
        	<div class="profile-info portlet light bordered">
        		<div class="portlet-title"> 
        			<span class="caption font-blue sbold uppercase">{{$detail['info']['name']}} Rule </span>
        		</div>
        		<div class="portlet-body row">
        			@foreach ($detail['rule'] as $item)
        			<div class="col-md-12 profile-info">
        				<div class="profile-info portlet light bordered">
        					<div class="portlet-title"> 
        						<div class="col-md-12" style="display: flex;padding-left: 0px;">
        							<span class="caption font-blue sbold uppercase" style="padding: 8px 0px;font-size: 16px;">
        								{{$item['name']}}
        							</span>
        						</div>
        					</div>
        					<div class="portlet-body">
        						<div class="row" style="padding: 5px;position: relative;">
        							<div class="col-md-12">
        								@if (!is_null($item['id_product_category']) || !is_null($item['different_category_product']))
	        								<div class="row static-info">
	        									<div class="col-md-5 value">Product Category Rule</div>
	        								</div>
	        								<div class="row static-info">
	        									@if (!is_null($item['id_product_category']))
		        									<div class="col-md-5 name">Product Category</div>
		        									<div class="col-md-7 value">: {{$item['product_category']['product_category_name']}}</div>
	        									@endif
	        									@if (!is_null($item['different_category_product']))
		        									<div class="col-md-5 name">Product Category Different ?</div>
		        									@if ($item['different_category_product'] == 0)
		        										<div class="col-md-7 value">: No</div>
		        									@else
		        										<div class="col-md-7 value">: Yes</div>
		        									@endif
	        									@endif
	        								</div>
        								@endif
        								@if (!is_null($item['id_product']) || !is_null($item['product_total']))
	        								<div class="row static-info">
	        									<div class="col-md-5 value">Product Rule</div>
	        								</div>
	        								<div class="row static-info">
	        									@if (!is_null($item['id_product']))
		        									<div class="col-md-5 name">Product</div>
		        									<div class="col-md-7 value">: {{$item['product']['product_name']}}</div>
	        									@endif
	        									@if (!is_null($item['product_total']))
		        									<div class="col-md-5 name">Product Total</div>
		        									<div class="col-md-7 value">: {{$item['product_total']}}</div>
	        									@endif
	        								</div>
        								@endif
        								@if (!is_null($item['id_outlet']) || !is_null($item['different_outlet']))
	        								<div class="row static-info">
	        									<div class="col-md-5 value">Outlet Rule</div>
	        								</div>
	        								<div class="row static-info">
	        									@if (!is_null($item['id_outlet']))
		        									<div class="col-md-5 name">Outlet</div>
		        									<div class="col-md-7 value">: {{$item['outlet']['outlet_name']}}</div>
	        									@endif
	        									@if (!is_null($item['different_outlet']))
		        									<div class="col-md-5 name">Outlet Different ?</div>
		        									@if ($item['different_outlet'] == 0)
			        									<div class="col-md-7 value">: No</div>
			        								@else
			        									<div class="col-md-7 value">: Yes</div>
		        									@endif
	        									@endif
	        								</div>
        								@endif
        								@if (!is_null($item['id_province']) || !is_null($item['different_province']))
        								<div class="row static-info">
        									<div class="col-md-5 value">Province Rule</div>
        								</div>
        								<div class="row static-info">
        									@if (!is_null($item['id_province']))
	        									<div class="col-md-5 name">Province</div>
	        									<div class="col-md-7 value">: {{$item['province']['province_name']}}</div>
	        								@endif
	        								@if (!is_null($item['different_province']))
	        									<div class="col-md-5 name">Province Different ?</div>
	        									@if ($item['different_province'] == 0)
		        									<div class="col-md-7 value">: No</div>
		        								@else
		        									<div class="col-md-7 value">: Yes</div>
	        									@endif
        									@endif
        								</div>
        								@endif
        								@if (!is_null($item['trx_nominal']) || !is_null($item['trx_total']))
	        								<div class="row static-info">
	        									<div class="col-md-5 value">Transaction Rule</div>
	        								</div>
	        								<div class="row static-info">
	        									@if (!is_null($item['trx_nominal']))
		        									<div class="col-md-5 name">Transaction Nominal</div>
		        									<div class="col-md-7 value">: Minimum {{number_format($item['trx_nominal'])}}</div>
		        								@endif
		        								@if (!is_null($item['trx_total']))
		        									<div class="col-md-5 name">Transaction Total</div>
		        									<div class="col-md-7 value">: Minimum {{number_format($item['trx_total'])}}</div>
	        									@endif
	        								</div>
        								@endif
	        							<div class="row static-info">
    										<div class="col-md-5 name">Total User Complete</div>
		        							<div class="col-md-7 value">: {{$item['user_complete']}}</div>
		        						</div>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        			@endforeach
        		</div>
        	</div>
        </div>        
    </div>
@endsection

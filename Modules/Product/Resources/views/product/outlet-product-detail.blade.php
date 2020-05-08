<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');

?>
@extends('layouts.main')

@include('list_filter')
@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	@yield('filter_script')
	<script type="text/javascript">
		rules = {
			all_product:{
				display:'All Product',
				operator:[],
				opsi:[]
			},
			product_code :{
				display:'Code',
				operator:[
					['=','='],
					['like','like']
				],
				opsi:[]
			},
			product_name :{
				display:'Name',
				operator:[
					['=','='],
					['like','like']
				],
				opsi:[]
			},
			product_visibility :{
				display:'Default Visibility',
				operator:[],
				opsi:[
					['Visible','Visible'],
					['Hidden', 'Hidden']
				]
			},
		};
		$('.price').inputmask("numeric", {
			radixPoint: ",",
			groupSeparator: ".",
			digits: 0,
			autoGroup: true,
			rightAlign: false,
			oncleared: function () { self.Value(''); }
		});
		$('#outlet_selector').on('change',function(){
			window.location.href = "{{url('product/outlet-detail')}}/"+$(this).val();
		});
		$('#form-prices').submit(function(){
			$('.price').inputmask('remove');
		});
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

	@yield('filter_view')
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject sbold uppercase font-blue">List Product</span>
			</div>
			<div class="actions">
				<div class="btn-group" style="width: 300px">
					<select class="form-control select2" name="id_outlet" id="outlet_selector" data-placeholder="select outlet">
						@foreach($outlets as $outlet)
							<option value="{{ $outlet['id_outlet'] }}" @if ($outlet['id_outlet'] == $key) selected @endif>{{ $outlet['outlet_code'] }} - {{ $outlet['outlet_name'] }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="portlet-body form">
			<form id="form-prices" action="{{url()->current()}}" method="POST">
				<table class="table table-striped table-bordered table-hover table-responsive" width="100%">
					<thead>
					<tr>
						<th> Category </th>
						<th> Product </th>
						<th> Visible </th>
						<th> Stock </th>
						<th> POS Status </th>
					</tr>
					</thead>
					<tbody>
					@if (!empty($product))
						@foreach ($product as $col => $pro)
							<tr>
								<td>@if(isset($pro['category'][0]['product_category_name'])) {{ $pro['category'][0]['product_category_name'] }} @else Uncategorized @endif</td>
								<td> {{ $pro['product_code'] }} - {{ $pro['product_name'] }} </td>

								@if (!empty($pro['product_detail']))
									@php
										$marker = 0;
									@endphp
									@foreach ($pro['product_detail'] as $dpp)
										@if ($dpp['id_outlet'] == $key)
											@php
												$marker = 1;
											@endphp
											<td style="width:15%">
												<select class="form-control" name="visible[]">
													<option></option>
													<option value="Visible" @if($dpp['product_detail_visibility'] == 'Visible') selected @endif>Visible</option>
													<option value="Hidden" @if($dpp['product_detail_visibility'] == 'Hidden') selected @endif>Hidden</option>
												</select>
											</td>
											<td style="width:15%">
												<select class="form-control" name="product_stock_status[]">
													<option value="Available" @if($dpp['product_detail_stock_status'] == 'Available') selected @endif>Available</option>
													<option value="Sold Out" @if($dpp['product_detail_stock_status'] == 'Sold Out') selected @endif>Sold Out</option>
												</select>
											</td>
											<td style="width:15%">
												<input type="text" value="{{ $dpp['product_detail_status'] }}" class="form-control mt-repeater-input-inline" disabled>
											</td>
										@endif
									@endforeach

									@if ($marker == 0)
										<td style="width: 15%">
											<select class="form-control" name="visible[]">
												<option></option>
												<option value="Visible">Visible</option>
												<option value="Hidden">Hidden</option>
											</select>
										</td>
										<td style="width: 15%">
											<select class="form-control" name="product_stock_status[]">
												<option value="Available">Available</option>
												<option value="Sold Out" selected>Sold Out</option>
											</select>
										</td>
										<td style="width: 15%">
											<input type="text" value="" class="form-control mt-repeater-input-inline" disabled>
										</td>
									@endif
								@else
									<td style="width: 15%">
										<select class="form-control" name="visible[]">
											<option></option>
											<option value="Visible">Visible</option>
											<option value="Hidden" selected>Hidden</option>
										</select>
									</td>
									<td style="width: 15%">
										<select class="form-control" name="product_stock_status[]">
											<option value="Available">Available</option>
											<option value="Sold Out" selected>Sold Out</option>
										</select>
									</td>
									<td style="width: 15%">
										<input type="text" value="" class="form-control mt-repeater-input-inline" disabled>
									</td>
								@endif
							</tr>
							<input type="hidden" name="id_product[]" value="{{ $pro['id_product'] }}">
							<input type="hidden" name="id_outlet" value="{{ $key }}">
						@endforeach
					@endif
					</tbody>
				</table>
				<div class="form-actions">
					{{ csrf_field() }}
					<div class="row">
						@if ($paginator)
							<div class="col-md-10">
								{{ $paginator->links() }}
							</div>
						@endif
						<div class="col-md-2">
							<button type="submit" class="btn blue pull-right" style="margin:10px 0">Save</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection
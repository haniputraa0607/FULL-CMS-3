@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<style>
	.tab-custom{
		border: 1px solid #eef1f5 !important;
	}
	.tab-custom .tab-content{
		padding: 0 !important;
	}
	.tab-content.scroll{
		max-height: 75vh;
		overflow-y: auto;
	}
	.tab-content thead{
		position: sticky;
		top: 0;
		background: white;
		border-bottom: 1px solid grey;
	}
	#slider{
		height: 400px;
		position: relative;
		overflow: hidden;
	}
	#slider .slide{
		width: 100%;
		left: 0;
		top: -150%;
		display: inline-block;
		transition-duration: .5s;
		position: absolute;
	}
	#slider.total_summary #total_summary{
		top: 0;
	}
	#slider.positive_summary #positive_summary{
		top: 0;
	}
	#slider.neutral_summary #neutral_summary{
		top: 0;
	}
	#slider.negative_summary #negative_summary{
		top: 0;
	}
</style>
@endsection

@section('page-script')
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script>
	$(document).ready(function(){		
		$("#start_date").datetimepicker({
			format: "dd MM yyyy",
			autoclose: true,
		});
		$(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) { console.log($(this).data('value')); });
	});
	$(document).ready(function(){		
		$("#end_date").datetimepicker({
			format: "dd MM yyyy",
			autoclose: true,
		});
		$('a.more').on('click',function(){
			moveTo($(this).data('target'));
		});
	});
	$('.checkbox-reload').on('change',function(){
		var name = $(this).attr('name');
		var status = $(this).is(':checked')?1:0;
		$('#dumpInput').attr('name',name).val(status);
		$('#dumpSubmit').click();
	})
</script>

<script type="text/javascript">

	var chart = AmCharts.makeChart("chartdiv", {
		"type": "pie",
		"theme": "light",
		"dataProvider": [
		{
			"name":"positive",
			"total":{{$reportData['rating_item']['1']['feedbacks_count']??[]}},
			"color":"#3598dc"
		},      
		@if($reportData['rating_item_count']==3)
		{
			"name":"neutral",
			"total":{{$reportData['rating_item']['0']['feedbacks_count']??[]}},
			"color":"#E5E5E5"
		},      
		@endif
		{
			"name":"negative",
			"total":{{$reportData['rating_item']['-1']['feedbacks_count']??[]}}, 
			"color":"#e7505a"
		}
		],
		"alignLabels": false,
		"valueField": "total",
		"titleField": "name",
		"colorField": "color",
		"balloon": {
			"fixedPosition": true
		},
		"export": {
			"enabled": false
		},
		"legend": {
		    "useGraphSettings": true,
		    "position": "right"
		},
		"titles": [
		{
			"text": "Feedback Summary",
			"size": 15
		}
		]
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

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-dark sbold uppercase font-blue">Report Feedback Outlet {{$reportData['outlet_data']['outlet_name']}}</span>
		</div>
	</div>
	<div class="portlet-body">
		<form action="{{url()->current()}}" class="form-horizontal" method="POST">
			@csrf
			<div class="row">
				<label class="col-md-2 control-label">Date Start</label>
				<div class="col-md-3">
					<div class="form-group">
						<div class="input-group">
							<input required autocomplete="off" id="start_date" type="text" class="form-control" name="date_start" placeholder="Start Date" value="{{$date_start}}">
							<span class="input-group-btn">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
				<label class="col-md-2 control-label">Date End</label>
				<div class="col-md-3">
					<div class="form-group">
						<div class="input-group">
							<input required autocomplete="off" id="end_date" type="text" class="form-control" name="date_end" placeholder="End Date" value="{{$date_end}}">
							<span class="input-group-btn">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-2"><button class="btn green">Apply</button></div>
			</div>
		</form>
		<div class="row" style="margin-bottom: 20px">
			@php $col = $reportData['rating_item_count']==3?'3':'4' @endphp
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat blue">
					<div class="visual">
						<i class="fa fa-star-o"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{array_sum(array_column($reportData['rating_item'],'feedbacks_count'))}}</span> 
						</div>
						<div class="desc">
							Total Feedback
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-thumbs-o-up"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['rating_item']['1']['feedbacks_count']??0}}</span> 
						</div>
						<div class="desc">
							Positif Feedback
						</div>
					</div>
				</div>
			</div>
			@if($reportData['rating_item_count']==3)
			<div class="col-md-3">
				<div class="dashboard-stat grey">
					<div class="visual">
						<i class="fa fa-hand-paper-o"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['rating_item']['0']['feedbacks_count']??0}}</span> 
						</div>
						<div class="desc">
							Neutral Feedback
						</div>
					</div>
				</div>
			</div>
			@endif
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat red">
					<div class="visual">
						<i class="fa fa-thumbs-o-down"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['rating_item']['-1']['feedbacks_count']??0}}</span> 
						</div>
						<div class="desc">
							Negative Feedback
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="slider" class="total_summary">
			<div class="slide" id="total_summary">
				<div id="chartdiv" style="height: 400px"></div>
			</div>
			<div class="slide" id="positive_summary">
				<div id="chartdiv1" style="height: 400px"></div>
			</div>
			@if($reportData['rating_item_count']==3)
			<div class="slide" id="neutral_summary">
				<div id="chartdiv2" style="height: 400px"></div>
			</div>
			@endif
			<div class="slide" id="negative_summary">
				<div id="chartdiv3" style="height: 400px"></div>
			</div>
		</div>
		<div class="form-group">
			<a href="{{url('user-feedback/report/outlet')}}" class="btn blue">Show All Outlet</a>
			<a href="{{url('user-feedback/report')}}" class="btn blue">Show Summary</a>
		</div>
		<div>
			<div class="hidden">
				<form action="{{url('user-feedback/report')}}" method="POST">
					@csrf
					<input type="text" id="dumpInput">
					<input type="submit" id="dumpSubmit">
				</form>
			</div>
			<div style="width: 136px;padding: 13px 13px 0 0" class="pull-right">
				<div class="md-checkbox">
					<input type="checkbox" id="checkbox1" name="notes_only" class="md-checkboxbtn checkbox-reload" @if($notes_only) checked @endif>
					<label for="checkbox1">
						<span></span>
						<span class="check"></span>
						<span class="box"></span> With notes </label>
						<i class="fa fa-question-circle tooltips" data-original-title="jika dicentang maka akan menampilkan yang mengisikan catatan" data-container="body"></i>
					</label>
				</div>
			</div>
			<div style="width: 145px;padding: 13px 13px 0 0" class="pull-right">
				<div class="md-checkbox">
					<input type="checkbox" id="checkbox2" name="photos_only" class="md-checkboxbtn checkbox-reload" @if($photos_only) checked @endif>
					<label for="checkbox2">
						<span></span>
						<span class="check"></span>
						<span class="box"></span> With photos </label>
						<i class="fa fa-question-circle tooltips" data-original-title="jika dicentang maka akan menampilkan yang melampirkan foto" data-container="body"></i>
					</label>
				</div>
			</div>
		</div>
		<div class="tabbable-line tab-custom">
			<ul class="nav nav-tabs ">
				<li class="active">
					<a href="#tab_positive" data-toggle="tab" aria-expanded="false" data-value="1"> Positive </a>
				</li>
				@if($reportData['rating_item_count']==3)
				<li class="">
					<a href="#tab_neutral" data-toggle="tab" aria-expanded="false" data-value="0"> Neutral </a>
				</li>
				@endif
				<li>
					<a href="#tab_negative" data-toggle="tab" aria-expanded="true" data-value="-1"> Negative </a>
				</li>
			</ul>
			<div class="tab-content scroll">
				<div class="tab-pane active" id="tab_positive" data-value="1">
					<table class="table table-hover table-feedback">
						<thead>
							<tr>
								<th> Create Feedback Date </th>
								<th> Receipt Number </th>
								<th> User </th>
								<th> Grand Total </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							@if($reportData['rating_item']['1']['feedbacks']??false)
							@foreach($reportData['rating_item']['1']['feedbacks'] as $feedback)
							<tr>
								<td>{{date('d M Y',strtotime($feedback['created_at']))}}</td>
								<td><a href="{{url('transaction/detail'.'/'.$feedback['transaction']['id_transaction'].'/'.strtolower($feedback['transaction']['trasaction_type']))}}">{{$feedback['transaction']['transaction_receipt_number']}}</a></td>
								<td><a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a></td>
								<td>Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}</td>
								<td><a href="{{url('user-feedback/detail/'.base64_encode($feedback['id_user_feedback'].'#'.$feedback['transaction']['id_transaction']))}}" class="btn blue">Detail</a></td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="6" class="text-center"><em class="text-muted">No Feedback Found</em></td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
				@if($reportData['rating_item_count']==3)
				<div class="tab-pane" id="tab_neutral" data-value="0">
					<table class="table table-hover table-feedback">
						<thead>
							<tr>
								<th> Create Feedback Date </th>
								<th> Receipt Number </th>
								<th> User </th>
								<th> Grand Total </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							@if($reportData['rating_item']['0']['feedbacks']??false)
							@foreach($reportData['rating_item']['0']['feedbacks'] as $feedback)
							<tr>
								<td>{{date('d M Y',strtotime($feedback['created_at']))}}</td>
								<td><a href="{{url('transaction/detail'.'/'.$feedback['transaction']['id_transaction'].'/'.strtolower($feedback['transaction']['trasaction_type']))}}">{{$feedback['transaction']['transaction_receipt_number']}}</a></td>
								<td><a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a></td>
								<td>Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}</td>
								<td><a href="{{url('user-feedback/detail/'.base64_encode($feedback['id_user_feedback'].'#'.$feedback['transaction']['id_transaction']))}}" class="btn blue">Detail</a></td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="6" class="text-center"><em class="text-muted">No Feedback Found</em></td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
				@endif
				<div class="tab-pane" id="tab_negative" data-value="-1">
					<table class="table table-hover table-feedback">
						<thead>
							<tr>
								<th> Create Feedback Date </th>
								<th> Receipt Number </th>
								<th> User </th>
								<th> Grand Total </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							@if($reportData['rating_item']['-1']['feedbacks']??false)
							@foreach($reportData['rating_item']['-1']['feedbacks'] as $feedback)
							<tr>
								<td>{{date('d M Y',strtotime($feedback['created_at']))}}</td>
								<td><a href="{{url('transaction/detail'.'/'.$feedback['transaction']['id_transaction'].'/'.strtolower($feedback['transaction']['trasaction_type']))}}">{{$feedback['transaction']['transaction_receipt_number']}}</a></td>
								<td><a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a></td>
								<td>Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}</td>
								<td><a href="{{url('user-feedback/detail/'.base64_encode($feedback['id_user_feedback'].'#'.$feedback['transaction']['id_transaction']))}}" class="btn blue">Detail</a></td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="6" class="text-center"><em class="text-muted">No Feedback Found</em></td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
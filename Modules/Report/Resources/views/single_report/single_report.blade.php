@extends('layouts.main')

@section('page-style')
    <link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
    	.table-wrapper{
    		overflow-x: auto;
    	}
    	.cards .number{
    		font-size: 24px;
    	}
    </style>
@stop

@section('page-script')
    <script src="{{ url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	
    <script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    
    <script src="{{ url('assets/global/plugins/amcharts/amcharts4/core.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/amcharts/amcharts4/charts.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/amcharts/amcharts4/themes/animated.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>


    {{-- page scripts --}}
    <script type="text/javascript">
    	{{-- define filter type --}}
    	var time_type = "{{ $filter['time_type'] }}";

    	$('.datepicker').datepicker();
    	$('.select2').select2();
    	
    	$('#time_type').val(time_type).trigger('change');
    	filter_type(time_type);

    	$('#time_type').on('change', function() {
    		time_type = $(this).val();
    		filter_type(time_type);
    	});

    	// change filter based on time_type
    	function filter_type(time_type) {
    		if (time_type == "month") {
    			$('#filter-day').hide();
    			$('#filter-year').hide();
    			$('#filter-month').show();
    		}
    		else if(time_type == "year") {
    			$('#filter-day').hide();
    			$('#filter-month').hide();
    			$('#filter-year').show();
    		}
    		else {
    			$('#filter-year').hide();
    			$('#filter-month').hide();
    			$('#filter-day').show();
    		}
    	}

    	// call ajax when filter change
    	$('.filter-1, .filter-2, .filter-3').on('change', function(e) {
    		time_type = $('#time_type').val();

    		if (time_type == "month") {
    			var start_month = $('#filter-month-1').val();
    			var end_month = $('#filter-month-2').val();
    			var year = $('#filter-month-3').val();

    			if (start_month!="" && end_month!="" && year!="") {
    				if (start_month > end_month) {
    					toastr.warning("End Month should not less than Start Month");
    				}
    				else{
    					ajax_get_report(time_type, start_month, end_month, year);
    				}
    			}
    		}
    		else if (time_type == "year") {
    			var start_year = $('#filter-year-1').val();
    			var end_year = $('#filter-year-2').val();
    			
    			if (year!="") {
    				ajax_get_report(time_type, start_year, end_year);
    			}
    		}
    		else {
    			// day
    			var start_date = $('#filter-day-1').val();
    			var end_date = $('#filter-day-2').val();
    			
    			if (start_date!="" && end_date!="") {
    				if (start_date > end_date) {
    					toastr.warning("End Date should not less than Start Date");
    				}
    				else{
    					ajax_get_report(time_type, start_date, end_date);
    				}
    			}
    		}
    	});

    	function ajax_get_report(time_type, param1, param2, param3=null) {
    		console.log('ajax_get_report ...');
    		$.ajax({
                type : "POST",
                data : {
                	_token : "{{ csrf_token() }}",
                	time_type : time_type,
                	param1 : param1,
                	param2 : param2,
                	param3 : param3
                },
                url : "{{ url('/report/ajax') }}",
                success: function(result) {
                	console.log('result', result);
                    
                    if (result.status == "success") {
                        toastr.info("Success");
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                },
                fail: function(xhr, textStatus, errorThrown){
    				toastr.warning("Something went wrong. Could not fetch data");
			    }
            });
    	}

    	/*===== Transaction scripts =====*/
		// generate trx chart
    	function trx_chart(data) {
    		/* chart */
	    	am4core.useTheme(am4themes_animated);
	    	// create chart instance
			var chart = am4core.create("trx_chart", am4charts.XYChart);
			
			// Increase contrast by taking evey second color
			chart.colors.step = 2;

			chart.data = data;

			// Create axes
			var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
			// dateAxis.renderer.minGridDistance = 50;

			// Create series
			createAxisAndSeries(chart, "total_qty", "Quantity", false);
			createAxisAndSeries(chart, "total_idr", "IDR", true);
			createAxisAndSeries(chart, "kopi_point", "Kopi Point", true);

			// Add cursor
			chart.cursor = new am4charts.XYCursor();

			// Add legend
			chart.legend = new am4charts.Legend();
			chart.legend.position = "top";
    	}

    	// generate chart with multi y axis
	    // series: related with api data properties
    	function multi_axis_chart(data, id_element, series) {
    		/* chart */
	    	am4core.useTheme(am4themes_animated);
	    	// create chart instance
			var chart = am4core.create(id_element, am4charts.XYChart);
			
			// Increase contrast by taking evey second color
			chart.colors.step = 2;

			chart.data = data;

			// Create axes
			var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
			// dateAxis.renderer.minGridDistance = 50;

			// Create series
			jQuery.each(series, function(index, item) {
				createAxisAndSeries(chart, index, item[0], item[1]);
			});
			// createAxisAndSeries(chart, "total_qty", "Quantity", false);
			// createAxisAndSeries(chart, "total_idr", "IDR", true);
			// createAxisAndSeries(chart, "kopi_point", "Kopi Point", true);

			// Add cursor
			chart.cursor = new am4charts.XYCursor();

			// Add legend
			chart.legend = new am4charts.Legend();
			chart.legend.position = "top";
    	}

    	// generate chart with 1 y axis
    	// series: related with api data properties
    	function single_axis_chart(data, id_element, axis_title, series) {
    		/* chart */
	    	am4core.useTheme(am4themes_animated);
	    	// create chart instance
			var chart = am4core.create(id_element, am4charts.XYChart);
			
			// increase contrast by taking evey second color
			chart.colors.step = 2;

			chart.data = data;

			// create date axis
			var dateAxis = chart.xAxes.push(new am4charts.DateAxis());

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inversed = true;
			valueAxis.title.text = axis_title;
			valueAxis.renderer.minLabelPosition = 0.01;

			// Create series
			jQuery.each(series, function(index, item) {
				createSeries(chart, index, item);
			});

			// Add cursor
			chart.cursor = new am4charts.XYCursor();

			// Add legend
			chart.legend = new am4charts.Legend();
			chart.legend.position = "top";
    	}

    	// create line series with multi y axis
		function createAxisAndSeries(chart, field, name, opposite) {
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

			var series = chart.series.push(new am4charts.LineSeries());
			series.dataFields.valueY = field;
			series.dataFields.dateX = "date";
			series.strokeWidth = 2;
			series.yAxis = valueAxis;
			series.name = name;
			series.tooltipText = "{name}: [bold]{valueY}[/]";
			series.tensionX = 0.8;

			var interfaceColors = new am4core.InterfaceColorSet();
			var bullet = series.bullets.push(new am4charts.CircleBullet());
			bullet.circle.stroke = interfaceColors.getFor("background");
			bullet.circle.strokeWidth = 2;

			/*switch(bullet) {
				case "triangle":
					var bullet = series.bullets.push(new am4charts.Bullet());
					bullet.width = 12;
					bullet.height = 12;
					bullet.horizontalCenter = "middle";
					bullet.verticalCenter = "middle";

					var triangle = bullet.createChild(am4core.Triangle);
					triangle.stroke = interfaceColors.getFor("background");
					triangle.strokeWidth = 2;
					triangle.direction = "top";
					triangle.width = 12;
					triangle.height = 12;
					break;
				case "rectangle":
					var bullet = series.bullets.push(new am4charts.Bullet());
					bullet.width = 10;
					bullet.height = 10;
					bullet.horizontalCenter = "middle";
					bullet.verticalCenter = "middle";

					var rectangle = bullet.createChild(am4core.Rectangle);
					rectangle.stroke = interfaceColors.getFor("background");
					rectangle.strokeWidth = 2;
					rectangle.width = 10;
					rectangle.height = 10;
					break;
				default:
					var bullet = series.bullets.push(new am4charts.CircleBullet());
					bullet.circle.stroke = interfaceColors.getFor("background");
					bullet.circle.strokeWidth = 2;
					break;
			}*/

			valueAxis.renderer.line.strokeOpacity = 1;
			valueAxis.renderer.line.strokeWidth = 2;
			valueAxis.renderer.line.stroke = series.stroke;
			valueAxis.renderer.labels.template.fill = series.stroke;
			valueAxis.renderer.opposite = opposite;
			valueAxis.renderer.grid.template.disabled = true;
		}

    	// create line series with one y axis
		function createSeries(chart, field, name) {
			// create series
			var series = chart.series.push(new am4charts.LineSeries());
			series.dataFields.valueY = field;
			series.dataFields.dateX = "date";
			series.name = name;
			series.strokeWidth = 2;
			series.bullets.push(new am4charts.CircleBullet());
			series.tooltipText = "{name}: [bold]{valueY}[/]";
			series.visible  = false;
		}

		// generate chart
		$(document).ready(function(){
	    	var trx_data = {!! json_encode($report['transactions']['trx_chart']) !!};
	    	var trx_gender_data = {!! json_encode($report['transactions']['trx_gender_chart']) !!};
	    	var trx_age_data = {!! json_encode($report['transactions']['trx_age_chart']) !!};
	    	var trx_device_data = {!! json_encode($report['transactions']['trx_device_chart']) !!};
	    	var trx_provider_data = {!! json_encode($report['transactions']['trx_provider_chart']) !!};

	    	var product_data = {!! json_encode($report['products']['product_chart']) !!};
	    	var product_gender_data = {!! json_encode($report['products']['product_gender_chart']) !!};
	    	var product_age_data = {!! json_encode($report['products']['product_age_chart']) !!};
	    	var product_device_data = {!! json_encode($report['products']['product_device_chart']) !!};
	    	var product_provider_data = {!! json_encode($report['products']['product_provider_chart']) !!};

	    	var reg_gender_data = {!! json_encode($report['registrations']['reg_gender_chart']) !!};
	    	var reg_age_data = {!! json_encode($report['registrations']['reg_age_chart']) !!};
	    	var reg_device_data = {!! json_encode($report['registrations']['reg_device_chart']) !!};
	    	var reg_provider_data = {!! json_encode($report['registrations']['reg_provider_chart']) !!};

	    	// series: related with api data properties
			var gender_series = {
				male: "Male",
				female: "Female"
			};
			var age_series = {
				teens: "Teens",
				young_adult: "Young Adult",
				adult: "Adult",
				old: "Old"
			};
			var device_series = {
				android: "Android",
				ios: "iOS"
			};
			var provider_series = {
				telkomsel: "Telkomsel",
				xl: "XL",
				indosat: "Indosat",
				tri: "Tri",
				axis: "Axis",
				smart: "Smart"
			};

			// trx_chart(trx_data);
			var trx_series = {
				total_qty: ["Quantity", false],
				total_idr: ["IDR", true],
				kopi_point: ["Kopi Point", true]
			};
			multi_axis_chart(trx_data, "trx_chart", trx_series);
			single_axis_chart(trx_gender_data, "trx_gender_chart", "Quantity", gender_series)
			single_axis_chart(trx_age_data, "trx_age_chart", "Quantity", age_series)
			single_axis_chart(trx_device_data, "trx_device_chart", "Quantity", device_series);
			single_axis_chart(trx_provider_data, "trx_provider_chart", "Quantity", provider_series);

			/* product charts */
			var product_series = {
				total_rec: ["Total Recurring", false],
				total_qty: ["Quantity", false],
				total_nominal: ["IDR", true]
			};
			multi_axis_chart(product_data, "product_chart", product_series);
			single_axis_chart(product_gender_data, "product_gender_chart", "Quantity", gender_series)
			single_axis_chart(product_age_data, "product_age_chart", "Quantity", age_series)
			single_axis_chart(product_device_data, "product_device_chart", "Quantity", device_series);
			single_axis_chart(product_provider_data, "product_provider_chart", "Quantity", provider_series);

			/* registration charts */
			single_axis_chart(reg_gender_data, "reg_gender_chart", "Quantity", gender_series)
			single_axis_chart(reg_age_data, "reg_age_chart", "Quantity", age_series)
			single_axis_chart(reg_device_data, "reg_device_chart", "Quantity", device_series);
			single_axis_chart(reg_provider_data, "reg_provider_chart", "Quantity", provider_series);
		});

    </script>
@stop

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
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Filter</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="filter-wrapper">
                <div class="row">
                	<div class="col-md-2">
                    	<select id="time_type" class="form-control select2" name="time_type">
							<option value="day" {{ ($filter['time_type']=='day' ? 'selected' : '') }}>Day</option>
							<option value="month" {{ ($filter['time_type']=='month' ? 'selected' : '') }}>Month</option>
							<option value="year" {{ ($filter['time_type']=='year' ? 'selected' : '') }}>Year</option>
						</select>
					</div>
					<div id="filter-day" class="col-md-8" style="padding-left:0; padding-right:0">
	                	<div class="col-md-4">
	                		<div class="input-group">
	                            <input type="text" id="filter-day-1" class="form-control datepicker filter-1" name="start_date" placeholder="Start">
	                            <span class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </span>
	                        </div>
	                	</div>
	                	<div class="col-md-4">
	                		<div class="input-group">
	                            <input type="text" id="filter-day-2" class="form-control datepicker filter-2" name="end_date" placeholder="End">
	                            <span class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </span>
	                        </div>
	                	</div>
	                </div>
					<div id="filter-month" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
	                	<div class="col-md-4">
	                		<select id="filter-month-1" class="form-control select2 filter-1" name="start_month">
								<option value="">Select Month</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
	                	</div>
	                	<div class="col-md-4">
	                		<select id="filter-month-2" class="form-control select2 filter-2" name="end_month">
								<option value="">Select Month</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
	                	</div>
	                	<div class="col-md-4">
	                		<select id="filter-month-3" class="form-control select2 filter-3" name="month_year">
	                			<option value="">Select Year</option>
	                			@foreach($year_list as $year)
	                				<option value="{{ $year }}">{{ $year }}</option>
	                			@endforeach
	                		</select>
	                	</div>
	                </div>
					<div id="filter-year" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
	                	<div class="col-md-4">
	                		<select id="filter-year-1" class="form-control select2 filter-1" name="start_year">
	                			<option value="">Select Year</option>
	                			@foreach($year_list as $year)
	                				<option value="{{ $year }}">{{ $year }}</option>
	                			@endforeach
	                		</select>
	                	</div>
	                	<div class="col-md-4">
	                		<select id="filter-year-2" class="form-control select2 filter-2" name="end_year">
	                			<option value="">Select Year</option>
	                			@foreach($year_list as $year)
	                				<option value="{{ $year }}">{{ $year }}</option>
	                			@endforeach
	                		</select>
	                	</div>
	                </div>
                </div>
            </div>
        </div>
    </div>

    @if(empty($report))
    	<div class="alert alert-warning">
    		Data not found
    	</div>
    @else
    	{{-- Date Range --}}
        @php
            if ($filter['time_type']=='month') {
                $date_range = date('F', strtotime($filter['param1'])) ." - ". date('F', strtotime($filter['param2'])) ." ". $filter['param3'];
            }
            elseif ($filter['time_type']=='year') {
                $date_range = $filter['param1'] ." - ". $filter['param2'];
            }
            else {
                $date_range = date('d M Y', strtotime($filter['param1'])) ." - ". date('d M Y', strtotime($filter['param2']));
            }
        @endphp

	    {{-- Transaction --}}
	    @include('report::single_report._transaction')

	    {{-- Product --}}
	    @include('report::single_report._product')

	    {{-- Customer Registration --}}
	    @include('report::single_report._registration')
	    {{-- <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption ">
	                <span class="caption-subject sbold uppercase font-blue">Customer Registration</span>
	            </div>
	        </div>
	        <div class="portlet-body form">
	            <div class="form-body">
	                <div class="row">
	                </div>
	            </div>
	        </div>
	    </div> --}}

	    {{-- Customer Data --}}
	    {{-- <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption ">
	                <span class="caption-subject sbold uppercase font-blue">Customer Data</span>
	            </div>
	        </div>
	        <div class="portlet-body form">
	            <div class="form-body">
	                <div class="row">
	                </div>
	            </div>
	        </div>
	    </div> --}}

	    {{-- Voucher Redemption --}}
	    {{-- <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption ">
	                <span class="caption-subject sbold uppercase font-blue">Voucher Redemption</span>
	            </div>
	        </div>
	        <div class="portlet-body form">
	            <div class="form-body">
	                <div class="row">
	                </div>
	            </div>
	        </div>
	    </div> --}}
    @endif
@stop
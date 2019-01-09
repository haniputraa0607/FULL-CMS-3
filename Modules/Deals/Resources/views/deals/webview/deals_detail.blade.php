<!DOCTYPE html>
<html>
<head>
	<title>Deals Detail</title>
	<meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <script src="{{ url('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <link href="{{ url('assets/webview/css/pace-flash.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ url('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ url('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ url('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ url('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> 

    <style type="text/css">
        @font-face {
                font-family: "Seravek";
                src: url('{{ url('/fonts/Seravek.ttf') }}');
        }
    	body{
    		background-color: #fff;
    		color: #858585;
            font-family: "Seravek", sans-serif !important;
    	}
    	p{
    		margin-top: 0px !important;
    		margin-bottom: 0px !important;
    	}
    	.deals-detail > div{
    		padding-left: 0px;
    		padding-right: 0px;
    	}
    	.deals-img{
    		width: 100%;
    		height: auto;
    	}
    	.title-wrapper{
    		background-color: #f8f8f8;
    		position: relative;
    		display: flex;
    		align-items: center;
    	}
    	.col-left{
    		flex: 70%;
    	}
    	.col-right{
    		flex: 30%;
    	}
    	.title-wrapper > div{
    		padding: 10px 15px;
    	}
    	.title{
    		font-size: 18px;
    		color: #000;
    	}
    	#timer{
            width: 85px;
    		position: absolute;
    		top: 0px;
    		right: 0px;
    		padding: 5px 15px;
    		border-bottom-left-radius: 7px !important;
    		color: #fff;
            display: none;
    	}
        .bg-red{
            background-color: #c02f2fcc;
        }
        .bg-black{
            background-color: #000c;
        }
    	.fee{
			margin-top: 30px;
			font-size: 18px;
			color: #000;
    	}
    	.description-wrapper,
    	.outlet-wrapper{
    		padding: 15px;
    	}
    	.subtitle{
    		font-weight: 600;
    		margin-bottom: 10px;
    		color: #c0c0c0;
    	}
    	.outlet-city:not(:first-child){
    		margin-top: 10px;
    	}

        @media only screen and (min-width: 768px) {
            /* For mobile phones: */
            .deals-img{
	    		width: auto;
	    		height: auto;
	    	}
        }
    </style>
</head>
<body>
	<div class="deals-detail">
		@if(!empty($deals))
			@php
				$deals = $deals[0];
                if ($deals['deals_voucher_price_cash'] != "") {
                    $deals_fee = "IDR " . $deals['deals_voucher_price_cash'];
                }
                elseif ($deals['deals_voucher_price_point']) {
                    $deals_fee = $deals['deals_voucher_price_point'] . " pts";
                }
                else {
                    $deals_fee = "Free";
                }
			@endphp
			<div class="col-md-4 col-md-offset-4">
				<img class="deals-img center-block" src="{{ $deals['url_deals_image'] }}" alt="">

				<div class="title-wrapper clearfix">
					<div class="col-left title">
						{{ $deals['deals_title'] }}
					</div>
					<div class="col-right">
						<div id="timer" class="text-center"></div>
						<div class="fee text-right">{{ $deals_fee }}</div>
					</div>
				</div>

                @if($deals['deals_description'] != "")
				<div class="description-wrapper">
					<div class="subtitle">DESKRIPSI</div>
					<div class="description">{!! $deals['deals_description'] !!}</div>
				</div>
                @endif

				<div class="outlet-wrapper">
					<div class="subtitle">TERSEDIA DI OUTLET INI</div>
					<div class="outlet">
						@foreach($deals['outlet_by_city'] as $key => $outlet_city)
						<div class="outlet-city">{{ $outlet_city['city_name'] }}</div>
						<ul class="nav">
							@foreach($outlet_city['outlet'] as $key => $outlet)
							<li>- {{ $outlet['outlet_name'] }}</li>
							@endforeach
						</ul>
						@endforeach
					</div>
				</div>

			</div>
		@else
			<div class="col-md-4 col-md-offset-4">
				<h4 class="text-center" style="margin-top: 30px;">Deals is not found</h4>
			</div>
		@endif
	</div>

    {{-- <script type="text/javascript" src="{{ url('assets/global/plugins/jquery.min.js') }}"></script> --}}
    @if(!empty($deals))
        <script type="text/javascript">
            // timer
            var deals_start = "{{ strtotime($deals['deals_start']) }}";
            var deals_end   = "{{ strtotime($deals['deals_end']) }}";
            var server_time = "{{ strtotime($deals['time_server']) }}";
            var timer_text;
            var difference;

            if (server_time >= deals_start && server_time <= deals_end) {
                // deals date is valid and count the timer
                difference = deals_end - server_time;
                document.getElementById('timer').classList.add("bg-red");
            }
            else {
                // deals is not yet start
                difference = deals_start - server_time;
                document.getElementById('timer').classList.add("bg-black");
            }

            var display_flag = 0;
            this.interval = setInterval(() => {
                if(difference >= 0) {
                    timer_text = timer(difference);
                    document.getElementById('timer').innerText = timer_text;
                    // $('#timer').text(timer_text);
                    difference--;
                }
                else {
                    clearInterval(this.interval);
                }

                // if days then stop the timer
                if (timer_text!=null && timer_text.includes("day")) {
                    clearInterval(this.interval);
                }

                // show timer
                if (display_flag == 0) {
                    document.getElementById('timer').style.display = 'block';
                    display_flag = 1;
                }
            }, 1000); // 1 second

            function timer(difference) {
                if(difference === 0) {
                    return null;    // stop the function
                }

                var daysDifference, hoursDifference, minutesDifference, secondsDifference, timer;
                
                // countdown
                daysDifference = Math.floor(difference/60/60/24);
                if (daysDifference > 0) {
                    timer = daysDifference + (daysDifference===1 ? " day" : " days");
                    console.log('timer d', timer);
                }
                else {
                    difference -= daysDifference*60*60*24;

                    hoursDifference = Math.floor(difference/60/60);
                    difference -= hoursDifference*60*60;
                    hoursDifference = ("0" + hoursDifference).slice(-2);

                    minutesDifference = Math.floor(difference/60);
                    difference -= minutesDifference*60;
                    minutesDifference = ("0" + minutesDifference).slice(-2);

                    secondsDifference = Math.floor(difference);

                    if (secondsDifference-1 < 0) {
                        secondsDifference = "00";
                    }
                    else {
                        secondsDifference = secondsDifference-1;
                        secondsDifference = ("0" + secondsDifference).slice(-2);
                    }
                    console.log('timer h', hoursDifference);
                    console.log('timer m', minutesDifference);
                    console.log('timer s', secondsDifference);

                    timer = hoursDifference + ":" + minutesDifference + ":" + secondsDifference;
                    console.log('timer', timer);
                }
                
                return timer;
            }
        </script>
    @endif
</body>
</html>
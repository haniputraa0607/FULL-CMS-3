<?php
    use App\Lib\MyHelper;
    $title = "Deals Detail";
?>
@extends('webview.main')

@section('css')
    <style type="text/css">
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
    		color: #666666;
    	}
    	#timer{
    		position: absolute;
    		top: -25px;
    		right: 0px;
    		padding: 5px 30px;
    		/*border-bottom-left-radius: 7px !important;*/
    		color: #fff;
            display: none;
    	}
        .bg-yellow{
            background-color: #d1af28;
        }
        .bg-red{
            background-color: #c02f2fcc;
        }
        .bg-black{
            background-color: #000c;
        }
        .bg-grey{
            background-color: #cccccc;
        }
    	.fee{
			margin-top: 30px;
			font-size: 18px;
			color: #000;
    	}
    	.description-wrapper{
    		padding: 15px;
    	}
		.outlet-wrapper{
		    padding: 0 15px 15px;
		}
    	.description{
    	    padding-top: 10px;
    	    font-size: 15px;
    	}
    	.subtitle{
    		margin-bottom: 10px;
    		color: #000;
    		font-size: 15px;
    	}
    	.outlet{
    	    font-size: 14.5px;
    	}
    	.outlet-city:not(:first-child){
    		margin-top: 10px;
    	}

    	.voucher{
    	    margin-top: 30px;
    	}
    	.font-red{
    	    color: #990003;
    	}

        @media only screen and (min-width: 768px) {
            /* For mobile phones: */
            .deals-img{
	    		width: auto;
	    		height: auto;
	    	}
        }
    </style>
@stop

@section('content')
	<div class="deals-detail">
		@if(!empty($deals))
			@php
				$deals = $deals[0];
                if ($deals['deals_voucher_price_cash'] != "") {
                    $deals_fee = MyHelper::thousand_number_format($deals['deals_voucher_price_cash']);
                }
                elseif ($deals['deals_voucher_price_point']) {
                    $deals_fee = $deals['deals_voucher_price_point'] . " poin";
                }
                else {
                    $deals_fee = "GRATIS";
                }
			@endphp
			<div class="col-md-4 col-md-offset-4">
				<img class="deals-img center-block" src="{{ $deals['url_deals_image'] }}" alt="">

				<div class="title-wrapper clearfix">
					<div class="col-left voucher font-red">
					    @if($deals['deals_voucher_type'] != 'Unlimited')
						    {{ $deals['deals_total_voucher'] }}/{{ $deals['deals_total_claimed'] }}
						@endif
						kupon tersedia
					</div>
					<div class="col-right">
					    <div id="timer" class="text-center">
					        <span id="timerchild">Bearkhir Dalam</span>
					    </div>
						<div class="fee text-right font-red GoogleSans-Medium">{{ $deals_fee }}</div>
					</div>
				</div>
				<div class="title-wrapper clearfix GoogleSans-Medium">
					<div class="title">
						{{ $deals['deals_title'] }}
						@if($deals['deals_second_title'] != null)
						<br>
						{{ $deals['deals_second_title'] }}
						@endif
					</div>
				</div>

                @if($deals['deals_description'] != "")
				<div class="description-wrapper">
					<div class="description">{!! $deals['deals_description'] !!}</div>
				</div>
                @endif

				<div class="outlet-wrapper">
					<div class="subtitle">Dapat digunakan di outlet:</div>
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
@stop

@section('page-script')
    @if(!empty($deals))
        <script type="text/javascript">
            @php $month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', "Juli", 'Agustus', 'September', 'Oktober', 'November', 'Desember']; @endphp

            // timer
            var deals_start = "{{ strtotime($deals['deals_start']) }}";
            var deals_end   = "{{ strtotime($deals['deals_end']) }}";
            var server_time = "{{ strtotime($deals['time_server']) }}";
            var timer_text;
            var difference;

            if (server_time >= deals_start && server_time <= deals_end) {
                // deals date is valid and count the timer
                difference = deals_end - server_time;
                document.getElementById('timer').classList.add("bg-yellow");
            }
            else {
                // deals is not yet start
                difference = deals_start - server_time;
                document.getElementById('timer').classList.add("bg-grey");
            }

            var display_flag = 0;
            this.interval = setInterval(() => {
                if(difference >= 0) {
                    timer_text = timer(difference);
					@if($deals['deals_status'] == 'available')
					if(timer_text.includes('lagi')){
						document.getElementById("timer").innerHTML = "Berakhir dalam";
					}else{
						document.getElementById("timer").innerHTML = "Berakhir pada";
					}
                    document.getElementById("timer").innerHTML += "<br>";
                    document.getElementById('timer').innerHTML += timer_text;
                    @elseif($deals['deals_status'] == 'soon')
                    document.getElementById("timer").innerHTML = "Akan dimulai pada";
                    document.getElementById("timer").innerHTML += "<br>";
                    document.getElementById('timer').innerHTML += "{{ date('d', strtotime($deals['deals_start'])) }} {{$month[date('m', strtotime($deals['deals_start']))-1]}} {{ date('Y', strtotime($deals['deals_start'])) }} jam {{ date('H:i', strtotime($deals['deals_start'])) }}";
                    @endif

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
					timer = "{{ date('d', strtotime($deals['deals_end'])) }} {{$month[ date('m', strtotime($deals['deals_end']))-1]}} {{ date('Y', strtotime($deals['deals_end'])) }}";
                  //  timer = daysDifference + " hari";
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

                    timer = hoursDifference + ": jam " + minutesDifference + " menit lagi";
                    console.log('timer', timer);
                }

                return timer;
            }
        </script>
    @endif
@stop

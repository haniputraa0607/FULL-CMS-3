<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="{{ url('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="{{ url('css/slide.css') }}" rel="stylesheet">
    
    <!-- SLICK -->
    <link rel="stylesheet" type="text/css" href="{{url('assets/webview/slick-1.8.1/slick/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('assets/webview/slick-1.8.1/slick/slick-theme.css')}}">

    <style type="text/css">
        @font-face {
            font-family: 'Seravek';
            font-style: normal;
            font-weight: 400;
            src: url('{{url("assets/fonts/Seravek.ttf")}}') format('truetype'); 
        }

        @font-face {
            font-family: 'Seravek Light';
            font-style: normal;
            font-weight: 400;
            src: url('{{url("assets/fonts/Seravek-Light.ttf")}}') format('truetype'); 
        }

        .kotak {
            margin : 10px;
            padding: 10px;
            /*margin-right: 15px;*/
            -webkit-box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            -moz-box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            /* border-radius: 3px; */
            background: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .slick-center,  .slick-center > div{
            width: 66.9px !important;
            height: 66.9px !important;
            margin-top: 0 !important;
        }

        .slick-slide {
            width: 50.2px;
            height: 50.2px;
            margin-top: 12.25px;
            margin-bottom: 7px;
            margin-right: 10px;
        }

        .slick-slide > div {
            height: 100%;
        }

        .slick-center > div > .kotak-status,
        .slick-center > div > .kotak-lock {
            margin-top: 3px;
            margin-bottom: 7px;
            padding: 12px;
            transition: all 0.2s ease 0s;
        }

        .slick-center > div > .kotak-status > .img-status{
            width: 42.2px;
        }

        .kotak-status {
            -webkit-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            -moz-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            background: #fff;
            height: 100%;
            margin-right: 10px;
            border-radius: 10px;
            padding: 8px;
            transition: all 0.2s ease 0s;
           
        }

        .img-status{
            width: 31.7px;
        }

        .kotak-lock {
            height: 100%;
            border-radius: 10px;
            margin-right: 10px;
            padding: 15.95px;
            transition: all 0.2s ease 0s;
            opacity: 0.7;
        }

        .img-lock{
            width: 18.3px;
        }

        .slick-center > div > .kotak-lock > .img-lock{
            width: 30px;
        }
        .slick-center > div > .kotak-lock {
            background-size: 42.2px 45.6px, cover !important;
            padding: 18px;
        }

        .progress-bar-status{
            margin: 0 15px;
            width:100%;
            background: transparent;
            display: inline-flex;
        }

        .img-progress{
            height: 26.7px;
            margin-left: -15px;
            margin-top: -5px;
        }

        .progress {
            background-image: linear-gradient(to right, #fff, rgba(108, 86, 72, 0.2)); 
            /* width: {{100-$data['progress_active']}}%; */
            width: calc({{100-$data['progress_active']}}% + 15px);
            height: 13.3px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        
        .progress-active {
            background: #6c5648; 
            width: {{$data['progress_active']}}%;
            height: 13.3px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .progress-now {
            background: #fff;
            border: 0.7px solid #6c5648;
            width: 10px;
            height: 20px;
            border-radius: 10px;
            margin-top: -3px;
        }

        .kotak-full {
            margin-bottom : 15px;
            padding: 10px;
            background: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .kotak-inside {
        	padding-left: 25px;
        	padding-right: 25px
        }

        body {
            background: #ffffff;
        }

        .completed {
            color: green;
        }

        .bold {
            font-weight: bold;
        }

        .space-bottom {
            padding-bottom: 15px;
        }

        .space-top-all {
            padding-top: 15px;
        }

        .space-text {
            padding-bottom: 10px;
        }

        .space-nice {
        	padding-bottom: 20px;
        }

        .space-bottom-big {
        	padding-bottom: 25px;
        }

        .space-top {
        	padding-top: 5px;
        }

        .line-bottom {
            border-bottom: 1px solid rgba(0,0,0,.1);
            margin-bottom: 15px;
        }

        .text-grey {
            color: #aaaaaa;
        }

        .text-much-grey {
            color: #bfbfbf;
        }

        .text-black {
            color: #000000;
        }

        .text-medium-grey {
            color: #806e6e6e;
        }

        .text-grey-white {
            color: #666;
        }

        .text-grey-light {
            color: #b6b6b6;
        }

        .text-grey-medium-light{
            color: #a9a9a9;
        }

        .text-black-grey-light{
            color: #5f5f5f;
        }


        .text-medium-grey-black{
            color: #424242;
        }

        .text-grey-black {
            color: #4c4c4c;
        }

        .text-grey-red {
            color: #9a0404;
        }

        .text-grey-red-cancel {
            color: rgba(154,4,4,1);
        }

        .text-grey-blue {
            color: rgba(0,140,203,1);
        }

        .text-grey-yellow {
            color: rgba(227,159,0,1);
        }

        .text-grey-green {
            color: rgba(4,154,74,1);
        }

        .text-greyish-brown{
            color: #6c5648;
        }

        .seravek-font {
            font-family: 'Seravek';
        }

        .seravek-light-font {
            font-family: 'Seravek Light';
        }

        .text-21-7px {
            font-size: 21.7px;
        }

        .text-16-7px {
            font-size: 16.7px;
        }

        .text-15px {
            font-size: 15px;
        }

        .text-14-3px {
            font-size: 14.3px;
        }

        .text-14px {
            font-size: 14px;
        }

        .text-13-3px {
            font-size: 13.3px;
        }

        .text-12-7px {
            font-size: 12.7px;
        }

        .text-12px {
            font-size: 12px;
        }

        .text-11-7px {
            font-size: 11.7px;
        }

        .round-greyish-brown{
            border: 1px solid #6c5648;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .bg-greyish-brown{
            background: #6c5648;
        }

        .round-white{
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .line-vertical{
            font-size: 5px;
            width:10px;
            margin-right: 3px;
        }

        .inline{
            display: inline-block;
        }

        .vertical-top{
            vertical-align: top;
            padding-top: 5px;
        }

        .top-5px{
            top: -5px;
        }
        .top-10px{
            top: -10px;
        }
        .top-15px{
            top: -15px;
        }
        .top-20px{
            top: -20px;
        }
        .top-25px{
            top: -25px;
        }
        .top-30px{
            top: -30px;
        }

        .label-free{
            background: #6c5648;
            padding: 3px 15px;
            border-radius: 6.7px;
            float: right;
        }

        .text-strikethrough{
            text-decoration:line-through
        }

        .membership-nonaktif{
            content: "";
            display: block;
            padding-top: 100%; 	/* initial ratio of 1:1*/
            background-color: rgba(0,0,0,0.4);
        }

        .membership-nonaktif-bg{
            position:  absolute;
            top: calc((100% - 32px) /2);
            left: 0;
            bottom: 0;
            right: 0;
        }

        .display-inline{
            display: inline-block;
        }

    </style>
  </head>
  <body>

  @php 
    $text = "rupiah";
    if($data['user_membership']['membership_type'] == 'balance'){
        $text = "kopi point";
    }
  @endphp

    <div class="kotak-full" id="list-image">
        <div class="container">
            <div class="row text-center" id="div-now">
                <div class="col-12 text-15px text-greyish-brown seravek-font space-top-all" id="status">
                    @if(isset($data['user_membership']['membership_name'])) 
                        Sekarang :
                    @else
                        Terkunci :
                    @endif
                </div>
                <div class="col-12 text-16-7px text-greyish-brown seravek-font bold" id="status_name">
                    @if(isset($data['user_membership']['membership_name'])) 
                        {{ucfirst($data['user_membership']['membership_name'])}} 
                    @else
                        @if(isset($data['all_membership'][0]['membership_name']))
                            {{ucfirst($data['all_membership'][0]['membership_name'])}} 
                        @endif
                    @endif
                </div>
            </div>
            
            <div class="list-status space-top-all space-bottom" style="display:none">
                @php $now = false; $listStatus = []; $keyStatusNow = 0; @endphp
                
                @if(!isset($data['user_membership']['id_log_membership'])) 
                    @php 
                        $now = true;
                        $data['all_membership'][0]['type2'] = "Sekarang"; 
                    @endphp 
                @endif
                
                @foreach($data['all_membership'] as $key => $membership)
                    @if(isset($data['user_membership']['membership_name']) && $membership['membership_name'] == $data['user_membership']['membership_name'])
                        <div class="kotak-status">
                            <img class="img-responsive img-status" src="{{ $membership['membership_image'] }}">
                        </div>
                        @php 
                            $now = true;
                            $data['all_membership'][$key]['type'] = "Sekarang";
                            $keyStatusNow = $key;
                        @endphp
                    @else
                        @if($now == false)
                            <div class="kotak-lock" style="background: url('{{$membership['membership_image']}}'); 
                                                            background-color: #c1c0c0;
                                                            background-repeat: no-repeat;
                                                            -ms-background-size: 31.7px 34.2px, cover;
                                                            -o-background-size: 31.7px 34.2px, cover;
                                                            -moz-background-size: 31.7px 34.2px, cover;
                                                            -webkit-background-size: 31.7px 34.2px, cover;
                                                            background-size: 31.7px 34.2px, cover;
                                                            background-position: center;">
                            </div>
                            @php 
                                $data['all_membership'][$key]['type'] = "Terbuka";
                            @endphp
                        @else
                            <div class="kotak-lock" style="background: url('{{$membership['membership_image']}}'); 
                                                            background-color: #c1c0c0;
                                                            background-repeat: no-repeat;
                                                            -ms-background-size: 31.7px 34.2px, cover;
                                                            -o-background-size: 31.7px 34.2px, cover;
                                                            -moz-background-size: 31.7px 34.2px, cover;
                                                            -webkit-background-size: 31.7px 34.2px, cover;
                                                            background-size: 31.7px 34.2px, cover;
                                                            background-position: center;">
                                <img class="img-responsive img-lock" src="{{ url('img/webview/lock.png') }}">
                            </div>
                            @php 
                                $data['all_membership'][$key]['type'] = "Terkunci";
                            @endphp
                        @endif
                    @endif
                    @php  $data['all_membership'][$key]['membership_name'] = ucfirst($data['all_membership'][$key]['membership_name']); @endphp
                @endforeach
                
            </div>
        </div>
    </div>

    <div id="detail-membership">
    <div class="kotak-full">
        <div class="container">
            <div class="row">
                <div class="" id="progress-nominal">
                    <div class="text-16px space-top space-bottom seravek-font text-black display-inline status_nominal" style="width:32px;">
                        <img class="img-responsive" style="max-width: 26.7px;" src="{{ url('img/webview/money.png') }}">
                    </div>
                    <div class=" text-16px space-top space-bottom seravek-font text-black display-inline status_nominal" id="status_nominal">
                        {{str_replace(',', '.', number_format($data['user_membership']['user']['progress_now']))}}
                    </div>
                </div>
                <div class="col-12" id="progress-nominal-nopad" style="display:none">
                    <div class="text-16px space-top space-bottom seravek-font text-black display-inline status_nominal" style="width:32px;">
                        <img class="img-responsive" style="max-width: 26.7px;" src="{{ url('img/webview/money.png') }}">
                    </div>
                    <div class=" text-16px space-top space-bottom seravek-font text-black display-inline status_nominal" id="status_nominal">
                        {{str_replace(',', '.', number_format($data['user_membership']['user']['progress_now']))}}
                    </div>
                </div>
                @if($keyStatusNow != count($data['all_membership']) - 1 )
                <div class="progress-bar-status space-text" id="status_progress">
                    <div class="text-14-3px progress-active"></div>
                    <div class="progress-now"></div>
                    <div class="text-14-3px progress"></div>
                    <img class="img-responsive img-progress" src="{{ url('img/webview/icon-heart2.png') }}" style="width:24.7px">
                </div>
                <div class="space-bottom col-12" id="detail-progress">
                <div class="row">
                    <div class="text-16px seravek-font text-black col-6" style="">
                    @if($data['all_membership'][$keyStatusNow]['membership_type'] == "balance")
                    {{number_format($data['all_membership'][$keyStatusNow]['min_total_balance'],0,',','.')}}
                    @elseif($data['all_membership'][$keyStatusNow]['membership_type'] == "count")
                    {{number_format($data['all_membership'][$keyStatusNow]['min_total_count'],0,',','.')}}
                    @else
                    {{number_format($data['all_membership'][$keyStatusNow]['min_total_value'],0,',','.')}}
                    @endif
                    </div>
                    <div class="text-16px seravek-font text-black text-right col-6" style="">
                    @if($data['all_membership'][$keyStatusNow]['membership_type'] == "balance")
                    {{number_format($data['all_membership'][$keyStatusNow+1]['min_total_balance'],0,',','.')}}
                    @elseif($data['all_membership'][$keyStatusNow]['membership_type'] == "count")
                    {{number_format($data['all_membership'][$keyStatusNow+1]['min_total_count'],0,',','.')}}
                    @else
                    {{number_format($data['all_membership'][$keyStatusNow+1]['min_total_value'],0,',','.')}}
                    @endif
                    </div>
                </div>
                </div>
                @endif
                <div class="col-12" id="status_detail">
                    <div class="text-15px space-top space-text seravek-font text-black display-inline" style="width:32px; @if($keyStatusNow == count($data['all_membership']) - 1 ) vertical-align:middle @else vertical-align:top @endif" id="img-cup">
                        <img class="img-responsive" style="max-width: 16.4px;" src="{{ url('img/webview/cup.png') }}">
                    </div>
                    <div class="text-15px space-top space-text seravek-font text-black display-inline" id="status_detail_text">
                        @if($keyStatusNow == count($data['all_membership']) - 1 )
                            Anda sudah mencapai level tertinggi <br>
                        @else
                        {{str_replace(',', '.', number_format($data['next_trx']))}} {{$text}} lagi untuk sampai ke 
                        <br>{{ucfirst($data['next_membership_name'])}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="kotak-full">
        <div class="container">
            <div class="row">
                <div class="col-12 text-16px space-top text-black seravek-font" id="status_benefit_text">
                    Benefit yang didapat saat ini:
                </div>
                <div class="col-12">
                    <div class="text-14px space-top space-bottom display-inline" style="width:32px; vertical-align:top; margin-left:6px">
                        <img class="img-responsive" style="width: 23.3px;" src="{{ url('img/webview/cash.png') }}">
                    </div>
                    <div class="text-16-7px space-top space-bottom seravek-light-font text-black display-inline" id="status_benefit">
                        Cashback sebanyak {{$data['all_membership'][$keyStatusNow]['benefit_cashback_multiplier']}}%
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>

    <script src="{{url('assets/webview/slick-1.8.1/slick/slick.js')}}" type="text/javascript" charset="utf-8"></script>

    <script>
        $(document).ready(function(){

            var heightListImage = $('#list-image').height()+60;
            $('#detail-membership').css('height', 'calc(100vh - '+heightListImage+'px)')

            @if($keyStatusNow != count($data['all_membership']) - 1 )
            $('#progress-nominal').css('padding-left', ' calc({{$data['progress_active']}}% - '+$("#progress-nominal").width()+'px)')
            @else
            $('#progress-nominal').css('padding-left', '15px')
            @endif

            $('.list-status').show();
            $(".list-status").slick({
                centerMode: true,
                slidesToShow: {{count($data['all_membership']) - 1}},
                slidesToScroll: {{count($data['all_membership']) - 2}},
                focusOnSelect: true,
                infinite: false,
                variableWidth: true,
                initialSlide: {{$keyStatusNow}},
                swipeToSlide:true
            });

        });

        // On before slide change
        $('.list-status').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            slideNow = nextSlide
            console.log(slideNow)
            @php $allMembership = json_encode($data['all_membership']); @endphp
            var list_status = <?php echo $allMembership; ?>;

            $('#status').text(list_status[nextSlide]['type']+ ' :')
            $('#status_name').text(list_status[nextSlide]['membership_name'])
            $('#status_benefit').text('Cashback sebanyak '+ list_status[nextSlide]['benefit_cashback_multiplier'] +'%')

            @if($data['user_membership']['membership_type'] == 'value')
                var nominal = list_status[nextSlide]['min_total_value'] - parseInt({{$data['user_membership']['user']['progress_now']}});
            @elseif($data['user_membership']['membership_type'] == 'count')
                var nominal = list_status[nextSlide]['min_total_count'] - parseInt({{$data['user_membership']['user']['progress_now']}});
            @elseif($data['user_membership']['membership_type'] == 'balance')
                var nominal = list_status[nextSlide]['min_total_balance'] - parseInt({{$data['user_membership']['user']['progress_now']}});
            @endif
            var nominal = nominal.toString().replace(/[\D\s\._\-]+/g, "");
            nominal = nominal ? parseInt( nominal, 10 ) : 0;
            nominal = nominal.toLocaleString( "id" );
            $('#status_detail').show()
            if((list_status.length - 1) == nextSlide ){
                $('#status_benefit_text').text('Benefit yang didapat saat ini:')
                if(list_status[nextSlide]['type'] == 'Sekarang'){
                    $('#status_detail_text').text('Anda sudah mencapai level tertinggi')
                }else{
                    $('#status_nominal').text('{{str_replace(',', '.', number_format($data['user_membership']['user']['progress_now']))}}')
                    $('#status_progress').hide()
                    $('#status_detail').show()
                    $('#status_detail_text').html(nominal+ ' {{$text}} lagi untuk sampai ke <br>'+list_status[nextSlide]['membership_name'])
                }
                $('#progress-nominal-nopad').show()
                $('#progress-nominal').hide()
                $('#detail-progress').hide()
            }else{
                if(list_status[nextSlide]['type'] == 'Terkunci' && list_status[nextSlide]['type2'] == undefined){
                    $('#status_benefit_text').text('Benefit yang akan didapat:')
                    $('#status_nominal').text('{{str_replace(',', '.', number_format($data['user_membership']['user']['progress_now']))}}')
                    $('#status_progress').hide()
                    $('#status_detail').show()
                    $('#status_detail_text').html(nominal+ ' {{$text}} lagi untuk sampai ke <br>'+list_status[nextSlide]['membership_name'])
                    $('#progress-nominal-nopad').show()
                    $('#progress-nominal').hide()
                    $('#detail-progress').hide()
                }else{
                    $('#status_nominal').text("{{str_replace(',', '.', number_format($data['user_membership']['user']['progress_now']))}}")
                    if(list_status[nextSlide]['type'] == 'Terbuka'){
                        $('#status_benefit_text').text('Benefit yang didapat:')
                        $('#status_detail_text').text('Anda sudah melewati level ini')
                        $('#status_progress').hide()
                        $('#progress-nominal-nopad').show()
                        $('#progress-nominal').hide()
                        $('#detail-progress').hide()
                    }else{
                        $('#status_benefit_text').text('Benefit yang didapat saat ini:')
                        $('#status_detail_text').html("{{str_replace(',', '.', number_format($data['next_trx']))}} {{$text}} lagi untuk sampai ke <br> {{ucfirst($data['next_membership_name'])}}")
                        $('#status_progress').show()
                        $('#progress-nominal-nopad').hide()
                        $('#progress-nominal').show()
                        $('#detail-progress').show()
                    }
                }
            }
        });

        // credit: http://www.javascriptkit.com/javatutors/touchevents2.shtml
        function swipedetect(el, callback){
        
            var touchsurface = el,
            swipedir,
            startX,
            startY,
            distX,
            distY,
            threshold = 50, //required min distance traveled to be considered swipe
            restraint = 200, // maximum distance allowed at the same time in perpendicular direction
            allowedTime = 1500, // maximum time allowed to travel that distance
            elapsedTime,
            startTime,
            handleswipe = callback || function(swipedir){}

            touchsurface.addEventListener('touchstart', function(e){
                var touchobj = e.changedTouches[0]
                swipedir = 'none'
                dist = 0
                startX = touchobj.pageX
                startY = touchobj.pageY
                startTime = new Date().getTime() // record time when finger first makes contact with surface
                //   e.preventDefault()
            }, false)

            touchsurface.addEventListener('touchmove', function(e){
                //   e.preventDefault() // prevent scrolling when inside DIV
            }, false)

            touchsurface.addEventListener('touchend', function(e){
                var touchobj = e.changedTouches[0]
                distX = touchobj.pageX - startX // get horizontal dist traveled by finger while in contact with surface
                distY = touchobj.pageY - startY // get vertical dist traveled by finger while in contact with surface
                elapsedTime = new Date().getTime() - startTime // get time elapsed
                if (elapsedTime <= allowedTime){ // first condition for awipe met
                    if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){ // 2nd condition for horizontal swipe met
                        swipedir = (distX < 0)? 'left' : 'right' // if dist traveled is negative, it indicates left swipe
                    }
                    else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint){ // 2nd condition for vertical swipe met
                        swipedir = (distY < 0)? 'up' : 'down' // if dist traveled is negative, it indicates up swipe
                    }
                }
                handleswipe(swipedir)
                e.preventDefault()
            }, false)
        }

        //USAGE:
        var slideNow = parseInt('{{$keyStatusNow}}')
        var el = document.getElementById('detail-membership');
        swipedetect(el, function(swipedir){
        // swipedir contains either "none", "left", "right", "top", or "down"
        //   el.innerHTML = 'Swiped <span style="color:yellow;margin: 0 5px;">' + swipedir +'</span>';
            
            console.log(swipedir)
            if(swipedir == 'left'){
                if(slideNow < {{count($data['all_membership'])}}){
                    slideNow++
                    $(".list-status").slick('slickGoTo',slideNow);
                }
            }else if(swipedir == 'right'){
                if(slideNow > 0){
                    slideNow--
                    $(".list-status").slick('slickGoTo',slideNow);
                }
            }
        });


    </script>
  </body>
</html>
!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <script src="{{ asset('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <link href="{{ asset('assets/webview/css/pace-flash.css') }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap/bootstrap-4.1.3/css/bootstrap.min.css') }}">
        {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}

        <style type="text/css">
            @font-face {
                font-family: "Seravek";
                src: url('{{ url('/fonts/Seravek.ttf') }}');
            }
            @font-face {
                font-family: 'Seravek Light';
                font-style: normal;
                font-weight: 400;
                src: url('{{url("assets/fonts/Seravek-Light.ttf")}}') format('truetype'); 
            }

            @font-face {
                font-family: 'Seravek Medium';
                font-style: normal;
                font-weight: 400;
                src: url('{{url("assets/fonts/Seravek-Medium.ttf")}}') format('truetype'); 
            }

            .seravek-light-font {
                font-family: 'Seravek Light';
            }

            .seravek-medium-font {
                font-family: 'Seravek Medium';
            }

            body{
                background-color: #fff;
                color: #858585;
                font-family: "Seravek", sans-serif !important;
                font-size: 14px;
            }
            .pace .pace-progress{
                top: 0;
            }
            .pace .pace-activity{
                top: 15px;
                border-radius: 10px !important;
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
                padding-top: 15px;
                padding-bottom: 12px;
            }
            .title{
                font-size: 18px;
                color: #000;
            }
            .valid-date{
                margin-top: 7px;
                font-size: 13.3px;
                color: #666666;
            }
            .description-wrapper,
            .outlet-wrapper{
                padding: 7px 20px;
            }
            .subtitle{
                margin-bottom: 6px;
                color: #b8b8b8;
                font-size: 13.3px;
            }
            .subtitle2{
                margin-bottom: 20px;
                color: #aaa;
                font-size: 13.3px;
            }
            .description-wrapper .subtitle{
                margin-bottom: 5px;
            }
            .outlet-city:not(:first-child){
                margin-top: 10px;
            }

            .outlet{
                font-size: 13.3px;
                color: #666666;
            }
            .outlet .nav{
                flex-direction: column;
            }

            .deals-qr {
                background: #fff;
                width: 135px;
                height: 135px;
                margin: 0 auto;
            }

            .kode-text{
                color: #aaaaaa;
                font-size: 15px;
                margin-top: 20px;
                margin-bottom: 10px;
            }
            .voucher-code{
                color: #6c5648;
                font-size: 20px;
                margin-bottom: 15px;
            }
            .line{
                background-image: linear-gradient(to right, transparent 50%, #b8b8b8 50%);
                background-size: 7px 100%;
                width: 100%;
                height: 1px;
            }
            .space-bottom{
                margin-bottom:20px;
            }
           
            #qr-code-modal{
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0,0,0, 0.5);
                /*width: 100%;*/
                /*height: 100vh;*/
                display: none;
                z-index: 999;
                overflow-y: auto;
            }
            #qr-code-modal-content{
                position: absolute;
                left: 50%;
                top: 50%;
                margin-left: -155px;
                margin-top: -155px;
                padding: 30px;
                background: #fff;
                border-radius: 42.3px;
                border: 0;
            }
        </style>
    </head>

    <body>
        @if(!empty($voucher))
            @php
                $voucher = $voucher[0];
                if ($voucher['deal_voucher']['deal'] != "") {
                    $deals = $voucher['deal_voucher']['deal'];
                }
                // separate date & time
                $voucher_expired = date('d/m/Y H:i', strtotime($voucher['voucher_expired_at']));
                $voucher_expired = explode(" ", $voucher_expired);
                $voucher_expired_date = $voucher_expired[0];
                $voucher_expired_time = $voucher_expired[1];
            @endphp

            <!-- Modal QR Code -->
            @if($voucher['redeemed_at'] != null && $voucher['used_at'] == null)
            <a id="qr-code-modal" href="#">
                <div id="qr-code-modal-content">
                    <img class="img-responsive" src="{{ $voucher['voucher_hash'] }}">
                </div>
            </a>
            @endif

            <div class="deals-detail">
                <div class="col-md-4 offset-md-4">
                    <img class="deals-img center-block" src="{{ $deals['url_deals_image'] }}" alt="">

                    <div class="title-wrapper clearfix container">
                        <div class="col-xs-8 title">
                            {{ $deals['deals_title'] }}
                        </div>

                        @if($voucher['used_at'] == null)
                        <div class="col-xs-12 valid-date">
                            Berlaku hingga {{ $voucher_expired_date }} <span style="margin-left: 10px;">{{ $voucher_expired_time }}</span>
                        </div>
                        @endif
                    </div>

                    @if($voucher['redeemed_at'] != null && $voucher['used_at'] == null)
                    <div class="description-wrapper">
                        <div class="subtitle2 text-center" style="margin-top: 15px;">Tampilkan Kode QR di bawah ke kasir</div>

                        <div class="deals-qr">
                            <img class="img-responsive" style="display: block; max-width: 100%;" src="{{ $voucher['voucher_hash'] }}">
                        </div>

                        <div class="text-center kode-text">Kode Kupon</div>
                        <div class="text-center voucher-code seravek-medium-font">{{ $voucher['deal_voucher']['voucher_code'] }}</div>
                        <div class="line"></div>
                    </div>
                    @endif

                    @if($deals['deals_description'] != "")
                    <div class="description-wrapper">
                        <div class="subtitle seravek-light-font">DESKRIPSI</div>
                        <div class="description seravek-light-font">{!! $deals['deals_description'] !!}</div>
                    </div>
                    @endif

                    <div class="outlet-wrapper space-bottom">
                        <div class="subtitle seravek-light-font">
                        @if($voucher['redeemed_at'] != null)
                            OUTLET
                        @else
                            TERSEDIA DI OUTLET INI
                        @endif
                        </div>
                        <div class="outlet seravek-light-font">
                            @if($voucher['redeemed_at'] != null)
                                @if(isset($voucher['outlet_name']))
                                {{$voucher['outlet_name']}}
                                @endif
                            @else
                                @foreach($deals['outlet_by_city'] as $key => $outlet_city)
                                    @if(isset($outlet_city['city_name']))
                                    <div class="outlet-city">{{ $outlet_city['city_name'] }}</div>
                                    @elseif($key!=0)
                                    <br>
                                    @endif
                                    <ul class="nav">
                                        @foreach($outlet_city['outlet'] as $key => $outlet)
                                        <li>- {{ $outlet['outlet_name'] }}</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <button type="button" class="btn btn-primary" style="background-color:white;color:white;outline-style:none;border-color:white">INVALIDATE</button>
        @else
            <div class="deals-detail">
                <div class="col-md-4 col-md-offset-4">
                    <div class="text-center" style="margin-top: 20px;">Voucher is not found</div>
                </div>
            </div>
        @endif


       
        <script type="text/javascript" src="{{ url('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Bootstrap JS -->
        {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
        <script src="{{ asset('assets/global/plugins/bootstrap/bootstrap-4.1.3/js/bootstrap.min.js') }}"></script>
        {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> --}}
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.deals-qr', function(e) {
                    e.preventDefault();
                    $('#qr-code-modal').fadeIn('fast');
                    $('.deals-detail').css({'height': '100vh', 'overflow-y':'scroll'});

                    // send flag to native
                    var url = window.location.href;
                    var result = url.replace("#true", "");
                    result = result.replace("#false", "");
                    result = result.replace("#", "");
    
                    window.location.href = result + '#true';
                });

                $(document).on('click', '#qr-code-modal', function() {
                    $('#qr-code-modal').fadeOut('fast');
                    $('.deals-detail').attr('style', '');

                    // send flag to native
                    var url = window.location.href;
                    var result = url.replace("#true", "");
                    result = result.replace("#false", "");
                    result = result.replace("#", "");

                    window.location.href = result + '#false';
                });
            });
        </script>

    </body>
</html>
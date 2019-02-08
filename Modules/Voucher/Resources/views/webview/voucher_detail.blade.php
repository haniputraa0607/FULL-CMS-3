<?php
    $title = "Voucher Detail";
?>
@extends('webview.main')

@section('css')
    <style type="text/css">
        body{
            max-width: 468px;
            margin: auto;
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
            margin-bottom: 10px;
        }
        .valid-date{
            font-size: 13.3px;
            color: #666666;
        }
        .description-wrapper,
        .outlet-wrapper{
            padding: 10px 20px;
        }
        .subtitle{
            margin-bottom: 10px;
            color: #b8b8b8;
            font-size: 13.3px;
        }
        .subtitle2{
            margin-bottom: 20px;
            color: #aaa;
            font-size: 13.3px;
        }
        .outlet-city:not(:first-child){
            margin-top: 10px;
        }

        .outlet{
            font-size: 13.3px;
            color: #666666;
        }

        @media only screen and (min-width: 768px) {
            /* For mobile phones: */
            .deals-img{
                width: auto;
                height: auto;
            }
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

        .deals-qr{
            width: 135px;
            height: 135px;
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
    </style>
@stop

@section('content')
    <div class="deals-detail">
        @if(!empty($voucher))
            @php
                $voucher = $voucher[0];
                if ($voucher['deal_voucher']['deal'] != "") {
                    $deals = $voucher['deal_voucher']['deal'];
                }
            @endphp
            <div class="col-md-4 col-md-offset-4">
                <img class="deals-img center-block" src="{{ $deals['url_deals_image'] }}" alt="">

                <div class="title-wrapper clearfix">
                    <div class="col-xs-8 title">
                        {{ $deals['deals_title'] }}
                    </div>
                    <div class="col-xs-12 valid-date">
                        Berlaku hingga {{ date('d/m/Y H:i', strtotime($voucher['voucher_expired_at'])) }}
                    </div>
                </div>

                @if($voucher['redeemed_at'] != null)
                <div class="description-wrapper">
                    <div class="subtitle2 text-center">Tampilkan Kode QR di bawah ke kasir</div>
                    <img class="deals-qr center-block" src="{{ $voucher['voucher_hash'] }}" alt="">
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
                            <div class="outlet-city">{{ $outlet_city['city_name'] }}</div>
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
        @else
            <div class="col-md-4 col-md-offset-4">
                <h4 class="text-center">Voucher is not found</h4>
            </div>
        @endif
    </div>
@stop
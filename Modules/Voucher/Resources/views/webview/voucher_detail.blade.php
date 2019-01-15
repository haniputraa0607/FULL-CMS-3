<?php
    $title = "Voucher Detail";
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
            padding-top: 15px;
            padding-bottom: 12px;
        }
        .title{
            font-size: 18px;
            color: #000;
            margin-bottom: 10px;
        }
        .valid-date{
            font-size: 13px;
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
                <h4 class="text-center">Voucher is not found</h4>
            </div>
        @endif
    </div>
@stop
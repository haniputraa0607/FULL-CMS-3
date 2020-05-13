@section('sub-page-style')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style type="text/css">
        @font-face {
            font-family: 'Seravek';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Seravek Light';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek-Light.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Seravek Medium';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek-Medium.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Seravek Italic';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek-Italic.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Roboto Regular';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Roboto-Regular.ttf")}}') format('truetype');
        }

        .swal-text {
            text-align: center;
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

        .kotak-qr {
            -webkit-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            -moz-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            background: #fff;
            width: 130px;
            height: 130px;
            margin: 0 auto;
            border-radius: 20px;
            padding: 10px;
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
            background: #fafafa;
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

        .text-grey-white-light {
            color: #b8b8b8;
        }

        .text-greyish-brown{
            color: #6c5648;
        }

        .open-sans-font {
            font-family: 'Open Sans', sans-serif;
        }

        .questrial-font {
            font-family: 'Questrial', sans-serif;
        }

        .seravek-font {
            font-family: 'Seravek';
        }

        .seravek-light-font {
            font-family: 'Seravek Light';
        }

        .seravek-medium-font {
            font-family: 'Seravek Medium';
        }

        .seravek-italic-font {
            font-family: 'Seravek Italic';
        }

        .roboto-regular-font {
            font-family: 'Roboto Regular';
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
            border-radius: 50% !important;
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

        #modal-usaha {
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0,0,0, 0.5);
            width: 100%;
            display: none;
            height: 100vh;
            z-index: 999;
        }

        .modal-usaha-content {
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -125px;
            margin-top: -125px;
        }

        .kotak-full.pending{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#aaa;
        }

        .kotak-full.on_going{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#ef9219;
        }

        .kotak-full.complated{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#fff;
        }

        .kotak-full.ready{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#15977b;
        }

        .kotak-full.pending .text-greyish-brown,
        .kotak-full.on_going .text-greyish-brown,
        .kotak-full.ready .text-greyish-brown,

        .kotak-full.pending .text-grey-white-light,
        .kotak-full.on_going .text-grey-white-light,
        .kotak-full.ready .text-grey-white-light
        {
            color:#fff;
        }

        .kotak-full.redbg{
            margin-top:-10px;
            background-color:#c10100;
        }

        .kotak-full.redbg #content-taken{
            text-transform : uppercase;
            color:#fff;
            text-align:center;
            padding:10px;
        }

        @media (min-width: 1200px) {
        .container {
        max-width: 1170px; } }

        .page-header{
            position: fixed;
        }

        .page-logo {
            margin-right:auto;
        }

    </style>
@endsection

@section('sub-content')
@php $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
<div style="max-width: 480px; margin: auto">
    @if ($data['trasaction_type'] != 'Offline')
        @if(isset($data['detail']['pickup_by']) && $data['detail']['pickup_by'] == 'GO-SEND')
            <div class="kotak-biasa">
                <div class="container">
                    <?php
                    if (isset($data['transaction_payment_status']) && $data['transaction_payment_status'] == 'Cancelled') {
                        $html = '<div class="kotak-full" style="background-color: #de2f1f;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                        $html .= '<div class="container">';
                        $html .= '<div class="row text-center">';
                        $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER ANDA DIBATALKAN</b></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        echo $html;
                    } elseif(isset($data['detail']['reject_at']) && $data['detail']['reject_at'] != null) {
                        $html = '<div class="kotak-full" style="background-color: #de2f1f;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                        $html .= '<div class="container">';
                        $html .= '<div class="row text-center">';
                        $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER ANDA DITOLAK</b></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        echo $html;
                    } elseif(isset($data['detail']['taken_by_system_at']) && $data['detail']['taken_by_system_at'] != null) {
                        $html = '<div class="kotak-full" style="background-color: #383567;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                        $html .= '<div class="container">';
                        $html .= '<div class="row text-center">';
                        $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SELESAI</b></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        echo $html;
                    } elseif(isset($data['detail']['taken_at']) && $data['detail']['taken_at'] != null) {
                        $html = '<div class="kotak-full" style="background-color: #eab208;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                        $html .= '<div class="container">';
                        $html .= '<div class="row text-center">';
                        $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SUDAH DITERIMA</b></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        echo $html;
                    } elseif(isset($data['detail']['ready_at']) && $data['detail']['ready_at'] != null) {
                        $html = '<div class="kotak-full" style="background-color: #eab208;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                        $html .= '<div class="container">';
                        $html .= '<div class="row text-center">';
                        $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SUDAH SIAP</b></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        echo $html;
                    } elseif(isset($data['detail']['receive_at']) && $data['detail']['receive_at'] != null) {
                        $html = '<div class="kotak-full" style="background-color: #df8f17;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                        $html .= '<div class="container">';
                        $html .= '<div class="row text-center">';
                        $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SEDANG DIPROSES</b></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        echo $html;
                    } else {
                        $html = '<div class="kotak-full" style="background-color: #df8f17;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                        $html .= '<div class="container">';
                        $html .= '<div class="row text-center">';
                        $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER PENDING</b></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        echo $html;
                    }
                    ?>
                <div class="container">
                    <div class="row text-center">
                        <div class="col-12 WorkSans text-15px space-nice text-grey">Detail Pengiriman</div>
                        <div class="col-12 text-red text-21-7px space-bottom WorkSans-Medium">GO-SEND</div>
                        <div class="col-12 text-16-7px text-black space-bottom WorkSans">
                            {{ $data['detail']['transaction_pickup_go_send']['destination_name'] }}
                            <br>
                            {{ $data['detail']['transaction_pickup_go_send']['destination_phone'] }}
                        </div>
                        <div class="kotak-inside col-12">
                            <div class="col-12 text-13-3px text-grey-white space-nice text-center WorkSans">{{ $data['detail']['transaction_pickup_go_send']['destination_address'] }}</div>
                        </div>
                        <div class="col-12 text-15px space-bottom text-black WorkSans">Map</div>
                        <div class="col-12 space-bottom-big">
                            <div class="container">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="kotak-biasa" style="background-color: #FFFFFF;box-shadow: 0 0.7px 3.3px #eeeeee;">
                <div class="container" style="padding: 0px;">
                        <?php
                        if (isset($data['transaction_payment_status']) && $data['transaction_payment_status'] == 'Cancelled') {
                            $html = '<div class="kotak-full" style="background-color: #de2f1f;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                            $html .= '<div class="container">';
                            $html .= '<div class="row text-center">';
                            $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER ANDA DIBATALKAN</b></div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';

                            echo $html;
                        } elseif(isset($data['detail']['reject_at']) && $data['detail']['reject_at'] != null) {
                            $html = '<div class="kotak-full" style="background-color: #de2f1f;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                            $html .= '<div class="container">';
                            $html .= '<div class="row text-center">';
                            $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER ANDA DITOLAK</b></div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';

                            echo $html;
                        } elseif(isset($data['detail']['taken_by_system_at']) && $data['detail']['taken_by_system_at'] != null) {
                            $html = '<div class="kotak-full" style="background-color: #383567;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                            $html .= '<div class="container">';
                            $html .= '<div class="row text-center">';
                            $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SELESAI</b></div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';

                            echo $html;
                        } elseif(isset($data['detail']['taken_at']) && $data['detail']['taken_at'] != null) {
                            $html = '<div class="kotak-full" style="background-color: #eab208;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                            $html .= '<div class="container">';
                            $html .= '<div class="row text-center">';
                            $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SUDAH DITERIMA</b></div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';

                            echo $html;
                        } elseif(isset($data['detail']['ready_at']) && $data['detail']['ready_at'] != null) {
                            $html = '<div class="kotak-full" style="background-color: #eab208;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                            $html .= '<div class="container">';
                            $html .= '<div class="row text-center">';
                            $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SUDAH SIAP</b></div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';

                            echo $html;
                        } elseif(isset($data['detail']['receive_at']) && $data['detail']['receive_at'] != null) {
                            $html = '<div class="kotak-full" style="background-color: #df8f17;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                            $html .= '<div class="container">';
                            $html .= '<div class="row text-center">';
                            $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER SEDANG DIPROSES</b></div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';

                            echo $html;
                        } else {
                            $html = '<div class="kotak-full" style="background-color: #df8f17;margin-bottom: 0px;box-shadow: 0 3.3px 6.7px #b3b3b3;">';
                            $html .= '<div class="container">';
                            $html .= '<div class="row text-center">';
                            $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: #ffffff"><b>ORDER PENDING</b></div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';

                            echo $html;
                        }
                        ?>
                    <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
                        <div class="container">
                            <div class="row text-center">
                                <div class="col-12 text-15px text-black-grey-light space-text WorkSans-Bold">{{ $data['outlet']['outlet_name'] }}</div>
                                <div class="kotak-inside col-12">
                                    <div class="col-12 text-11-7px text-grey-white space-nice text-center WorkSans">{{ $data['outlet']['outlet_address'] }}</div>
                                </div>
                                <div class="col-12 WorkSans-Bold text-14px space-text text-black-grey-light">Kode Pickup Anda</div>

                                <div style="width: 135px;height: 135px;margin: 0 auto;" data-toggle="modal" data-target="#exampleModal">
                                    <div class="col-12 text-14-3px space-top"><img class="img-responsive" style="display: block; max-width: 100%; padding-top: 10px" src="{{ $data['detail']['order_id_qrcode'] }}"></div>
                                </div>
                                <div class="col-12 text-black-grey-light text-20px WorkSans-SemiBold">{{ $data['detail']['order_id'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="container">
                <div class="row text-center">
                    @if(isset($data['admin']))
                        <div class="col-12 text-16-7px text-black space-text WorkSans">{{ strtoupper($data['user']['name']) }}</div>
                        <div class="col-12 text-16-7px text-black WorkSans space-nice">{{ $data['user']['phone'] }}</div>
                    @endif
                    <div class="col-12 text-13-3px space-nice text-black-grey-light WorkSans-Medium" style="padding-bottom: 10px;">
                        @if ($data['detail']['pickup_type'] == 'set time')
                            Pesanan Anda akan siap pada
                        @else
                            Pesanan Anda akan diproses pada
                        @endif
                    </div>
                    <div class="col-12 text-14px space-text text-black-grey-light WorkSans-SemiBold" style="padding-bottom: 20px;">{{ date('d', strtotime($data['transaction_date'])) }} {{ $bulan[date('n', strtotime($data['transaction_date']))] }} {{ date('Y', strtotime($data['transaction_date'])) }}</div>
                    <div class="col-12 text-15px space-nice text-black-grey-light WorkSans-Bold" style="padding-bottom: 8.3px;">PICK UP</div>
                    <div class="col-12 text-21-7px WorkSans-Bold" style="color: #a6ba35;">
                        @if ($data['detail']['pickup_type'] == 'set time')
                            {{ date('H:i', strtotime($data['detail']['pickup_at'])) }}
                        @elseif($data['detail']['pickup_type'] == 'at arrival')
                            SAAT KEDATANGAN
                        @else
                            SAAT INI
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @else
        @if(isset($data['admin']) && isset($data['user']['name']))
            <div class="kotak-biasa space-top-all">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-12 text-16-7px text-black space-text WorkSans">{{ strtoupper($data['user']['name']) }}</div>
                        <div class="col-12 text-16-7px text-black WorkSans space-nice">{{ $data['user']['phone'] }}</div>

                    </div>
                </div>
            </div>
        @endif
    @endif

    <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
        <div class="row space-bottom">
            <div class="col-4 text-black-grey-light text-14px WorkSans-Bold">Transaksi</div>
            <div class="col-8 text-grey-white text-right text-medium-grey text-11-7px WorkSans">{{ date('d', strtotime($data['transaction_date'])) }} {{ $bulan[date('n', strtotime($data['transaction_date']))] }} {{ date('Y H:i', strtotime($data['transaction_date'])) }}</div>
        </div>
        <div class="row space-text">
            <div class="col-4"></div>
            <div class="col-8 text-right text-black-grey-light text-13-3px WorkSans-SemiBold">#{{ $data['transaction_receipt_number'] }}</div>
        </div>
        <div class="kotak" style="margin: 0px;border-radius: 10px;">
            <div class="row">
                @foreach ($data['product_transaction'] as $trx)
                    <div class="col-2 text-14px WorkSans text-black">
                        <div class="round-grey bg-grey" style="background: #aaaaaa;"></div>
                    </div>
                    <div class="col-10 text-14px WorkSans-SemiBold text-black" style="margin-left: -30px;margin-bottom: 10px;">{{$trx['brand']}}</div>
                    @foreach ($trx['product'] as $prod)
                        <div class="col-2 text-13-3px WorkSans-SemiBold text-black">{{$prod['transaction_product_qty']}}x</div>
                        <div class="col-6 text-14px WorkSans-SemiBold text-black" style="margin-left: -30px;margin-right: 20px;">{{$prod['product']['product_name']}}</div>
                        <div class="col-4 text-13-3px text-right WorkSans-SemiBold text-black">{{ str_replace(',', '.', explode('.',$prod['transaction_product_subtotal'])[0]) }}</div>
                        @if(isset($prod['product']['product_modifiers']))
                            @foreach($prod['product']['product_modifiers'] as $mod)
                                <div class="col-2 text-13-3px WorkSans-SemiBold text-black"></div>
                                <div class="col-6 text-14px WorkSans-SemiBold text-black" style="margin-left: -30px;margin-right: 20px;color: darkgrey;font-size: 11px;">{{$mod['product_modifier_name']}}</div>
                                <div class="col-4 text-13-3px text-right WorkSans-SemiBold text-black"></div>
                            @endforeach
                        @endif
                    @endforeach
                    @if ($trx != end($data['product_transaction']))
                        <div class="col-12">
                            <hr style="border-top: 1px solid #eeeeee;">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
        <div class="row space-bottom">
            <div class="col-12 text-14px WorkSans-Bold text-black">Detail Pembayaran</div>
        </div>
        <div class="kotak" style="margin: 0px;margin-top: 10px;border-radius: 10px;">
            @foreach($data['payment_detail'] as $dt)
                <div class="row">
                    <div class="col-6 text-13-3px WorkSans-SemiBold text-black ">{{$dt['name']}} ({{$dt['desc']}})</div>
                    @if(is_numeric(strpos(strtolower($dt['name']), 'discount')))
                        <div class="col-6 text-13-3px text-right WorkSans-SemiBold text-black" style="color:#a6ba35;">{{ str_replace(',', '.', $dt['amount']) }}</div>
                    @else
                        <div class="col-6 text-13-3px text-right WorkSans-SemiBold text-black">{{ str_replace(',', '.', $dt['amount']) }}</div>
                    @endif

                </div>
            @endforeach
        </div>

        <div style="margin: 0px;margin-top: 10px;padding: 10px;background: #f0f3f7;">
            <div class="row">
                <div class="col-6 text-13-3px WorkSans-SemiBold text-black ">Grand Total</div>
                @if(isset($data['balance']))
                    <div class="col-6 text-13-3px text-right WorkSans-SemiBold text-black">{{ str_replace(',', '.', $data['transaction_grandtotal'] - $data['balance']) }}</div>
                @else
                    <div class="col-6 text-13-3px text-right WorkSans-SemiBold text-black">{{ str_replace(',', '.', $data['transaction_grandtotal']) }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
        <div class="row space-bottom">
            <div class="col-12 text-14px WorkSans-SemiBold text-black">Metode Pembayaran</div>
        </div>
        <div class="kotak" style="margin: 0px;margin-top: 10px;border-radius: 10px;">
            <div class="row">
                @foreach($data['transaction_payment']??[] as $dt)
                    <div class="col-6 text-13-3px WorkSans-SemiBold text-black ">{{$dt['name']}}</div>
                    <div class="col-6 text-13-3px text-right WorkSans-SemiBold text-black">{{ str_replace(',', '.', explode('.',$dt['amount'])[0]) }}</div>
                @endforeach
            </div>
        </div>
    </div>

    @if ($data['trasaction_type'] != 'Offline')
        <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="row space-bottom">
                <div class="col-12 text-14px WorkSans-Bold text-black">Status Pesanan</div>
            </div>
            <div class="kotak" style="margin: 0px;margin-top: 10px;border-radius: 10px;">
                <div class="row">
                    <?php
                        $i = 1;
                        $count = count($data['detail']['detail_status']);
                        foreach ($data['detail']['detail_status'] as $status){
                            if($i == 1 ){
                                $html = '<div class="col-12 text-13-3px WorkSans-Medium text-black">';
                                $html .= '<div class="round-grey bg-grey"></div>';
                                $html .= $status['text'];
                                $html .= '</div>';
                                $html .= '<div class="inline vertical-top">';
                                $html .= '<div class="col-12 text-11-7px WorkSans text-black space-bottom" style="margin-left: 10%">';
                                $html .= $status['date'];
                                $html .= '</div>';
                                $html .= '</div>';

                                echo $html;
                            }else{
                                $html = '<div class="col-12 text-13-3px WorkSans-Medium text-black">';
                                $html .= '<div class="round-green bg-green2"></div>';
                                $html .= $status['text'];
                                $html .= '</div>';
                                $html .= '<div class="inline vertical-top">';
                                $html .= '<div class="col-12 text-11-7px WorkSans text-black space-bottom" style="margin-left: 10%">';
                                $html .= $status['date'];
                                $html .= '</div>';
                                $html .= '</div>';

                                echo $html;
                            }
                            $i++;
                        }
                    ?>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
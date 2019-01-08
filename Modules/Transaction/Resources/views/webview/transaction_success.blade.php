<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Questrial" rel="stylesheet">
    <link href="{{ url('css/slide.css') }}" rel="stylesheet">
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

        @font-face {
            font-family: 'Seravek Medium';
            font-style: normal;
            font-weight: 400;
            src: url('{{url("assets/fonts/Seravek-Medium.ttf")}}') format('truetype'); 
        }

        @font-face {
            font-family: 'Seravek Italic';
            font-style: normal;
            font-weight: 400;
            src: url('{{url("assets/fonts/Seravek-Italic.ttf")}}') format('truetype'); 
        }

        @font-face {
            font-family: 'Roboto Regular';
            font-style: normal;
            font-weight: 400;
            src: url('{{url("assets/fonts/Roboto-Regular.ttf")}}') format('truetype'); 
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

    </style>
  </head>
  <body>
    @php
        // print_r($data);die();
    @endphp

    @if ($data['trasaction_payment_type'] != 'Offline')
        <div class="kotak-full">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 text-13-3px text-black roboto-regular-font">
                        Terima kasih! Pembayaran sudah diterima.
                    </div>
                    <div class="col-12 text-13-3px text-black roboto-regular-font">
                        Kami akan memberikan notifikasi
                    </div>
                    <div class="col-12 text-13-3px text-black roboto-regular-font">
                        apabila pesanan Anda sudah selesai.
                    </div>
                </div>
            </div>
        </div>

        <div class="kotak-biasa">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 roboto-regular-font text-15px space-text text-grey">Kode Pickup Anda</div>
                    
                    <div class="kotak-qr">
                        <div class="col-12 text-14-3px space-top"><img class="img-responsive" style="display: block; max-width: 100%; padding-top: 10px" src="{{ $data['qr'] }}"></div>
                    </div>

                    <div class="col-12 text-greyish-brown text-21-7px space-bottom space-top-all seravek-medium-font">{{ $data['detail']['order_id'] }}</div>
                    <div class="col-12 text-16-7px text-black space-text seravek-light-font">{{ $data['outlet']['outlet_name'] }}</div>
                    <div class="kotak-inside col-12">
                        <div class="col-12 text-13-3px text-grey-white space-nice text-center ">{{ $data['outlet']['outlet_address'] }}</div>
                    </div>
                        <div class="col-12 text-16-7px space-nice text-black seravek-light-font">Pesanan Anda akan diproses pada</div>
                        <div class="col-12 text-16-7px space-text text-greyish-brown seravek-medium-font">{{ date('d F Y', strtotime($data['detail']['pickup_at'])) }}</div>
                    @if ($data['detail']['pickup_type'] == 'set time')
                        <div class="col-12 text-21-7px space-nice text-greyish-brown seravek-medium-font">{{ date('H:i', strtotime($data['detail']['pickup_at'])) }}</div>
                    @elseif($data['detail']['pickup_type'] == 'at arrival')
                        <div class="col-12 text-21-7px space-nice text-greyish-brown seravek-medium-font">Saat Kedatangan</div>
                    @else
                        <div class="col-12 text-21-7px space-nice text-greyish-brown seravek-medium-font">Saat Ini</div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="kotak">
        <div class="container line-bottom">
            <div class="row space-bottom">
                <div class="col-6 text-grey-black text-14-3px seravek-text">{{ $data['outlet']['outlet_name'] }}</div>
                <div class="col-6 text-right text-medium-grey text-13-3px seravek-light-font">{{ date('d F Y H:i', strtotime($data['transaction_date'])) }}</div>
            </div>
            <div class="row space-text">
                <div class="col-4"></div>
                <div class="col-8 text-right text-medium-grey-black text-13-3px seravek-font">#{{ $data['transaction_receipt_number'] }}</div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-13-3px text-grey-light seravek-light-font">
                    Transaksi Anda 
                    <hr style="margin:10px 0 20px 0">
                </div>
                @php $countQty = 0; @endphp
                @foreach ($data['product_transaction'] as $key => $val)
                    <div class="col-7 text-13-3px text-black seravek-light-font">{{ $val['product']['product_name'] }}</div>
                    <div class="col-5 text-right text-13-3px text-black seravek-light-font">{{ str_replace(',', '.', number_format($val['transaction_product_subtotal'])) }}</div>
                    <div class="col-12 text-grey text-12-7px text-black-grey-light seravek-light-font">{{ $val['transaction_product_qty'] }} x {{ str_replace(',', '.', number_format($val['transaction_product_price'])) }}</div>
                    <div class="space-bottom col-12">
                        <div class="space-bottom text-12-7px text-grey-medium-light seravek-italic-font">
                            @if (isset($val['transaction_product_note']))
                                {{ $val['transaction_product_note'] }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    @php $countQty += $val['transaction_product_qty']; @endphp
                @endforeach

                <div class="col-12 text-12-7px text-right"><hr style="margin:0"></div>
                <div class="col-6 text-13-3px space-bottom space-top-all text-black seravek-font">SubTotal ({{$countQty}} item)</div>
                <div class="col-6 text-13-3px space-bottom space-top-all text-black text-right seravek-font">{{ str_replace(',', '.', number_format($data['transaction_subtotal'])) }}</div>
            </div>
        </div>
    </div>

    <div class="kotak">
        <div class="container">
            <div class="row">
                <div class="col-12 text-14-3px space-top seravek-font text-greyish-brown">Detail Pembayaran <hr> </div>
                <div class="col-6 text-13-3px space-text seravek-light-font text-black">SubTotal ({{$countQty}} item)</div>
                <div class="col-6 text-13-3px text-right space-text seravek-light-font text-grey-black">{{ number_format($data['transaction_subtotal']) }}</div>

                <div class="col-6 text-13-3px space-text seravek-light-font text-black">Tax</div>
                <div class="col-6 text-13-3px text-right seravek-light-font text-grey-black">{{ number_format($data['transaction_tax']) }}</div>

                <!-- <div class="col-6 text-13-3px space-text seravek-light-font">Kopi Points</div>
                <div class="col-6 text-13-3px text-right seravek-light-font text-greyish-brown">-{{ number_format($data['transaction_tax']) }}</div> -->

                <div class="col-12 text-12-7px text-right"><hr></div>
                <div class="col-6 text-13-3px seravek-font text-black ">Total Pembayaran</div>
                <div class="col-6 text-13-3px text-right seravek-font text-black">{{ number_format($data['transaction_grandtotal']) }}</div>
            </div>
        </div>
    </div>

    @if ($data['transaction_payment_status'] == 'Completed'|| $data['transaction_payment_status'] == 'Paid')
        <div class="kotak">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-14-3px space-top text-greyish-brown seravek-font">Metode Pembayaran <hr> </div>
                    <div class="col-6 text-13-3px seravek-font text-black">
                        @if ($data['trasaction_payment_type'] == 'Balance') 
                            Kopi Points
                        @elseif ($data['trasaction_payment_type'] == 'Midtrans') 
                            Online Payment
                        @elseif ($data['trasaction_payment_type'] == 'Manual')
                            Transfer Bank
                        @elseif ($data['trasaction_payment_type'] == 'Offline')
                            TUNAI 
                        @endif
                    </div>
                    <div class="col-6 text-12-7px text-right">
                    @if ($data['trasaction_payment_type'] == 'Offline')
                        SELESAI
                    @else
                        LUNAS
                    @endif
                    </div>
                    @if (isset($data['payment']['payment_type']))
                        <div class="col-6 text-grey text-12-7px">{{ $data['payment']['payment_type'] }}</div>
                    @endif

                    @if (isset($data['payment']['payment_method']))
                        <div class="col-6 text-grey text-12-7px">{{ $data['payment']['payment_method'] }}</div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="kotak">
        <div class="container">
            <div class="row">
                <div class="col-12 text-14-3px space-top text-greyish-brown seravek-font">Status Pesanan <hr> </div>
                @php $top = 5; $bg = true; @endphp
                @if($data['detail']['ready_at'] != null)
                    <div class="col-12 text-13-3px seravek-font text-black">
                        <div class="round-greyish-brown bg-greyish-brown"></div>
                        Pesanan Anda sudah siap
                    </div>
                    <div class="col-12 top-5px">
                        <div class="inline text-center">
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                        </div>
                        <div class="inline vertical-top">
                            <div class="text-11-7px seravek-light-font text-black space-bottom">
                                {{date('d F Y H:i', strtotime($data['detail']['ready_at']))}}
                            </div>
                        </div>
                    </div>
                    @php $top += 5; $bg = false; @endphp
                @endif
                @if($data['detail']['receive_at'] != null)
                    <div class="col-12 text-13-3px seravek-font text-black top-{{$top}}px">
                        <div class="round-greyish-brown @if($bg) bg-greyish-brown @endif"></div>
                            Pesanan Anda sedang diproses
                    </div>
                    @php $top += 5; $bg = false; @endphp
                    <div class="col-12 top-{{$top}}px">
                        <div class="inline text-center">
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                        </div>
                        <div class="inline vertical-top">
                            <div class="text-11-7px seravek-light-font text-black space-bottom">
                                {{date('d F Y H:i', strtotime($data['detail']['receive_at']))}}
                            </div>
                        </div>
                    </div>
                    @php $top += 5; @endphp
                    <div class="col-12 text-13-3px seravek-font text-black top-{{$top}}px">
                        <div class="round-greyish-brown @if($bg) bg-greyish-brown @endif"></div>
                        Pesanan Anda sudah diterima
                    </div>
                    @php $top += 5; $bg = false; @endphp
                    <div class="col-12 top-{{$top}}px">
                        <div class="inline text-center">
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                            <div class="line-vertical text-grey-medium-light">|</div>
                        </div>
                        <div class="inline vertical-top">
                            <div class="text-11-7px seravek-light-font text-black space-bottom">
                                {{date('d F Y H:i', strtotime($data['detail']['receive_at']))}}
                            </div>
                        </div>
                    </div>
                    @php $top += 5; @endphp
                @endif
                <div class="col-12 text-13-3px seravek-font text-black top-{{$top}}px">
                    <div class="round-greyish-brown @if($bg) bg-greyish-brown @endif"></div>
                    Pesanan Anda Menunggu Konfirmasi
                </div>
                <div class="col-12 text-11-7px seravek-light-font text-black space-bottom top-{{$top}}px">
                    <div class="round-white"></div>
                    {{date('d F Y H:i', strtotime($data['transaction_date']))}}
                </div>
            </div>
        </div>
    </div>
   
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
    
  </body>
</html>
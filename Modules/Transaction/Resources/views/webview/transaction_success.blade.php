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
        .kotak {
            margin : 10px;
            padding: 10px;
            /*margin-right: 15px;*/
            -webkit-box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            -moz-box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            border-radius: 3px;
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

        .space-top {
            padding-top: 15px;
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
            border-bottom: 1px solid #eee;
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

        .open-sans-font {
            font-family: 'Open Sans', sans-serif;
        }

        .questrial-font {
            font-family: 'Questrial', sans-serif;
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

    </style>
  </head>
  <body>
    @php
        // print_r($data);die();
    @endphp
    <div class="kotak-full">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 text-14-3px">Terima kasih. Kami telah menerima <br> pembayaran Anda</div>
            </div>
        </div>
    </div>

    <div class="kotak-biasa">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 questrial-font text-15px space-text text-grey">Kode Pickup Anda</div>
                
                <div class="kotak-qr">
                    <div class="col-12 text-14-3px space-top"><img class="img-responsive" style="display: block; max-width: 100%; padding-top: 10px" src="{{ $data['qr'] }}"></div>
                </div>

                <div class="col-12 text-black text-21-7px questrial-font space-bottom space-top-all">{{ $data['detail']['order_id'] }}</div>
                <div class="col-12 text-15px space-text">{{ $data['outlet']['outlet_name'] }}</div>
                <div class="kotak-inside col-12">
                	<div class="col-12 text-13-3px text-grey-black space-nice text-center">{{ $data['outlet']['outlet_address'] }}</div>
                </div>
                @if ($data['detail']['pickup_type'] == 'set time')
                    <div class="col-12 text-15px space-nice">Pesanan Anda akan siap pada</div>
                    <div class="col-12 text-15px space-nice">{{ date('d F Y', strtotime($data['detail']['pickup_at'])) }}</div>
                    <div class="col-12 text-15px space-nice">{{ date('H:i', strtotime($data['detail']['pickup_at'])) }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="kotak-full">
        <div class="container">
            <div class="row">
                <div class="col-12 text-14-3px space-top">Detail Pemesanan <hr></div>

                @foreach ($data['product_transaction'] as $key => $val)
                    <div class="col-6 text-14px">{{ $val['product']['product_name'] }}</div>
                    <div class="col-6 text-right text-grey-white">{{ $val['transaction_product_qty'] }}</div>
                    @if (isset($val['transaction_product_note']))
                        <div class="col-6 text-grey text-12-7px">({{ $val['transaction_product_note'] }})</div>
                    @endif
                    <div class="col-6 text-12-7px text-right">IDR {{ number_format($val['transaction_product_price']) }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="kotak-full">
        <div class="container">
            <div class="row">
                <div class="col-12 text-14-3px space-top">Detail Pembayaran <hr> </div>
                <div class="col-6 text-14px space-text">Total Keranjang</div>
                <div class="col-6 text-12-7px text-right space-text">IDR {{ number_format($data['transaction_subtotal']) }}</div>

                <div class="col-6 text-14px space-text">Service Charge ({{ number_format($data['valueService']) }}%)</div>
                <div class="col-6 text-12-7px text-right space-text">IDR {{ number_format($data['transaction_service']) }}</div>

                <div class="col-6 text-14px space-text">Tax ({{ number_format($data['valueTax']) }}%)</div>
                <div class="col-6 text-12-7px text-right">IDR {{ number_format($data['transaction_tax']) }}</div>

                <div class="col-12 text-12-7px text-right"><hr></div>
                <div class="col-6 text-14px">Total Pembayaran</div>
                <div class="col-6 text-12-7px text-right">IDR {{ number_format($data['transaction_grandtotal']) }}</div>
            </div>
        </div>
    </div>

    @if ($data['transaction_payment_status'] == 'Completed'|| $data['transaction_payment_status'] == 'Paid')
        <div class="kotak-full">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-14-3px space-top">Metode Pembayaran <hr> </div>
                    <div class="col-6 text-14px">@if ($data['trasaction_payment_type'] == 'Balance') BALANCE @endif @if ($data['trasaction_payment_type'] == 'Midtrans') ONLINE PAYMENT @endif @if ($data['trasaction_payment_type'] == 'Manual')TRANSFER BANK @endif</div>
                    <div class="col-6 text-12-7px text-right">DIBAYAR</div>
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

    <div class="kotak-full">
        <div class="container">
            <div class="row">
                <div class="col-4 text-14-3px space-top text-grey-black">Tanggal</div>
                <div class="col-8 text-14-3px space-top text-right">{{ date('d F Y H:i', strtotime($data['created_at'])) }}</div>
                <div class="col-12"><hr> </div>

                <div class="col-6 text-14-3px text-grey-black">ID Transaksi</div>
                <div class="col-6 text-14-3px text-right">15857</div>
                <div class="col-12"><hr> </div>
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
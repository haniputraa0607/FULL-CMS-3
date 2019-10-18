<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="{{ env('S3_URL_VIEW') }}{{('css/slide.css') }}" rel="stylesheet">
    <style type="text/css">

        @font-face {
                font-family: "GoogleSans";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('S3_URL_VIEW') }}{{ ('/fonts/GoogleSans-Regular.ttf') }}');
        }
        .GoogleSans{
            font-family: "GoogleSans";
        }
        .kotak {
            margin : 10px;
            padding: 10px;
            /*margin-right: 15px;*/
            -webkit-box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            -moz-box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            border-radius: 3px;
            background: #fff;
            font-family: 'GoogleSans';
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

        .space-bottom20 {
            padding-bottom: 20px;
        }

        .space-top {
            padding-top: 15px;
        }

        .space-text {
            padding-bottom: 10px;
        }

        .line-bottom {
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }

        .text-grey {
            color: #aaaaaa;
        }
        .text-grey2 {
            color: #b6b6b6;
        }

        .text-much-grey {
            color: #bfbfbf;
        }

        .text-black {
            color: #000000;
        }

        .text-red {
            color: #990003;
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
    {{ csrf_field() }}
    @php
        // print_r($data);die();
    @endphp
    <div class="kotak">
        <div class="container line-bottom">
            <div class="row space-bottom">
                <div class="col-6 text-grey-black text-14-3px">Beli Kupon</div>
                @php $bulan = ['', 'Januari', 'Februari','Maret','April','Mei','Juni','Juli','Agustus','September','November','Desember']; @endphp
                <div class="col-6 text-right text-medium-grey text-13-3px">{{ date('d', strtotime($data['date'])) }} {{$bulan[date('n', strtotime($data['date']))]}} {{date('Y H:i', strtotime($data['date'])) }}</div>
            </div>
            <div class="row space-text">
                <div class="col-4"></div>
                <div class="col-8 text-right text-grey-black bold text-13-3px">#{{ $data['deal_voucher']['voucher_code'] }}</div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-grey2 text-13-3px">Transaksi Anda</div>
                <div class="col-12"><hr></div>
            </div>
            {{-- @foreach ($data['product_transaction'] as $key => $pro) --}}
                <div class="row">
                    <div class="col-6 text-black text-13-3px">{{ $data['deal_voucher']['deal']['deals_title'] }}</div>
                    <div class="col-6 text-right text-black text-13-3px">@if (!empty($data['voucher_price_cash']))  {{ str_replace(',', '.', number_format($data['voucher_price_cash'])) }} @else {{ str_replace(',', '.', number_format($data['voucher_price_point'])) }} @endif</div>
                </div>
                <div class="row">
                    @if($data['deal_voucher']['deal']['deals_second_title'])
                    <div class="col-6 text-black text-13-3px">{{ $data['deal_voucher']['deal']['deals_second_title'] }}</div>
                    @endif
                </div>
                <div class="row space-bottom">
                    <div class="col-12 text-grey-white text-13-3px">1 x @if (!empty($data['voucher_price_cash']))  {{ str_replace(',', '.', number_format($data['voucher_price_cash'])) }} @else {{ str_replace(',', '.', number_format($data['voucher_price_point'])) }} @endif</div>
                </div>
            {{-- @endforeach --}}
            <hr>
            <div class="row">
                <div class="col-6 text-13-3px text-black">Subtotal (1 item)</div>
                <div class="col-6 text-right text-14px text-black">@if (!empty($data['voucher_price_cash']))  {{ str_replace(',', '.', number_format($data['voucher_price_cash'])) }} @else {{ str_replace(',', '.', number_format($data['voucher_price_point'])) }} @endif</div>
                <div class="col-12"><hr></div>
            </div>

        </div>
    </div>

    <div class="kotak">
        <div class="container">
            <div class="row">
                <div class="col-6 text-red text-13-3px">Detail Pembayaran</div>
                <div class="col-12"><hr></div>
            </div>
            <div class="row space-bottom20">
                <div class="col-6 text-13-3px text-grey-black">Subtotal (1 item)</div>
                <div class="col-6 text-right text-13-3px text-grey-black">@if (!empty($data['voucher_price_cash']))  {{ str_replace(',', '.', number_format($data['voucher_price_cash'])) }} @else {{ str_replace(',', '.', number_format($data['voucher_price_point'])) }} @endif</div>

            </div>
            @if (!empty($data['balance_nominal']))
                <div class="row">
                    <div class="col-6 text-14px text-grey-black">Panda Poin</div>
                    <div class="col-6 text-right text-14px text-grey-red">-  {{ str_replace(',', '.', number_format($data['balance_nominal'])) }}</div>
                    <div class="col-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-6 text-14px text-grey-black">Total Pembayaran</div>
                    <div class="col-6 text-right text-14px text-grey-black">
                     @if(!empty($data['voucher_price_cash']))
                        {{ str_replace(',', '.', number_format($data['voucher_price_cash']-$data['balance_nominal'])) }}
                    @else
                        {{ str_replace(',', '.', number_format($data['balance_nominal'])) }}
                    @endif
                    </div>
                    <div class="col-12"><hr></div>
                </div>
            @else
                <div class="row space-text">
                    <div class="col-6 text-14px text-grey-black">Total Pembayaran</div>
                    <div class="col-6 text-right text-14px text-grey-black">
                        @if (!empty($data['voucher_price_cash']))
                            @if(isset($data['payment']['gross_amount']))
                                {{ str_replace(',', '.', number_format($data['payment']['gross_amount'])) }}
                            @else
                                {{ str_replace(',', '.', number_format($data['voucher_price_cash'])) }}
                            @endif
                        @else
                            {{ str_replace(',', '.', number_format($data['voucher_price_point'])) }}
                        @endif</div>
                </div>
            @endif
        </div>
    </div>

    @if ($data['paid_status'] == 'Completed'|| $data['paid_status'] == 'Paid')
        <div class="kotak">
            <div class="container">
                <div class="row">
                    <div class="col-6 questrial-font text-black text-14-3px">Metode Pembayaran</div>
                    <div class="col-12"><hr></div>
                </div>
                <div class="row space-bottom">
                    <div class="col-6 text-black text-13-3px">@if ($data['payment_method'] == 'Balance') Panda Poin @endif @if(isset($data['payment']['payment_type'])) {{$data['payment']['payment_type']}} @else @if ($data['payment_method'] == 'Midtrans') ONLINE PAYMENT @endif @if ($data['payment_method'] == 'Manual') BANK TRANSFER @endif @endif</div>
                    {{--<div class="col-6 text-right text-black text-13-3px">@if ($data['payment_method'] == 'Balance')  {{ str_replace(',', '.', number_format(abs($data['balance_nominal']))) }} @else @if (!empty($data['voucher_price_cash'])) @if(isset($data['balance'])) @php $data['voucher_price_cash'] + $data['balance'];  @endphp @endif  {{ str_replace(',', '.', number_format($data['voucher_price_cash'])) }} @else {{ str_replace(',', '.', number_format($data['voucher_price_point'])) }} @endif @endif</div>--}}
                    <div class="col-6 text-right text-balck text-13-3px">@if ($data['paid_status'] == 'Completed') LUNAS @elseif ($data['paid_status'] == 'Pending') Pending @elseif ($data['paid_status'] == 'Paid') DIBAYAR @elseif ($data['paid_status'] == 'Cancelled') DIABATALKAN @elseif ($data['paid_status'] == 'Free') GRATIS @endif</div>


                    @if (isset($data['payment']['payment_method']))
                         <div class="col-12 text-black text-11-7px">{{ $data['payment']['payment_method'] }}</div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{--
    <div class="kotak">
        <div class="container">
            <div class="row">
                <div class="col-6 questrial-font text-black text-14px">Status Pembayaran</div>
            </div><hr>
            <div class="row space-bottom">
                <div class="col-12 @if ($data['paid_status'] == 'Completed' || $data['paid_status'] == 'Free') text-grey-green @endif @if ($data['paid_status'] == 'Pending') text-grey-yellow @endif @if ($data['paid_status'] == 'Paid') text-grey-blue @endif @if ($data['paid_status'] == 'Cancelled') text-grey-red-cancel @endif text-12-7px">{{ $data['paid_status'] }}</div>
                <div class="col-12 text-much-grey text-11-7px">@if ($data['paid_status'] == 'Completed') Your payment completed @endif @if ($data['paid_status'] == 'Pending') Please pay your order to continue process order @endif @if ($data['paid_status'] == 'Paid') Please wait for admin confirmation @endif @if ($data['paid_status'] == 'Cancelled') Your payment cancelled @endif  @if ($data['paid_status'] == 'Free') Your payment free @endif</div>
            </div>
        </div>
    </div>
    --}}



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
  </body>
</html>
<?php
    use App\Lib\MyHelper;
	$configs = session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
<link href="{{ url('assets/pages/css/invoice-2.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .invoice-desc {
        font-weight: bold !important;
    }

    .countValue {
        text-align: right;
        padding-right: 55px;
    }

    a:hover {
        text-decoration: none;
    }
</style>
@endsection

@section('page-script')
   
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>
    
    @include('layouts.notifications')

    <div class="invoice-content-2 bordered">
        <div class="row invoice-head">
            <div class="col-md-12 col-xs-6 text-right">
                <div>
                    <h1 style="font-size: 25px;margin-top: 10px;font-weight: bold">{{ $result['outlet']['outlet_name'] }}</h1>
                    <h1 style="font-size: 20px;margin-top: 5px;">Receipt Number : <label>{{ $result['transaction_receipt_number'] }}</label></h1>
                </div>
            </div>
        </div>
        <div class="row invoice-cust-add">
            <div class="col-xs-3 customer">
                <h2 class="invoice-title uppercase">Customer</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-user"></i> {{ $result['user']['name'] }}</p>
            </div>
            <div class="col-xs-3 customer">
                <h2 class="invoice-title uppercase">Phone</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-phone"></i> {{ $result['user']['phone'] }}</p>
            </div>
            <div class="col-xs-3 customer">
                <h2 class="invoice-title uppercase">Date</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-calendar"></i> {{ date('d F Y', strtotime($result['transaction_date'])) }}</p>
            </div>
            <div class="col-xs-3 customer">
                @if ($result['trasaction_type'] == 'Delivery')
                    <h2 class="invoice-title uppercase">Address</h2>
                    <p class="invoice-desc dataCustomer"><i class="fa fa-street-view"></i> Jalan Garuda UH 3 / 159 Yogyakarta, Indonesia</p>
                @else
                    <h2 class="invoice-title uppercase">Pickup</h2>
                    <p class="invoice-desc dataCustomer">@if($result['detail']['pickup_type'] == 'set time') <i class="fa fa-clock-o"></i> @if($result['detail']['pickup_at']) {{date('H:i', strtotime($result['detail']['pickup_at']))}} @endif @else <i class="fa fa-inbox"></i> {{ $result['detail']['pickup_type'] }} @endif</p>
                @endif
            </div>
            <div class="col-xs-6 customer">
                <h2 class="invoice-title uppercase">Payment Detail</h2>
                @if ($result['trasaction_payment_type'] == 'Offline')
                    @if(!empty($result['payment_offline']))
                        @foreach($result['payment_offline'] as $res)
                            <p class="invoice-desc dataCustomer" style="margin:20px 0 5px"> Payment Type : {{ $res['payment_type'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Name : {{ $res['payment_bank'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Amount : Rp {{ number_format($res['payment_amount'], 2) }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Date : {{ date('d F Y H:i:s', strtotime($res['created_at'])) }}</p>
                        @endforeach
                    @endif
                @else
                    @if(!empty($result['payment']))
                        @if(isset($result['payment']['approval_code']))
                            <p class="invoice-desc dataCustomer" style="margin:20px 0 5px"> Payment Type : {{ $result['payment']['payment_type'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Name : {{ $result['payment']['bank'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Amount : Rp {{ number_format($result['payment']['gross_amount'], 2) }}</p>
                        @else
                            <p class="invoice-desc dataCustomer" style="margin:20px 0 5px"> Payment Type : {{ $result['payment']['payment_method'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Name : {{ $result['payment']['payment_bank'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Amount : Rp {{ number_format($result['payment']['payment_nominal'], 2) }}</p>
                       
                        @endif
                        <p class="invoice-desc dataCustomer" style="margin:5px 0"> Payment Date : {{ date('d F Y H:i:s', strtotime($result['payment']['created_at'])) }}</p>
                    @endif
                @endif
            </div>
            @if(MyHelper::hasAccess([18], $configs))
            <div class="col-xs-3 customer">
                <h2 class="invoice-title uppercase">Point Earned</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-gift"></i> {{ number_format( $result['transaction_point_earned']) }}</p>
            </div>
            @endif
            @if(MyHelper::hasAccess([19], $configs))
            <div class="col-xs-3 customer">
                <h2 class="invoice-title uppercase">Kopi Point Earned</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-gift"></i> {{ number_format( $result['transaction_cashback_earned'] ) }}</p>
            </div>
            @endif
        </div>
        <div class="row invoice-body">
            <div class="col-xs-12 table-responsive product">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase">Product</th>
                            <th class="invoice-title uppercase">Product Category</th>
                            <th class="invoice-title uppercase text-center">Quantity</th>
                            <th class="invoice-title uppercase text-center">Price</th>
                            <th class="invoice-title uppercase text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($result['product_transaction']))
                            @foreach ($result['product_transaction'] as $key => $product)
                                <tr>
                                    <td style="padding:0">
                                        <h3>{{ strtoupper($product['product']['product_name']) }}</h3>
                                    </td>
                                    <td >
                                        <h3>{{ strtoupper($product['product']['product_category']['product_category_name']) }}</h3>
                                    </td>
                                    <td style="padding:0" class="text-center sbold">{{ $product['transaction_product_qty'] }}</td>
                                    <td style="padding:0" class="text-center sbold">Rp {{ number_format($product['transaction_product_price']) }}</td>
                                    <td style="padding:0" class="text-center sbold">Rp {{ number_format($product['transaction_product_subtotal']) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row invoice-subtotal">
            <div class="col-xs-6 count countKey">
                @foreach ($setting as $row => $value)
                    <h2 class="invoice-desc" @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif>{{ ucwords($value) }}</h2>
                @endforeach
                    <h2 class="invoice-desc">Total</h2>
            </div>
            <div class="col-xs-6 count text-right">
                @foreach ($setting as $row => $value)
                    @if ($result['transaction_'.$value] < 1)
                        <h2 @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif class="invoice-desc" @if ($value == 'discount') style="color: red" @endif>-</h2>
                    @else
                        <h2 @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif class="invoice-desc" @if ($value == 'discount') style="color: red" @endif>Rp {{ number_format($result['transaction_'.$value]) }}</h2>
                    @endif
                @endforeach
                    <h2 class="invoice-desc">IDR {{ number_format($result['transaction_grandtotal']) }}</h2>
            </div>
        </div><br>
    </div>
@endsection
@extends('layouts.main')

@section('page-style')
<style>
	#detailFeedback label{
		font-weight: bold;
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">Detail Feedback</span>
            </div>
        </div>
        <div class="portlet-body form" id="detailFeedback">
        	<div class="row">
        		<div class="col-md-3 text-right"><label>Date</label></div>
        		<div class="col-md-9">{{date('d M Y',strtotime($feedback['created_at']))}}</div>
        	</div>
        	<div class="row">
        		<div class="col-md-3 text-right"><label>Receipt Number</label></div>
        		<div class="col-md-9"><a href="{{url('transaction/detail'.'/'.$feedback['transaction']['id_transaction'].'/'.strtolower($feedback['transaction']['trasaction_type']))}}">{{$feedback['transaction']['transaction_receipt_number']}}</a></div>
        	</div>
        	<div class="row">
        		<div class="col-md-3 text-right"><label>User</label></div>
        		<div class="col-md-9"><a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a></div>
        	</div>
        	<div class="row">
        		<div class="col-md-3 text-right"><label>Outlet</label></div>
        		<div class="col-md-9"><a href="{{url('outlet/detail'.'/'.$feedback['outlet']['outlet_code'])}}">{{$feedback['outlet']['outlet_code']}} - {{$feedback['outlet']['outlet_name']}}</a></div>
        	</div>
        	<div class="row">
        		<div class="col-md-3 text-right"><label>Grand Total</label></div>
        		<div class="col-md-9">Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}</div>
        	</div>
        	<div class="row">
        		<div class="col-md-3 text-right"><label>Vote</label></div>
        		<div class="col-md-9">{{$feedback['rating_item_text']}}</div>
        	</div>
        	<div class="row">
        		<div class="col-md-3 text-right"><label>Note</label></div>
        		<div class="col-md-9">{{$feedback['notes']}}</div>
        	</div>
        	<div class="row">
        		<div class="col-md-3 text-right"><label>Image</label></div>
        		<div class="col-md-9">@if(empty($feedback['image']))No Image @else <div class="col-md-6"><img src="{{env('S3_URL_API')}}{{$feedback['image']}}" class="img-responsive"></div> @endif</div>
        	</div>
        </div>
    </div>
@endsection
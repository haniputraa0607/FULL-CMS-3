@extends('layouts.main')

@section('page-style')
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
        <div class="portlet-body form form-horizontal" id="detailFeedback">
            <div class="row">
                <label class="col-md-3  text-right">Create Feedback Date</label>
                <div class="col-md-5">
                    {{date('d M Y',strtotime($feedback['created_at']))}}<br/>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3  text-right">Receipt Number</label>
                <div class="col-md-5">
                        <a href="{{url('transaction/detail'.'/'.$feedback['transaction']['id_transaction'].'/'.strtolower($feedback['transaction']['trasaction_type']))}}">{{$feedback['transaction']['transaction_receipt_number']}}</a>
                    <br/>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3  text-right">User</label>
                <div class="col-md-5">
                        <a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a>
                    <br/>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3  text-right">Outlet</label>
                <div class="col-md-5">
                        <a href="{{url('outlet/detail'.'/'.$feedback['outlet']['outlet_code'])}}">{{$feedback['outlet']['outlet_code']}} - {{$feedback['outlet']['outlet_name']}}</a>
                    <br/>
               </div>
            </div>
            <div class="row">
                <label class="col-md-3  text-right">Grand Total</label>
                <div class="col-md-5">
                    Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}<br/>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3  text-right">Vote</label>
                <div class="col-md-5">
                    {{$rating_items[$feedback['rating_value']]}}<br/>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3  text-right">Note</label>
                <div class="col-md-5">
                    {{$feedback['notes']}}<br/>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3  text-right">Image</label>
                <div class="col-md-9">@if(empty($feedback['image']))No Image @else <div class="row"><div class="col-md-6"><img src="{{env('S3_URL_API')}}{{$feedback['image']}}" class="img-responsive"></div></div> @endif</div>
            </div>
        </div>
    </div>
@endsection
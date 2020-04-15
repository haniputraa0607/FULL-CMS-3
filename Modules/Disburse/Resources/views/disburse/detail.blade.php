<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$idUserFrenchisee = session('id_user_franchise');
?>
@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
@endsection

@extends(($idUserFrenchisee == NULL ? 'layouts.main' : 'disburse::layouts.main'))

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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')
    @if(!empty($disburse))
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase ">Info</span>
                </div>
            </div>
            <div class="portlet-body form">
                <table>
                    <tr>
                        <td width="60%">Date</td>
                        <td>: {{ date('d M Y H:i', strtotime($disburse['created_at'])) }}</td>
                    </tr>
                    <tr>
                        <td width="60%">Outlet</td>
                        <td>: {{$disburse['outlet_code']}} - {{$disburse['outlet_name']}}</td>
                    </tr>
                    <tr>
                        <td width="60%">Status</td>
                        @if($disburse['disburse_status'] == 'Fail')
                            <td>: <b  style="color: red">{{ $disburse['disburse_status'] }}</b></td>
                        @else
                            <td>: <b style="color: green">{{ $disburse['disburse_status'] }}</b></td>
                        @endif
                    </tr>
                    <tr>
                        <td width="60%">Nominal</td>
                        <td>: {{number_format($disburse['disburse_nominal'])}}</td>
                    </tr>
                    <tr>
                        <td width="60%">Bank Name</td>
                        <td>: {{$disburse['bank_name']}}</td>
                    </tr>
                    <tr>
                        <td width="60%">Account Number</td>
                        <td>: {{$disburse['beneficiary_account_number']}}</td>
                    </tr>
                    <tr>
                        <td width="60%">Recipient Name</td>
                        <td>: {{$disburse['recipient_name']}}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover" id="tableReport">
            <thead>
            <tr>
                <th scope="col" width="10%"> Recipient Number </th>
                <th scope="col" width="30%"> Transaction Date </th>
                <th scope="col" width="10%"> Nominal Transaction</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($trx))
                @foreach($trx as $val)
                    <tr>
                        <td>{{$val['transaction_receipt_number']}}</td>
                        <td>{{ date('d M Y H:i', strtotime($val['transaction_date'])) }}</td>
                        <td>{{number_format($val['transaction_grandtotal'])}}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if ($trxPaginator)
        {{ $trxPaginator->fragment('participate')->links() }}
    @endif
@endsection
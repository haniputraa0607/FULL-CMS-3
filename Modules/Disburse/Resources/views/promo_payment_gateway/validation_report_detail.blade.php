@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
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
                <span class="caption-subject sbold uppercase font-blue"> Promo Payment Gateway Validation Report Detail</span>
            </div>
        </div>
        <div class="portlet-body">
            <table style="width: 100%;">
                <tr>
                    <td width="25%">ID</td>
                    <td>: {{$detail['promo_payment_gateway_code']}}</td>
                </tr>
                <tr>
                    <td width="25%">Name</td>
                    <td>: {{$detail['name']}}</td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>: {{date('d-M-Y', strtotime($detail['start_date']))}} / {{date('d-M-Y', strtotime($detail['end_date']))}}</td>
                </tr>
                <tr>
                    <td>Correct Get Promo</td>
                    <td>: {{$detail['correct_get_promo']}}</td>
                </tr>
                <tr>
                    <td>Not Get Promo</td>
                    <td>: {{$detail['not_get_promo']}}</td>
                </tr>
                <tr>
                    <td>Must Get Promo</td>
                    <td>: {{$detail['must_get_promo']}}</td>
                </tr>
                <tr>
                    <td>Wrong Get Promo</td>
                    <td>: {{$detail['wrong_cashback']}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue"> List Transaction</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" id="data_list">
                <thead>
                <tr>
                    <th> Receipt Number </th>
                    <th> Validation Status </th>
                    <th> Cashback New </th>
                    <th> Cashback Old </th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($detail['list_detail']))
                    @foreach($detail['list_detail'] as $key => $res)
                        <tr style="background-color: #fbfbfb;">
                            <?php
                            $status = [
                                'correct_get_promo' => 'Correct Get Promo',
                                'not_get_promo' => 'Not Get Promo',
                                'must_get_promo' => 'Must Get Promo'
                            ];
                            ?>
                            <td> {{ $res['transaction_receipt_number'] }} </td>
                            <td> {{ $status[$res['validation_status']]??''}} </td>
                            <td> {{ $res['new_cashback'] }} </td>
                            <td> {{ $res['old_cashback'] }} </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="text-align: center"><td colspan="5">Data Not Available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
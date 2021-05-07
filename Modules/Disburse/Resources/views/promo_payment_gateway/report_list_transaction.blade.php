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
                <span class="caption-subject sbold uppercase font-blue"> Detail Rule Promo Payment Gateway</span>
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
                    <td>Payment Gateway</td>
                    <td>: {{$detail['payment_gateway']}}</td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>: {{date('d-M-Y', strtotime($detail['start_date']))}} / {{date('d-M-Y', strtotime($detail['end_date']))}}</td>
                </tr>
                <tr>
                    <td>Total Limit</td>
                    <td>: {{$detail['limit_promo_total']}}</td>
                </tr>
                <tr>
                    <?php
                        $var = [
                            'day' => 'Limit maximum per day',
                            'week' => 'Limit maximum per week',
                            'month' => 'Limit maximum per month',
                            'account' => 'Limit maximum per account'
                        ];
                    ?>
                    <td>Additional Limit</td>
                    <td>:
                        @if(empty($detail['limit_promo_additional']))
                            -
                        @else
                            {{$detail['limit_promo_additional']}} ({{$var[$detail['limit_promo_additional_type']]??""}})</td>
                        @endif
                </tr>
                <tr>
                    <td>Cashback</td>
                    <td>: {{$detail['cashback']}} {{$detail['cashback_type']}}</td>
                </tr>
                <tr>
                    <td>Maximum Cashback</td>
                    <td>: {{number_format($detail['maximum_cashback'])}}</td>
                </tr>
                <tr>
                    <td>Minimum Transaction</td>
                    <td>: {{number_format($detail['minimum_transaction'])}}</td>
                </tr>
                <tr>
                    <td>Charged Payment Gateway</td>
                    <td>: {{$detail['charged_payment_gateway']}} {{$detail['charged_type']}}</td>
                </tr>
                <tr>
                    <td>Charged Jiwa Group</td>
                    <td>: {{$detail['charged_jiwa_group']}} {{$detail['charged_type']}}</td>
                </tr>
                <tr>
                    <td>Charged Central</td>
                    <td>: {{$detail['charged_central']}} {{$detail['charged_type']}}</td>
                </tr>
                <tr>
                    <td>Charged Outlet</td>
                    <td>: {{$detail['charged_outlet']}} {{$detail['charged_type']}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue"> Report Transaction Rule Promo Payment Gateway</span>
            </div>
            <div class="actions">
                @if(isset($data) && !empty($data))
                    <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}?export=1"><i class="fa fa-download"></i> Export</a>
                @endif
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover dt-responsive" id="data_list">
                    <thead>
                    <tr>
                        <th> Customer name</th>
                        <th> Customer phone</th>
                        <th> Customer account PG</th>
                        <th> Receipt number </th>
                        <th> Outlet </th>
                        <th> Chasback Received </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($data))
                        @foreach($data as $key => $res)
                            <tr style="background-color: #fbfbfb;">
                                <td> {{ $res['customer_name'] }} </td>
                                <td> {{ $res['customer_phone'] }} </td>
                                <td> {{ $res['payment_gateway_user'] }} </td>
                                <td> <a target="_blank" href="{{ url('transaction/detail') }}/{{ $res['id_transaction'] }}/all">{{ $res['transaction_receipt_number'] }}</a> </td>
                                <td> {{ $res['outlet_code'] }} - {{ $res['outlet_name'] }} </td>
                                <td> {{ number_format($res['total_received_cashback'],2,",",".") }} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr style="text-align: center"><td colspan="5">Data Not Available</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
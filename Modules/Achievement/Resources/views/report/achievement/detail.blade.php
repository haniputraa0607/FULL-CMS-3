@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        td {
            height: 25px;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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
    @if(!empty($data_achievement))
        <div class="row">
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-blue sbold uppercase ">Achievement Detail</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <table>
                            <tr>
                                <td width="50%">Achievement Name</td>
                                <td>: {{ $data_achievement['name'] }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Achievement Name</td>
                                <td>: {{ $data_achievement['category_name'] }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Achievement Date Start</td>
                                <td>: @if(!is_null($data_achievement['date_start']))
                                        {{date('d F M H:i', strtotime($data_achievement['date_start']))}}
                                    @else
                                        Not Set
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">Achievement Date End</td>
                                <td>: @if(!is_null($data_achievement['date_end']))
                                        {{date('d F M H:i', strtotime($data_achievement['date_end']))}}
                                    @else
                                        Not Set
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">Total User</td>
                                <td>: {{number_format($data_achievement['total_user'])}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @foreach ($data_badge as $item)
                    <div class="col-md-12 profile-info">
                        <div class="profile-info portlet light bordered">
                            <div class="portlet-title">
                                <div class="col-md-6" style="display: flex;">
                                    <img src="{{$item['logo_badge']}}" style="width: 40px;height: 40px;" class="img-responsive" alt="">
                                    <span class="caption font-blue sbold uppercase" style="padding: 8px 0px;font-size: 16px;">
                                    &nbsp;&nbsp;{{$item['name']}}
                                </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row" style="padding: 5px;position: relative;">
                                    <div class="col-md-12">
                                        <div class="row static-info">
                                            <div class="col-md-5 value">Total User</div>
                                            <div class="col-md-7 value">: {{number_format($item['total_badge_user'])}} user</div>
                                        </div>
                                        @if (!is_null($item['id_product']) || !is_null($item['product_total']))
                                            <div class="row static-info">
                                                <div class="col-md-5 value">Product Rule</div>
                                            </div>
                                            <div class="row static-info">
                                                @if (!is_null($item['id_product']))
                                                    <div class="col-md-5 name">Product</div>
                                                    <div class="col-md-7 value">: {{$item['product']['product_name']}}</div>
                                                @endif
                                                @if (!is_null($item['product_total']))
                                                    <div class="col-md-5 name">Product Total</div>
                                                    <div class="col-md-7 value">: {{$item['product_total']}}</div>
                                                @endif
                                            </div>
                                        @endif
                                        @if (!is_null($item['id_outlet']) || !is_null($item['different_outlet']))
                                            <div class="row static-info">
                                                <div class="col-md-5 value">Outlet Rule</div>
                                            </div>
                                            <div class="row static-info">
                                                @if (!is_null($item['id_outlet']))
                                                    <div class="col-md-5 name">Outlet</div>
                                                    <div class="col-md-7 value">: {{$item['outlet']['outlet_name']}}</div>
                                                @endif
                                                @if (!is_null($item['different_outlet']))
                                                    <div class="col-md-5 name">Outlet Different ?</div>
                                                    <div class="col-md-7 value">: {{$item['different_outlet']}} Outlet</div>
                                                @endif
                                            </div>
                                        @endif
                                        @if (!is_null($item['id_province']) || !is_null($item['different_province']))
                                            <div class="row static-info">
                                                <div class="col-md-5 value">Province Rule</div>
                                            </div>
                                            <div class="row static-info">
                                                @if (!is_null($item['id_province']))
                                                    <div class="col-md-5 name">Province</div>
                                                    <div class="col-md-7 value">: {{$item['province']['province_name']}}</div>
                                                @endif
                                                @if (!is_null($item['different_province']))
                                                    <div class="col-md-5 name">Province Different ?</div>
                                                    <div class="col-md-7 value">: {{$item['different_province']}} Provice</div>
                                                @endif
                                            </div>
                                        @endif
                                        @if (!is_null($item['trx_nominal']) || !is_null($item['trx_total']))
                                            <div class="row static-info">
                                                <div class="col-md-5 value">Transaction Rule</div>
                                            </div>
                                            <div class="row static-info">
                                                @if (!is_null($item['trx_nominal']))
                                                    <div class="col-md-5 name">Transaction Nominal</div>
                                                    <div class="col-md-7 value">: Minimum {{number_format($item['trx_nominal'])}}</div>
                                                @endif
                                                @if (!is_null($item['trx_total']))
                                                    <div class="col-md-5 name">Transaction Total</div>
                                                    <div class="col-md-7 value">: Minimum {{number_format($item['trx_total'])}}</div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

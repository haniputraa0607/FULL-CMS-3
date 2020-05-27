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
                        <td>: {{$disburse['beneficiary_name']}}</td>
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
                <th scope="col" width="10%"> Detail Transaction</th>
                <th scope="col" width="10%"> Income Outlet</th>
                @if(MyHelper::hasAccess([235], $grantedFeature))
                    <th scope="col" width="10%"> Income Central</th>
                @endif
                <th scope="col" width="10%"> Detail Setting </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($trx))
                @foreach($trx as $val)
                    <tr>
                        <td>{{$val['transaction_receipt_number']}}</td>
                        <td>{{ date('d M Y H:i', strtotime($val['transaction_date'])) }}</td>
                        <td>
                            Subtotal = {{number_format($val['transaction_subtotal'])}}<br>
                            Grandtotal = {{number_format($val['transaction_grandtotal'])}}<br>
                            Discount = {{number_format($val['transaction_discount'])}}<br>
                            Gosend Price = {{number_format($val['transaction_shipment_go_send'])}}<br>
                        </td>
                        <td>{{number_format($val['income_outlet'])}}</td>
                        <td>{{number_format($val['income_central'])}}</td>
                        <td>
                            <?php
                                $mdr_type = '<br>';
                                if($val['mdr_type'] == 'Percent'){
                                    $mdr_type = ' %<br>';
                                }


                                if(MyHelper::hasAccess([235], $grantedFeature)){
                                    $html = '';
                                    $html .= 'Fee Outlet: '.$val['fee'].' %<br>';
                                    $html .= 'Fee PG Outlet: '.$val['mdr'].$mdr_type;
                                    $html .= 'Fee PG Central: '.$val['mdr_central'].$mdr_type;
                                    $html .= 'Charged Point Central: '.$val['charged_point_central'].' %<br>';
                                    $html .= 'Charged Point Outlet: '.$val['charged_point_outlet'].' %<br>';
                                    $html .= 'Charged Promo Central: '.$val['charged_promo_central'].' %<br>';
                                    $html .= 'Charged Promo Outlet: '.$val['charged_promo_outlet'].' %<br>';
                                }else{
                                    $mdr = $val['mdr'] + $val['mdr_central'];
                                    $html = '';
                                    $html .= 'Fee Outlet: '.$val['fee'].' %<br>';
                                    $html .= 'Fee Payment Gateway: '.$mdr.$mdr_type;
                                    $html .= 'Charged Point Central: '.$val['charged_point_central'].' %<br>';
                                    $html .= 'Charged Point Outlet: '.$val['charged_point_outlet'].' %<br>';
                                    $html .= 'Charged Promo Central: '.$val['charged_promo_central'].' %<br>';
                                    $html .= 'Charged Promo Outlet: '.$val['charged_promo_outlet'].' %<br>';
                                }

                                echo $html;
                            ?>
                        </td>
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
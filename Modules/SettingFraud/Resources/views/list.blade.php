<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
    
@section('page-script')
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>

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
                <span class="caption-subject font-blue sbold uppercase">Setting Fraud Detection List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                            <th> Action </th>
                        @endif
                        <th> Parameter </th>
                        <th> Parameter Detail </th>
                        <!-- <th> Channel </th> -->
                        <th> Email Recipient </th>
                        <th> SMS Recipient </th>
                        <th> WhatsApp Recipient </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($list))
                        @foreach($list as $value)
                            <tr>
                                @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                                    <td style="width: 85px;">
                                        @if(MyHelper::hasAccess([25,27], $grantedFeature)) 
                                            <a href="{{ url('setting-fraud-detection/detail') }}/{{ $value['id_fraud_setting'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i> Detail</a> 
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $value['parameter'] }}</td>
                                <td>{{ $value['parameter_detail'] }}</td>
                                <!-- <td>
                                    @if($value['email_toogle'] == '1')
                                        Email <br>
                                    @endif
                                    @if($value['sms_toogle'] == '1')
                                        SMS <br>
                                    @endif
                                    @if($value['whatsapp_toogle'] == '1')
                                        WhatsApp <br>
                                    @endif
                                </td> -->
                                <td>
                                    @if($value['email_toogle'] == '1')
                                        @php $recipient = explode(',', $value['email_recipient'])@endphp
                                        @foreach ($recipient as $item)
                                            {{$item}} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($value['sms_toogle'] == '1')
                                        @php $recipient = explode(',', $value['sms_recipient'])@endphp
                                        @foreach ($recipient as $item)
                                            {{$item}} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($value['whatsapp_toogle'] == '1')
                                        @php $recipient = explode(',', $value['whatsapp_recipient'])@endphp
                                        @foreach ($recipient as $item)
                                            {{$item}} <br>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection
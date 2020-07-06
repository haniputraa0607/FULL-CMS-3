@extends('layouts.main-closed')

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

    <script>
        $(document).ready(function () {
            dataAchievement();
            datatables();
        });
        
        function dataAchievement() {
            var token  = "{{ csrf_token() }}";
            var url = "{{url('achievement/report/detail/'.$id_achievement_group)}}";

            var data = {
                _token : token,
                id_achievement_group : "{{$id_achievement_group}}"
            };

            $.ajax({
                type : "POST",
                url : url,
                data : data,
                success : function(result) {
                    if(result.data_achievement){
                        $('#achievement_name').val(document.getElementById ( id_mdr+'_payment_name' ).innerText);
                    }
                    console.log(result);
                },
                error: function (jqXHR, exception) {
                    toastr.warning('Failed get data achievement');
                }
            });
        }

        function datatables(){
            $("#tbodyListUser").empty();
            var data_display = 10;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('achievement/report/list-user/'.$id_achievement_group)}}";

            var dt = 0;
            var tab = $.fn.dataTable.isDataTable( '#tableListUser' );
            if(tab){
                $('#tableListUser').DataTable().destroy();
            }

            var data = {
                _token : token,
                id_achievement_group : "{{$id_achievement_group}}"
            };

            $('#tableListUser').DataTable( {
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": false,
                "bInfo": true,
                "iDisplayLength": data_display,
                "bProcessing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    url : url,
                    dataType: "json",
                    type: "POST",
                    data: data,
                    "dataSrc": function (json) {
                        return json.data;
                    }
                },
                columnDefs: [
                    {
                        targets: 3,
                        render: function ( data, type, row, meta ) {
                            try {
                                var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                var achievement_detail = row.achievement_detail;
                                var original_date = new Date(achievement_detail[achievement_detail.length -1].date);
                                var convert_date = original_date.getDate() +' '+ (month[original_date.getMonth()]) + " " + original_date.getFullYear() + " " + original_date.getHours() + ":" + original_date.getMinutes() + ":" + original_date.getSeconds();
                                return convert_date;
                            }catch (err) {
                                return '-';
                            }
                        }
                    },
                    {
                        targets: 4,
                        render: function ( data, type, row, meta ) {
                            try {
                                var achievement_detail = row.achievement_detail;
                                return achievement_detail[0].name;
                            }catch (err) {
                                return '-';
                            }
                        }
                    },
                    {
                        targets: 5,
                        render: function ( data, type, row, meta ) {
                            try {
                                var achievement_detail = row.achievement_detail;
                                var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                var html = "";
                                html += '<ul>';
                                for(var i=0;i<achievement_detail.length;i++){
                                    var original_date = new Date(achievement_detail[i].date);
                                    var convert_date = original_date.getDate() +' '+ (month[original_date.getMonth()]) + " " + original_date.getFullYear() + " " + original_date.getHours() + ":" + original_date.getMinutes() + ":" + original_date.getSeconds();
                                    html += '<li><b>Name</b>: '+achievement_detail[i].name +'<br><b>Date</b>: '+ convert_date +'</li>';
                                }
                                html += '</ul>';

                                return html;
                            }catch (err) {
                                return '-';
                            }
                        }
                    }
                ]
            });
        }

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

    <div class="row">
        <div class="col-md-7">
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
                            <td id="achievement_name"></td>
                        </tr>
                        <tr>
                            <td width="50%">Achievement Category</td>
                            <td id="achievement_category"></td>
                        </tr>
                        <tr>
                            <td width="50%">Achievement Date Start</td>
                            <td id="achievement_date_start"></td>
                        </tr>
                        <tr>
                            <td width="50%">Achievement Date End</td>
                            <td id="achievement_date_end"></td>
                        </tr>
                        <tr>
                            <td width="50%">Total User</td>
                            <td id="achievement_total_user"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold uppercase">List User</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <table class="table table-striped table-bordered table-hover" id="tableListUser">
                        <thead>
                        <tr>
                            <th scope="col" width="30%"> User Name </th>
                            <th scope="col" width="30%"> User Phone </th>
                            <th scope="col" width="10%"> User Email </th>
                            <th scope="col" width="25%"> Date First Badge </th>
                            <th scope="col" width="25%"> Current Badge </th>
                            <th scope="col" width="25%"> Detail Badge User &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyListUser"></tbody>
                    </table>
                </div>
            </div>
        </div>
        @if(!empty($data_badge))
        <div class="col-md-5">
            <div class="profile-info portlet light bordered">
                <div class="portlet-title">
                    <span class="caption-subject font-blue sbold uppercase" style="font-size: 16px">List Badge</span>
                </div>
                <div class="portlet-body">
                    @foreach ($data_badge as $item)
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
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

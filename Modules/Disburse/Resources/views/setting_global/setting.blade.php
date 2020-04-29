<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $idUserFrenchisee = session('id_user_franchise');
 ?>
@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
        $(document).ready(function () {
            outlets();
        });

        $('input[name=central]').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        $('input[name=outlet]').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        $('input[name=fee]').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        function submit(){
            var outlet = $('#outlet').val();
            var central = $('#central').val();

            var check = Number(outlet) + Number(central);
            if(check !== 100){
                confirm('Input is invalid, please check description.');
            }else{
                $( "#form_point" ).submit();
            }
        }

        function outlets() {
            $("#tableListOutletBody").empty();
            var data_display = 10;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('disburse/setting/fee-outlet-special/outlets')}}";
            var tab = $.fn.dataTable.isDataTable( '#tableListOutlet' );
            if(tab){
                $('#tableListOutlet').DataTable().destroy();
            }

            var data = {
                _token : token
            };

            $('#tableListOutlet').DataTable( {
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
                        targets: 0,
                        render: function ( data, type, row, meta ) {
                            var html = '<label class="mt-checkbox"><input value="'+data+'" onchange="checkboxEvent(this)" type="checkbox" id="check'+data+'" class="md-check" /> <span></span></label>';
                            return html;
                        }
                    },
                    {
                        targets: 2,
                        render: function ( data, type, row, meta ) {
                            if(data == 1){
                                var html = "<b style='color: green'>This outlet is franchise</b>"
                            }else{
                                var html = "This outlet is not franchise"
                            }
                            return html;
                        }
                    },
                    {
                        targets: 3,
                        render: function ( data, type, row, meta ) {
                            if(data == 1){
                                var html = "<b style='color: green'>This outlet is special outlet</b>"
                            }else{
                                var html = "This outlet is not special outlet"
                            }
                            return html;
                        }
                    }
                ]
            });
        }

        var arrOutlet = [];
        function checkboxEvent(checkboxElem) {
            if (checkboxElem.checked) {
                arrOutlet.push(Number(checkboxElem.value));
            } else {
                var index = arrOutlet.indexOf(Number(checkboxElem.value));
                if (index > -1) {
                    arrOutlet.splice(index, 1);
                }
            }
        }
        
        function submitFeeSpecialOutlet() {
            var msg = "";
            var percentFee = $('input[name=outlet_special_fee]').val();

            if(arrOutlet.length <= 0){
                msg += "-Please select one or more outlet to setting \n";
            }

            if(percentFee === ""){
                msg += "-Please input Percent Fee \n";
            }

            if(msg !== ""){
                confirm(msg);
            }else{
                $('input[name=id_outlet]').val(arrOutlet);
                $( "#form_fee_outlet_special" ).submit();
            }
        }
    </script>
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

    <div class="tabbable-line">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#fee">Fee Global </a>
            </li>
            <li>
                <a data-toggle="tab" href="#fee-special-outlet">Fee Special Outlet</a>
            </li>
            <li>
                <a data-toggle="tab" href="#point">Point</a>
            </li>
        </ul>
    </div>
    <br>
    <div class="tab-content">
        <div id="fee" class="tab-pane active">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-yellow sbold uppercase">Setting Fee</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="m-heading-1 border-green m-bordered">
                        <p>Setting ini digunakan untuk mengatur fee untuk outlet pusat dan outlet franchise.</p>
                        <br><p style="color: red">*(Silahkan gunakan '.' jika Anda ingin menggunakan koma. Example : 0.2)</p>
                    </div>
                    <form class="form-horizontal" role="form" action="{{url('disburse/setting/fee-global')}}" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Percent Fee Outlet Central<span class="required" aria-required="true"> * </span></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fee_central" required value="{{$fee['fee_central']}}"><span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Percent Fee Outlet Franchise<span class="required" aria-required="true"> * </span></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fee_outlet" required value="{{$fee['fee_outlet']}}"><span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" style="text-align: center">
                                {{ csrf_field() }}
                                <button type="submit" id="export_btn" class="btn green">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="fee-special-outlet" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur fee untuk outlet tertentu atau outlet pusat.</p>
                <br><p style="color: red">*(Silahkan gunakan '.' jika Anda ingin menggunakan koma. Example : 0.2)</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_fee_special_outlet')
        </div>
        <div id="point" class="tab-pane">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-yellow sbold uppercase">Setting Point Charged</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="m-heading-1 border-green m-bordered">
                        <p>Setting ini digunakan untuk pembayaran menggunakan point akan dibebankan pada pihak Outlet, Janji Jiwa, atau ditanggung oleh kedua pihak.</p>
                        <br>
                        <p>
                            Contoh : <br>
                        <div class="row">
                            <div class="col-md-3">Case 1 ==> </div>
                            <div class="col-md-3">Janji Jiwa = 30%</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">Outlet = 70%</div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">Case 2 ==> </div>
                            <div class="col-md-3">Janji Jiwa = 100%</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">Outlet = 0%</div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">Case 3 ==> </div>
                            <div class="col-md-3">Janji Jiwa = 0%</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">Outlet = 100%</div>
                        </div>
                        </p>
                        <br><p style="color: red">*(Silahkan gunakan '.' jika Anda ingin menggunakan koma. Example : 0.2)</p>
                    </div>
                    <form class="form-horizontal" role="form" action="{{url('disburse/setting/point-charged-global')}}" method="post" id="form_point">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Charged Central <span class="required" aria-required="true"> * </span></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="central" name="central" required value="{{$point['central']}}"><span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Charged Outlet <span class="required" aria-required="true"> * </span></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="outlet" name="outlet" required value="{{$point['outlet']}}"><span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" style="text-align: center">
                                {{ csrf_field() }}
                                <a  id="export_btn" onclick="submit()" class="btn green">Submit</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
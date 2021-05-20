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
    <script>
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        $('.price').each(function() {
            var input = $(this).val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $(this).val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        });

        $( ".price" ).on( "keyup", numberFormat);
        function numberFormat(event){
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            var $this = $( this );
            var input = $this.val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        }

        $( ".price" ).on( "blur", checkFormat);
        function checkFormat(event){
            var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
            if(!$.isNumeric(data)){
                $( this ).val("");
            }
        }

        function changeAdditionalType(val) {
            if(val == 'account'){
                document.getElementById('type_user_limit_per_account').style.display = 'block';
                document.getElementById('select_additional_account_type').required = true;
            }else{
                document.getElementById('type_user_limit_per_account').style.display = 'none';
                document.getElementById('select_additional_account_type').required = false;
            }
        }

        function changeCashbackType(val) {
            $('#maximum_cashback').val('');
            $('#charged_type').val(val);
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">New Rule Promo Payment Gateway</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('disburse/rule-promo-payment-gateway/store')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">ID <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="ID rule promo payment gateway" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="ID" class="form-control" name="promo_payment_gateway_code" value="{{ old('promo_payment_gateway_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Name rule promo payment gateway" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Name" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Payment Gateway <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih payment gateway yang akan kena promo" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="payment_gateway" data-placeholder="Select" required>
                                    <option></option>
                                    @foreach($payment_list as $val)
                                        <option value="{{$val['payment_method']}}" @if(old('payment_gateway') == $val['payment_method']) selected @endif>{{$val['payment_method']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Periode <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="promo yang berlaku bedasarkan periode yang dipilih" data-container="body"></i></label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control datepicker" name="start_date" value="{{ old('start_date') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai promo berlaku" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control datepicker" name="end_date" value="{{ old('end_date') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir promo berlaku" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Total Limit <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="total jumlah promo yang akan diberikan" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Total limit" class="form-control" name="limit_promo_total" value="{{ old('limit_promo_total') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Limit" class="form-control" name="limit_promo_additional" value="{{ old('limit_promo_additional') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select  class="form-control select2" name="limit_promo_additional_type" data-placeholder="Type" onchange="changeAdditionalType(this.value)">
                                <option></option>
                                <option value="day" @if(old('limit_promo_additional_type') == 'day') selected @endif>Limit maximum per day</option>
                                <option value="week" @if(old('limit_promo_additional_type') == 'week') selected @endif>Limit maximum per week</option>
                                <option value="month" @if(old('limit_promo_additional_type') == 'month') selected @endif>Limit maximum per month</option>
                                <option value="account" @if(old('limit_promo_additional_type') == 'account') selected @endif>Limit maximum per account</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" @if(old('limit_promo_additional_type') != 'account') style="display: none" @endif id="type_user_limit_per_account">
                        <label class="col-md-3 control-label">Type user for limit maximum per account
                            <i class="fa fa-question-circle tooltips" data-original-title="Type user fot limit maximum per account" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <select  class="form-control select2" name="limit_promo_additional_account_type" id="select_additional_account_type" data-placeholder="Type">
                                <option></option>
                                <option value="Jiwa+" @if(old('limit_promo_additional_account_type') == 'Jiwa+') selected @endif>Jiwa+</option>
                                <option value="Payment Gateway" @if(old('limit_promo_additional_account_type') == 'Payment Gateway') selected @endif>Payment Gateway</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Cashback <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah cashback" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <select  class="form-control select2" name="cashback_type" data-placeholder="Cashback Type" required onchange="changeCashbackType(this.value)">
                                <option></option>
                                <option value="Percent" @if(old('cashback_type') == 'Percent') selected @endif>Percent</option>
                                <option value="Nominal" @if(old('cashback_type') == 'Nominal') selected @endif>Nominal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" placeholder="Cashback" class="form-control" name="cashback" value="{{ old('cashback') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Maximum Cashback
                            <i class="fa fa-question-circle tooltips" data-original-title="maximum cashback" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" class="form-control price"  placeholder="Maximum Cashback" id="maximum_cashback" name="maximum_cashback" value="{{ old('maximum_cashback') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Minimum Transaksi <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="minimum transaksi" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    >=
                                </span>
                                <input type="text" class="form-control price"  placeholder="Minimum transaksi" name="minimum_transaction" value="{{ old('minimum_transaction') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Charged Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="tipe charged" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Charged Type" class="form-control" id="charged_type" name="charged_type" value="{{ old('charged_type') }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Charged <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="pembagian fee untuk pihak payment gateway dan jiwa point" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Charged Payment Gateway" class="form-control" name="charged_payment_gateway" value="{{ old('charged_payment_gateway') }}" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Charged Jiwa Group" class="form-control" name="charged_jiwa_group" value="{{ old('charged_jiwa_group') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Charged Central & <br>Outlet <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="yang ditanggung pihak central dan outlet" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Charged Central" class="form-control" name="charged_central" value="{{ old('charged_central') }}" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Charged Outlet" class="form-control" name="charged_outlet" value="{{ old('charged_outlet') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">MDR Setting <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="rule untuk perhitungan mdr" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" name="mdr_setting" data-placeholder="MDR Setting" required>
                                <option></option>
                                <option value="Total Amount PG" @if(old('mdr_setting') == 'Total Amount PG') selected @endif>Total Amount PG</option>
                                <option value="Total Amount PG - Cashback Jiwa Group" @if(old('mdr_setting') == 'Total Amount PG - Cashback Jiwa Group') selected @endif>Total Amount PG - Cashback Jiwa Group</option>
                                <option value="Total Amount PG - Total Cashback Customer" @if(old('mdr_setting') == 'Total Amount PG - Total Cashback Customer') selected @endif>Total Amount PG - Total Cashback Customer</option>
                            </select>
                        </div>
                    </div>
                </div>                
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
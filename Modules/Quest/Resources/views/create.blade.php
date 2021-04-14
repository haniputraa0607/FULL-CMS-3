@extends('layouts.main') 

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
@endsection 

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('.datepicker').datepicker({
            'format': 'd-M-yyyy',
            'todayHighlight': true,
            'autoclose': true
        });
        $('.timepicker').timepicker();
        $(".form_datetime").datetimepicker({
            format: "d-M-yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            minuteStep: 1
        });
        $('.summernote').summernote({
            placeholder: true,
            tabsize: 2,
            height: 120,
            toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
                ],
            fontNames: ['Open Sans', 'Product Sans'],
            fontNamesIgnoreCheck: ['Product Sans'],
            callbacks: {
                onInit: function(e) {
                    this.placeholder
                    ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                    : e.editingArea.remove(".note-placeholder");
                },
                onImageUpload: function(files){
                    sendFile(files[0]);
                },
                onMediaDelete: function(target){
                    var name = target[0].src;
                    token = "{{ csrf_token() }}";
                    $.ajax({
                        type: 'post',
                        data: 'filename='+name+'&_token='+token,
                        url: "{{url('summernote/picture/delete/deals')}}",
                        success: function(data){
                            // console.log(data);
                        }
                    });
                }
            }
        });
        $(".file").change(function(e) {
            console.log($(this))
            var btnRemove = $(this).parent().next()[0]
            var widthImg  = 500;
            var heightImg = 500;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width != widthImg && this.height != heightImg) {
                        toastr.warning("Please check dimension of your photo.");
                        btnRemove.click()
                    }
                };
                image.src = _URL.createObjectURL(file);
            }

        });
    </script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            /* sortable */
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
            $("#selectCategory").select2({
                tags: true
            });
            $(".select2-multiple").select2({
                allowClear: true
            });
            var index = {{count($details) + 1}};
            $('.add').click(function() {
                nomer = index++
                $('.btn-rmv').before(`<div class="box">
                                        <div class="col-md-2 text-right" style="text-align: -webkit-right;">
                                            <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                        Name
                                                        <span class="required" aria-required="true"> * </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="detail[${nomer}][name]" placeholder="Detail Quest" required maxlength="20">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Short Description
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <textarea name="detail[${nomer}][short_description]" class="form-control" placeholder="Quest Detail Short Description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Image Default Badge
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                                                    <br>
                                                    <span class="required" aria-required="true"> (500*500) </span>
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                            <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                                            <div>
                                                                <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Select image </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" class="file" accept="image/*" name="detail[${nomer}][logo_badge]" required>
                                                                </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                        Quest Rule
                                                        <span class="required" aria-required="true"> * </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="mt-checkbox-inline">
                                                        <label class="mt-checkbox" style="margin-left: 15px;">
                                                            <input type="checkbox" class="rule_trx"> Transaction
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" class="rule_product"> Product
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" class="rule_total"> Total
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" class="rule_additional"> Additional
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group trx_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Quest Transaction Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[${nomer}][trx_nominal]" placeholder="Transaction Nominal">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group product_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Quest Product Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2-multiple id_product" data-placeholder="Select Product" name="detail[${nomer}][id_product]">
                                                            <option></option>
                                                            @foreach ($product as $item)
                                                                <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control total_product" name="detail[${nomer}][product_total]" placeholder="Total Product">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group total_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Quest Total Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <select class="form-control select2-multiple rule_totalnya" name="detail[${nomer}][rule_total]" id="total_rule" data-placeholder="Select Total Rule By">
                                                                <option></option>
                                                                <option value="total_transaction">Transaction</option>
                                                                <option value="total_outlet">Outlet Different</option>
                                                                <option value="total_province">Province Different</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control digit_mask value_totalnya" name="detail[${nomer}][value_total]" placeholder="Value Total">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group additional_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Quest Additional Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4" id="select_outlet">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2-multiple id_outlet" data-placeholder="Select Outlet" name="detail[${nomer}][id_outlet]">
                                                            <option></option>
                                                            @foreach ($outlet as $item)
                                                                <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="select_province">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2-multiple id_province" data-placeholder="Select Province" name="detail[`+nomer+`][id_province]">
                                                            <option></option>
                                                            @foreach ($province as $item)
                                                                <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`);
                $('.digit_mask').inputmask({
                    removeMaskOnSubmit: true, 
                    placeholder: "",
                    alias: "currency", 
                    digits: 0, 
                    rightAlign: false,
                    min: 0,
                    max: '999999999'
                });
                $("#selectCategory").select2({
                    tags: true
                });
                $(".select2-multiple").select2({
                    width: '100%',
                    allowClear: true
                });
                $('#total_rule').change(function() {
                    $('#select_outlet').show()
                    $('#select_province').show()
                    switch ($(this).val()) {
                        case 'total_outlet':
                            $('#select_outlet').hide()
                            $('#select_outlet').children().children().val()
                            toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                            break;
                        case 'total_province':
                            $('#select_province').hide()
                            $('#select_province').children().children().val()
                            toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                            break;
                    }
                });
                $('#total_rule').change(function() {
                    $('#select_outlet').show()
                    $('#select_province').show()
                    switch ($(this).val()) {
                        case 'total_outlet':
                            $('#select_outlet').hide()
                            $('#select_outlet').children().children().val()
                            toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                            break;
                        case 'total_province':
                            $('#select_province').hide()
                            $('#select_province').children().children().val()
                            toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                            break;
                    }
                });
                $('.rule_trx').change(function() {
                    var form = $(this).parents()[4]
                    $(form).find('.trx_rule_form').hide()
                    $(form).find('.nominal_transaksi').val("").trigger("change")
                    if ($(this).is(':checked')) {
                        $(form).find('.trx_rule_form').show()
                    }
                });
                $('.rule_product').change(function() {
                    var form = $(this).parents()[4]
                    $(form).find('.id_product').val("").trigger("change")
                    $(form).find('.total_product').val("").trigger("change")
                    $(form).find('.product_rule_form').hide()
                    $('#product_total_rule').val("")
                    if ($(this).is(':checked')) {
                        $(form).find('.product_rule_form').show()
                    }
                });
                $('.rule_total').change(function() {
                    var form = $(this).parents()[4]
                    $(form).find('.total_rule_form').hide()
                    $(form).find('.rule_totalnya').val("").trigger("change")
                    $(form).find('.value_totalnya').val("").trigger("change")
                    if ($(this).is(':checked')) {
                        $(form).find('.total_rule_form').show()
                    }
                });
                $('.rule_additional').change(function() {
                    var form = $(this).parents()[4]
                    $(form).find('.id_outlet').val("").trigger("change")
                    $(form).find('.id_province').val("").trigger("change")
                    $(form).find('.additional_rule_form').hide()
                    if ($(this).is(':checked')) {
                        $(form).find('.additional_rule_form').show()
                    }
                });
            });
            $('.digit_mask').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 0,
                max: '999999999'
            });
            $("#selectCategory").select2({
                tags: true
            });
            $(".select2-multiple").select2({
                width: '100%',
                allowClear: true
            });
            $('#total_rule').change(function() {
                $('#select_outlet').show()
                $('#select_province').show()
                switch ($(this).val()) {
                    case 'total_outlet':
                        $('#select_outlet').hide()
                        $('#select_outlet').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                        break;
                    case 'total_province':
                        $('#select_province').hide()
                        $('#select_province').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                        break;
                }
            });
            $('#total_rule').change(function() {
                $('#select_outlet').show()
                $('#select_province').show()
                switch ($(this).val()) {
                    case 'total_outlet':
                        $('#select_outlet').hide()
                        $('#select_outlet').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                        break;
                    case 'total_province':
                        $('#select_province').hide()
                        $('#select_province').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                        break;
                }
            });
            $('.rule_trx').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.trx_rule_form').hide()
                $(form).find('.nominal_transaksi').val("").trigger("change")
                if ($(this).is(':checked')) {
                    $(form).find('.trx_rule_form').show()
                }
            });
            $('.rule_product').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.id_product').val("").trigger("change")
                $(form).find('.total_product').val("").trigger("change")
                $(form).find('.product_rule_form').hide()
                $('#product_total_rule').val("")
                if ($(this).is(':checked')) {
                    $(form).find('.product_rule_form').show()
                }
            });
            $('.rule_total').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.rule_totalnya').val("").trigger("change")
                $(form).find('.value_totalnya').val("").trigger("change")
                $(form).find('.total_rule_form').hide()
                if ($(this).is(':checked')) {
                    $(form).find('.total_rule_form').show()
                }
            });
            $('.rule_additional').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.id_outlet').val("").trigger("change")
                $(form).find('.id_province').val("").trigger("change")
                $(form).find('.additional_rule_form').hide()
                if ($(this).is(':checked')) {
                    $(form).find('.additional_rule_form').show()
                }
            });
        });
        function removeBox(params) {
            $(params).parent().parent().remove()
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#benefit-selector').on('change', function() {
                if ($(this).val() == 'point') {
                    $('#benefit-voucher').addClass('hidden');
                    $('#benefit-voucher :input').prop('disabled', true);

                    $('#benefit-point').removeClass('hidden');
                    $('#benefit-point :input').removeAttr('disabled');
                } else {
                    $('#benefit-point').addClass('hidden');
                    $('#benefit-point :input').prop('disabled', true);

                    $('#benefit-voucher').removeClass('hidden');
                    $('#benefit-voucher :input').removeAttr('disabled');
                }
            }).change();
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
                <span>{{ $title }}</span> @if (!empty($sub_title))
                <i class="fa fa-circle"></i> @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div>
    <br> 

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">New Quest</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <div class="portlet-body form">
                        <form id="form" class="form-horizontal" role="form" action="{{ url('quest/create') }}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                            Name
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Quest Name" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="quest[name]" value="{{ old('quest.name') }}" placeholder="Quest" required maxlength="20">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Image Quest
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar Quest" data-container="body"></i>
                                        <br>
                                        <span class="required" aria-required="true"> (500*500) </span>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                                <div id="classImage">
                                                    <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/*" class="file" name="quest[image]" value="{{ old('quest.image') }}" required>
                                                    </span>
                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Quest Publish Periode <span class="required" aria-required="true"> * </span> </label>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="quest[publish_start]" value="{{ old('quest.publish_start') }}" required autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Start Publish Quest" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="quest[publish_end]" value="{{ old('quest.publish_end') }}" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="End Publish Quest (Leave this column, if the quest is active forever)" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Quest Periode <span class="required" aria-required="true"> * </span> </label>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="quest[date_start]" value="{{ old('quest.date_start') }}" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Start Peroide Quest" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="quest[date_end]" value="{{ old('quest.date_end') }}" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="End Peroide Quest (Leave this column, if the quest is active forever)" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Short Description
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <textarea name="quest[short_description]" class="form-control" placeholder="Quest Short Description">{{ old('quest.short_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Description
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang quest yang dibuat" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <textarea name="quest[description]" id="field_content_long" class="form-control summernote" placeholder="Quest Description">{{ old('quest.description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Benefit
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Hadiah yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control select2" id="benefit-selector" name="quest_benefit[benefit_type]" data-placeholder="Benefit Type" required>
                                            <option value="point" {{old('quest_benefit.benefit_type') == 'point' ? 'selected' : ''}}>{{env('POINT_NAME', 'Points')}}</option>
                                            <option value="voucher" {{old('quest_benefit.benefit_type') == 'voucher' ? 'selected' : ''}}>Voucher</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="benefit-voucher">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Benefit Voucher
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Voucher yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="number" min="1" class="form-control" name="quest_benefit[value]" placeholder="Total Voucher" required value="{{old('quest_benefit.value', 1)}}"/>
                                            <span class="input-group-addon">Voucher</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2" name="quest_benefit[id_deals]" data-placeholder="Select Voucher" required>
                                            <option></option>
                                            @foreach($deals as $deal)
                                            <option value="{{$deal['id_deals']}}" {{old('quest_benefit.id_deals') == $deal['id_deals'] ? 'selected' : ''}}>{{$deal['deals_title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="benefit-point">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Benefit Point Nominal
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nominal point yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" min=0 class="form-control" name="quest_benefit[value]" placeholder="Nominal Point" required  value="{{old('quest_benefit.value', 0)}}" />
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @foreach($details as $index => $detail)
                            <div class="form-body box-repeat" style="display: table;width: 100%;">
                                <div class="box">
                                    <div class="col-md-2 text-right" style="text-align: -webkit-right;">
                                        <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                    Name
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="detail[{{$index}}][name]" placeholder="Detail Quest" required maxlength="20" value="{{$detail['name'] ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Short Description
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <textarea name="detail[{{$index}}][short_description]" class="form-control" placeholder="Quest Detail Short Description">{{$detail['short_description'] ?? ''}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Image Default Badge
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                                                <br>
                                                <span class="required" aria-required="true"> (500*500) </span>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                        <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                                        <div>
                                                            <span class="btn default btn-file">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" class="file" accept="image/*" name="detail[{{$index}}][logo_badge]" required>
                                                            </span>
                                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                    Quest Rule
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-9">
                                                <div class="mt-checkbox-inline">
                                                    <label class="mt-checkbox" style="margin-left: 15px;">
                                                        <input type="checkbox" class="rule_trx"> Transaction
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-checkbox">
                                                        <input type="checkbox" class="rule_product"> Product
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-checkbox">
                                                        <input type="checkbox" class="rule_total"> Total
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-checkbox">
                                                        <input type="checkbox" class="rule_additional"> Additional
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group trx_rule_form" hidden>
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Transaction Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[{{$index}}][trx_nominal]" placeholder="Transaction Nominal" value="{{$detail['trx_nominal'] ?? ''}}">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group product_rule_form" hidden>
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Product Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select class="form-control select2-multiple id_product" data-placeholder="Select Product" name="detail[{{$index}}][id_product]">
                                                        <option></option>
                                                        @foreach ($product as $item)
                                                            <option value="{{$item['id_product']}}" {{($detail['id_product'] ?? '') == $item['id_product'] ? 'selected' : ''}}>{{$item['product_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control total_product" name="detail[{{$index}}][product_total]" placeholder="Total Product">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group total_rule_form" hidden>
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Total Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <select class="form-control select2-multiple rule_totalnya" name="detail[{{$index}}][rule_total]" id="total_rule" data-placeholder="Select Total Rule By">
                                                            <option></option>
                                                            <option value="total_transaction" {{($detail['rule_total'] ?? '') == 'total_transaction' ? 'selected' : ''}}>Transaction</option>
                                                            <option value="total_outlet" {{($detail['rule_total'] ?? '') == 'total_outlet' ? 'selected' : ''}}>Outlet Different</option>
                                                            <option value="total_province" {{($detail['rule_total'] ?? '') == 'total_province' ? 'selected' : ''}}>Province Different</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control digit_mask value_totalnya" name="detail[{{$index}}][value_total]" placeholder="Value Total">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group additional_rule_form" hidden>
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Additional Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4" id="select_outlet">
                                                <div class="input-icon right">
                                                    <select class="form-control select2-multiple id_outlet" data-placeholder="Select Outlet" name="detail[{{$index}}][id_outlet]">
                                                        <option></option>
                                                        @foreach ($outlet as $item)
                                                            <option value="{{$item['id_outlet']}}" {{($detail['id_outlet'] ?? '') == $item['id_outlet'] ? 'selected' : ''}}>{{$item['outlet_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="select_province">
                                                <div class="input-icon right">
                                                    <select class="form-control select2-multiple id_province" data-placeholder="Select Province" name="detail[{{$index}}][id_province]">
                                                        <option></option>
                                                        @foreach ($province as $item)
                                                            <option value="{{$item['id_province']}}" {{($detail['id_province'] ?? '') == $item['id_province'] ? 'selected' : ''}}>{{$item['province_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-rmv form-action col-md-12 text-right">
                                    <a href="javascript:;" class="btn btn-success add">
                                        <i class="fa fa-plus"></i> Add New Input
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            {{-- @include('deals::deals.step1-form') --}}
                            <div class="form-actions" style="margin-top: 10px;">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn green">Submit</button>
                                        <!-- <button type="button" class="btn default">Cancel</button> -->
                                    </div>
                                </div>
                            </div>
                            {{--
                            <input type="hidden" name="id_deals" value="{{ $deals['id_deals'] }}">
                            <input type="hidden" name="deals_type" value="{{ $deals['deals_type'] }}"> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.main') 

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection 

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        const product_variants = {!!json_encode($product_variant_groups)!!};
        let counter_rule = {{count($details)}};
        function addRule() {
            const template = `
                <div class="portlet light bordered detail-container-item" id="detail-container-item-${counter_rule}">
                    <div class="portlet-body row">
                        <div class="col-md-1 text-right" style="text-align: -webkit-right;">
                            <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Name
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="detail[${counter_rule}][name]" placeholder="Detail Quest" required maxlength="40" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Short Description
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <textarea name="detail[${counter_rule}][short_description]" class="form-control" placeholder="Quest Detail Short Description">{{$detail['short_description'] ?? ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Total Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select quest rule" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <select class="form-control select2 quest_rule" name="detail[${counter_rule}][quest_rule]" data-placeholder="Select Quest Rule" required>
                                                <option></option>
                                                <option value="nominal_transaction">Transaction Nominal</option>
                                                <option value="total_transaction">Transaction Total</option>
                                                <option value="total_product">Product Total</option>
                                                <option value="total_outlet">Outlet Different</option>
                                                <option value="total_province">Province Different</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group additional_rule">
                                <label class="col-md-3 control-label">
                                    Additional Rule
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                </label>
                                <div class="col-md-9">
                                    <div class="mt-checkbox-inline">
                                        <label class="mt-checkbox rule_transaction not_nominal_transaction">
                                            <input type="checkbox" class="rule_trx"> Transaction
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox rule_product_add">
                                            <input type="checkbox" class="rule_product"> Product
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox additionalnya not_total_province">
                                            <input type="checkbox" class="rule_additional"> Additional
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group trx_rule_form">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Transaction Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[${counter_rule}][trx_nominal]" placeholder="Transaction Nominal">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product_rule_form">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Product Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_product" data-placeholder="Select Product" name="detail[${counter_rule}][id_product]">
                                                <option></option>
                                                @foreach ($product as $item)
                                                    <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 not_total_product">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form-control total_product product_total_rule" name="detail[${counter_rule}][product_total]" placeholder="Total Product">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group has_variant">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Product Variant Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Select a product variant. leave blank, if the quest is not based on the product variant" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-checkbox-inline">
                                            <label class="mt-checkbox" style="margin-left: 15px;">
                                                <input type="checkbox" class="use_variant rule_product_variant"> Use Variant
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-offset-3 col-md-4 product_variant_rule_form">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_product_variant" data-placeholder="Select Variant" name="detail[${counter_rule}][id_product_variant_group]">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group additional_rule_form">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Additional Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4 select_province">
                                    <div class="input-icon right">
                                        <select class="form-control select2 id_province province_total_rule" data-placeholder="Select Province" name="detail[${counter_rule}][id_province]">
                                            <option></option>
                                            @foreach ($province as $item)
                                                <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 select_outlet">
                                    <div class="input-icon right">
                                        <select class="form-control select2 id_outlet" data-placeholder="Select Outlet" name="detail[${counter_rule}][id_outlet] outlet_total_rule">
                                            <option></option>
                                            <option value="0">Outlet Group Filter</option>
                                            @foreach ($outlet as $item)
                                                <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-offset-3 col-md-4 select_outlet_group_filter" style="margin-top: 10px">
                                    <div class="input-icon right">
                                        <select class="form-control select2 id_outlet_group" data-placeholder="Select Outlet Group Filter" name="detail[${counter_rule}][id_outlet_group]">
                                            <option></option>
                                            @foreach ($outlet_group_filters as $item)
                                                <option value="{{$item['id_outlet_group']}}">{{$item['outlet_group_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch nominal_transaction_form">
                                <label class="col-md-3 control-label">
                                    Transaction Nominal
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Transaction Nominal" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][trx_nominal]" placeholder="Transaction Nominal">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_transaction_form">
                                <label class="col-md-3 control-label">
                                    Transaction Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Transaction Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][trx_total]" placeholder="Transaction Total">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_product_form">
                                <label class="col-md-3 control-label">
                                    Product Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Product Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][product_total]" placeholder="Product Total">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_outlet_form">
                                <label class="col-md-3 control-label">
                                    Outlet Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Outlet Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][different_outlet]" placeholder="Outlet Total">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_province_form">
                                <label class="col-md-3 control-label">
                                    Province Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Province Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][different_province]" placeholder="Province Total">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#detail-container').append(template);
            $(`#detail-container-item-${counter_rule} .quest_rule`).change();
            $(`#detail-container-item-${counter_rule} .rule_trx`).change();
            $(`#detail-container-item-${counter_rule} .rule_product`).change();
            $(`#detail-container-item-${counter_rule} .rule_additional`).change();
            $(`#detail-container-item-${counter_rule} .rule_product_variant`).change();
            $(`#detail-container-item-${counter_rule} .digit_mask`).inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 0,
                autoGroup: true,
                rightAlign: false,
                removeMaskOnSubmit: true, 
            });
            $(`#detail-container-item-${counter_rule} .select2`).select2();

            counter_rule++;
        }

        $(document).ready(function() {
            $('.select2').select2();

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

            $(".form_datetime").datetimepicker({
                format: "d-M-yyyy hh:ii",
                autoclose: true,
                todayBtn: true,
                minuteStep: 1
            });

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

            $('#autoclaim-selector').on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    $('.manualclaim-only').hide();
                    $('.manualclaim-only :input').prop('disabled', true);
                } else {
                    $('.manualclaim-only').show();
                    $('.manualclaim-only :input').removeAttr('disabled');
                }
            }).change();

            if ($('#autoclaim-selector').is(':checked')) {
                $('.manualclaim-only').hide();
                $('.manualclaim-only :input').prop('disabled', true);
            } else {
                $('.manualclaim-only').show();
                $('.manualclaim-only :input').removeAttr('disabled');
            }

            $('[value="duration"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.duration-only').show();
                    $('.duration-only :input').removeAttr('disabled');
                    $('.dates-only').hide();
                    $('.dates-only :input').prop('disabled', true);
                } else {
                    $('.duration-only').hide();
                    $('.duration-only :input').prop('disabled', true);
                }
            }).change();

            $('[value="dates"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.dates-only').show();
                    $('.dates-only :input').removeAttr('disabled');
                    $('.duration-only').hide();
                    $('.duration-only :input').prop('disabled', true);
                } else {
                    $('.dates-only').hide();
                    $('.dates-only :input').prop('disabled', true);
                }
            }).change();

            $('.digit_mask').inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 0,
                autoGroup: true,
                rightAlign: false,
                removeMaskOnSubmit: true, 
            });

            $('#detail-container').on('change', '.quest_rule', function() {
                const parent = $(this).parents('.detail-container-item');
                parent.find('.form_switch').hide();
                parent.find('.form_switch :input').prop('disabled', true);
                if ($(this).val()) {
                    parent.find('.additional_rule').show();
                    parent.find('.additional_rule :input').removeAttr('disabled');

                    parent.find('.not_nominal_transaction').show();
                    parent.find('.not_nominal_transaction :input').removeAttr('disabled');

                    parent.find('.not_total_province').show();
                    parent.find('.not_total_province :input').removeAttr('disabled');

                    parent.find('.not_total_product').show();
                    parent.find('.not_total_product :input').removeAttr('disabled');

                    parent.find(`.${$(this).val()}_form`).show();
                    parent.find(`.${$(this).val()}_form :input`).removeAttr('disabled');
                    parent.find('.not_total_product :input').removeAttr('disabled');
                    switch ($(this).val()) {
                        case 'nominal_transaction':
                            parent.find('.not_nominal_transaction').hide();
                            parent.find('.not_nominal_transaction :input').prop('disabled', true);
                            break;
                        case 'total_transaction':
                            break;
                        case 'total_product':
                            parent.find('.not_total_product').hide();
                            parent.find('.not_total_product :input').prop('disabled', true);
                            break;
                        case 'total_outlet':
                            break;
                        case 'total_province':
                            parent.find('.not_total_province').hide();
                            parent.find('.not_total_province :input').prop('disabled', true);
                            break;
                    }
                    $('#detail-container .rule_trx').change();
                    $('#detail-container .rule_product').change();
                    $('#detail-container .rule_additional').change();
                    $('#detail-container .rule_product_variant').change();
                } else {
                    parent.find('.additional_rule').hide();
                    parent.find('.additional_rule :input').prop('disabled', true);
                }
            });
            $('#detail-container .quest_rule').change();

            $('#detail-container').on('change', '.rule_trx', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.trx_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
            });
            $('#detail-container .rule_trx').change();

            $('#detail-container').on('change', '.rule_product', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.product_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
            });
            $('#detail-container .rule_product').change();

            $('#detail-container').on('change', '.rule_additional', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.additional_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
                parent.find('.id_outlet').change();
            });
            $('#detail-container .rule_additional').change();

            $('#detail-container').on('change', '.rule_product_variant', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.product_variant_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
            });
            $('#detail-container .rule_product_variant').change();

            $('#detail-container').on('change', '.id_product', function() {
                const parent = $(this).parents('.detail-container-item');
                const variants = product_variants[$(this).val()];
                if (variants && $(this).val()) {
                    const html = [];
                    variants.forEach(item => {
                        html.push(`<option value="${item.id_product_variant_group}">${item.product_variants}</option>`);
                    });
                    parent.find('.id_product_variant').html(html.join(''));
                    parent.find('.has_variant').show();
                    parent.find('.has_variant :input').removeAttr('disabled');
                } else {
                    parent.find('.has_variant').hide();
                    parent.find('.has_variant :input').prop('disabled', true);
                }
            });
            $('#detail-container .id_product').change();

            $('#detail-container').on('change', '.id_outlet', function() {
                const parent = $(this).parents('.detail-container-item');
                if ($(this).val() === '0' && !$(this).prop('disabled')) {
                    parent.find('.select_outlet_group_filter').show();
                    parent.find('.select_outlet_group_filter :input').removeAttr('disabled');
                } else {
                    parent.find('.select_outlet_group_filter').hide();
                    parent.find('.select_outlet_group_filter :input').prop('disabled', true);
                }
            });
            $('#detail-container .id_outlet').change();
        });
        function removeBox(params) {
            $(params).parents('.detail-container-item').remove()
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
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('quest/create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Quest Name" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input type="text" name="quest[name]" class="form-control" placeholder="Enter text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Image Quest
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Quest" data-container="body"></i>
                            <br>
                            <span class="required" aria-required="true"> (500*500) </span>
                        </label>
                        <div class="col-md-9">
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
                        <label class="col-md-3 control-label">
                            Quest Calculation Start Date
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode perhitungan quest" data-container="body"></i>
                        </label>
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
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                        Quest Maximum Complete Periode
                        <i class="fa fa-question-circle tooltips" data-original-title="Periode penyelesaian quest oleh user" data-container="body"></i>
                        </label>
                        <div class="col-md-2">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="quest[quest_period_type]" id="radio9" value="dates" class="expiry md-radiobtn" required @if (old('quest.quest_period_type') == 'dates') checked @endif required>
                                    <label for="radio9">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> By Date </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="quest[quest_period_type]" id="radio10" value="duration" class="expiry md-radiobtn" required @if (old('quest.quest_period_type') == 'duration') checked @endif required>
                                    <label for="radio10">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Duration </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" col-md-offset-3 col-md-2 control-label">
                            Complete before
                        </div>
                        <div class="col-md-4 dates-only">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="quest[date_end]" value="{{ old('quest.date_end') }}" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Batas akhir user menyelesaikan quest" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 duration-only">
                            <div class="input-group">
                                <input type="text" class="form-control digit_mask" name="quest[max_complete_day]" placeholder="Max Complete Day" required  value="{{old('quest.max_complete_day', 0)}}" />
                                <div class="input-group-addon">day after claimed</div>
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
                            Autoclaim Quest
                            <i class="fa fa-question-circle tooltips" data-original-title="Apakah misi harus di claim manual atau otomatis" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1" name="quest[autoclaim_quest]" id="autoclaim-selector">
                        </div>
                    </div>
                    <div class="form-group manualclaim-only">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Quest Claim Limit
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal klaim untuk quest. Masukan 0 untuk tidak terbatas" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control digit_mask" name="quest[quest_limit]" placeholder="Claim limit" required  value="{{old('quest.quest_limit', 0)}}" />
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-center" style="margin-bottom:20px">Benefit</h4>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Benefit Type
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
                                <input type="text" class="form-control digit_mask" name="quest_benefit[value]" placeholder="Total Voucher" required value="{{old('quest_benefit.value', 1)}}"/>
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
                            <input type="text" class="form-control digit_mask" name="quest_benefit[value]" placeholder="Nominal Point" required  value="{{old('quest_benefit.value', 0)}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Autoclaim Benefit
                            <i class="fa fa-question-circle tooltips" data-original-title="Apakah hadiah langsung didapatkan ketika menyelesaikan misi atau harus klaim manual" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1" name="quest_benefit[autoclaim_benefit]">
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-center" style="margin-bottom:20px">Quest Rule</h4>
                    <div id="detail-container">
                        @foreach($details as $index => $detail)
                        <div class="portlet light bordered detail-container-item">
                            <div class="portlet-body row">
                                <div class="col-md-1 text-right" style="text-align: -webkit-right;">
                                    <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Name
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="detail[{{$index}}][name]" placeholder="Detail Quest" required maxlength="40" value="{{$detail['name'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Short Description
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-icon right">
                                                <textarea name="detail[{{$index}}][short_description]" class="form-control" placeholder="Quest Detail Short Description">{{$detail['short_description'] ?? ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                            Total Rule
                                            <i class="fa fa-question-circle tooltips" data-original-title="Select quest rule" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-icon right">
                                                <div class="input-group">
                                                    <select class="form-control select2 quest_rule" name="detail[{{$index}}][quest_rule]" data-placeholder="Select Quest Rule" required>
                                                        <option></option>
                                                        <option value="nominal_transaction">Transaction Nominal</option>
                                                        <option value="total_transaction">Transaction Total</option>
                                                        <option value="total_product">Product Total</option>
                                                        <option value="total_outlet">Outlet Different</option>
                                                        <option value="total_province">Province Different</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group additional_rule">
                                        <label class="col-md-3 control-label">
                                            Additional Rule
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox rule_transaction not_nominal_transaction">
                                                    <input type="checkbox" class="rule_trx"> Transaction
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox rule_product_add">
                                                    <input type="checkbox" class="rule_product"> Product
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox additionalnya not_total_province">
                                                    <input type="checkbox" class="rule_additional"> Additional
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group trx_rule_form">
                                        <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                            Transaction Rule
                                            <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-icon right">
                                                <div class="input-group">
                                                    <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[{{$index}}][trx_nominal]" placeholder="Transaction Nominal">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product_rule_form">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Product Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select class="form-control select2 id_product" data-placeholder="Select Product" name="detail[{{$index}}][id_product]">
                                                        <option></option>
                                                        @foreach ($product as $item)
                                                            <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 not_total_product">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control total_product product_total_rule" name="detail[{{$index}}][product_total]" placeholder="Total Product">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group has_variant">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Product Variant Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a product variant. leave blank, if the quest is not based on the product variant" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <div class="mt-checkbox-inline">
                                                    <label class="mt-checkbox" style="margin-left: 15px;">
                                                        <input type="checkbox" class="use_variant rule_product_variant"> Use Variant
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-offset-3 col-md-4 product_variant_rule_form">
                                                <div class="input-icon right">
                                                    <select class="form-control select2 id_product_variant" data-placeholder="Select Variant" name="detail[{{$index}}][id_product_variant_group]">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group additional_rule_form">
                                        <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                            Additional Rule
                                            <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-4 select_province">
                                            <div class="input-icon right">
                                                <select class="form-control select2 id_province province_total_rule" data-placeholder="Select Province" name="detail[{{$index}}][id_province]">
                                                    <option></option>
                                                    @foreach ($province as $item)
                                                        <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 select_outlet">
                                            <div class="input-icon right">
                                                <select class="form-control select2 id_outlet" data-placeholder="Select Outlet" name="detail[{{$index}}][id_outlet]">
                                                    <option></option>
                                                    <option value="0">Outlet Group Filter</option>
                                                    @foreach ($outlet as $item)
                                                        <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-offset-3 col-md-4 select_outlet_group_filter" style="margin-top: 10px">
                                            <div class="input-icon right">
                                                <select class="form-control select2 id_outlet_group" data-placeholder="Select Outlet Group Filter" name="detail[{{$index}}][id_outlet_group]">
                                                    <option></option>
                                                    @foreach ($outlet_group_filters as $item)
                                                        <option value="{{$item['id_outlet_group']}}">{{$item['outlet_group_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form_switch nominal_transaction_form">
                                        <label class="col-md-3 control-label">
                                            Transaction Nominal
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Transaction Nominal" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-icon right">
                                                <input type="text" class="form-control digit_mask" name="detail[{{$index}}][trx_nominal]" placeholder="Transaction Nominal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form_switch total_transaction_form">
                                        <label class="col-md-3 control-label">
                                            Transaction Total
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Transaction Total" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-icon right">
                                                <input type="text" class="form-control digit_mask" name="detail[{{$index}}][trx_total]" placeholder="Transaction Total">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form_switch total_product_form">
                                        <label class="col-md-3 control-label">
                                            Product Total
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Product Total" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-icon right">
                                                <input type="text" class="form-control digit_mask" name="detail[{{$index}}][product_total]" placeholder="Product Total">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form_switch total_outlet_form">
                                        <label class="col-md-3 control-label">
                                            Outlet Total
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Outlet Total" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-icon right">
                                                <input type="text" class="form-control digit_mask" name="detail[{{$index}}][different_outlet]" placeholder="Outlet Total">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form_switch total_province_form">
                                        <label class="col-md-3 control-label">
                                            Province Total
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Province Total" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-icon right">
                                                <input type="text" class="form-control digit_mask" name="detail[{{$index}}][different_province]" placeholder="Province Total">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <a href="javascript:;" class="btn btn-success add" onclick="addRule()">
                            <i class="fa fa-plus"></i> Add New Input
                        </a>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <button type="button" class="btn default">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
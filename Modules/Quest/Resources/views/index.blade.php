<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')
@include('infinitescroll')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
@yield('is-style')
    <style>
        .dropleft .dropdown-menu{
        	top: -100% !important;
        	left: -180px !important;
        	right: auto;
        }
		.btn-group > .dropdown-menu::after, .dropleft > .dropdown-toggle > .dropdown-menu::after, .dropdown > .dropdown-menu::after {
            opacity: 0;
		}
		.btn-group > .dropdown-menu::before, .dropleft > .dropdown-toggle > .dropdown-menu::before, .dropdown > .dropdown-menu::before {
            opacity: 0;
		}
        .modal-open .select2-container--open { z-index: 999999 !important; width:100% !important; }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@yield('is-script')
<script>
    template = {
        differentprice: function(item){
            const publish_start = item.publish_start?(new Date(item.publish_start).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            const publish_end = item.publish_end?(new Date(item.publish_end).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            const date_start = item.date_start?(new Date(item.date_start).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            const date_end = item.date_end?(new Date(item.date_end).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            return `
            <tr class="page${item.page}">
                <td class="text-center">${item.increment}</td>
                <td>${item.name}</td>
                <td>${publish_start}</td>
                <td>${publish_end}</td>
                <td>${date_start}</td>
                <td>${date_end}</td>
                <td>
                    <div class="btn-group btn-group-solid pull-right dropleft">
                        <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div id="loadingBtn" hidden>
                                <i class="fa fa-spinner fa-spin"></i> Loading
                            </div>
                            <div id="moreBtn">
                                <i class="fa fa-ellipsis-horizontal"></i> More
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown">
                            @if(MyHelper::hasAccess([224], $grantedFeature))
                            <li style="margin: 0px;">
                                <a href="#editQuest" data-toggle="modal" onclick="editQuest(${item.id_quest})"> Edit </a>
                            </li>
                            @endif
                            <li style="margin: 0px;">
                                <a href="{{url('quest/detail/${item.id_quest}')}}/"> Detail </a>
                            </li>
                            @if(MyHelper::hasAccess([225], $grantedFeature))
                            <li style="margin: 0px;">
                                <a href="javascript:;" onclick="removeQuest(this, ${item.id_quest})"> Remove </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>
            `;
        }
    };
    function removeQuest(params, data) {
        var btn = $(params).parent().parent().parent().before().children()
        btn.find('#loadingBtn').show()
        btn.find('#moreBtn').hide()
        $.post( "{{ url('quest/remove') }}", { id_quest: data, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            if (data.status == 'success') {
                var removeDiv = $(params).parents()[4]
                removeDiv.remove()
            }
            btn.find('#loadingBtn').hide()
            btn.find('#moreBtn').show()
        });
    }
    function editQuest(params) {
        $.post( "{{ url('quest/detailAjax') }}", { id_quest: params, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            $('#editQuest').find("select[name='category[name]']").val(data.id_quest_category).trigger('change')
            $('#editQuest').find("img").attr("src", data.logo_badge_default)
            $('#editQuest').find("input[name='group[name]']").val(data.name).trigger('change')

            $('#editQuest').find("input[name='group[date_start]']").val(data.date_start).trigger('change')
            if (!data.is_start) {
                $('#editQuest').find("input[name='group[date_start]']").removeAttr('disabled');
            } else {
                $('#editQuest').find("input[name='group[date_start]']").attr('disabled', 'disabled');
            }

            $('#editQuest').find("input[name='group[date_end]']").val(data.date_end).trigger('change')
            // if (!data.is_start || data.date_end.length === 0) {
            //     $('#editQuest').find("input[name='group[date_end]']").removeAttr('disabled');
            // } else {
            //     $('#editQuest').find("input[name='group[date_end]']").attr('disabled', 'disabled');
            // }

            $('#editQuest').find("input[name='group[publish_start]']").val(data.publish_start).trigger('change')
            if (!data.is_start) {
                $('#editQuest').find("input[name='group[publish_start]']").removeAttr('disabled');
            } else {
                $('#editQuest').find("input[name='group[publish_start]']").attr('disabled', 'disabled');
            }
            $('#editQuest').find("input[name='group[publish_end]']").val(data.publish_end).trigger('change')
            // $('#editQuest').find("input[name='group[date_start]']").val(data.date_start).trigger('change')
            // $('#editQuest').find("input[name='group[date_end]']").val(data.date_end).trigger('change')
            // var desc = `<textarea name="group[description]" id="field_content_long" class="form-control summernote" placeholder="Quest Description">${data.description}</textarea>`
            // $('#editQuest').find("#field_content_long").replaceWith(desc)
            $('#editQuest').find("input[name='group[progress_text]']").val(data.progress_text).trigger('change')
            if (data.is_calculate == 1) {
                $('#editQuest').find("#calculate_1").prop("checked", true)
            } else {
                $('#editQuest').find("#calculate_0").prop("checked", true)
            }
            $("#field_content_long").summernote("code", String(data.description));
            $('#editQuest').find("input[name='id_quest']").val(data.id_quest).trigger('change')
            // $('#editQuest').find("input[name='different_outlet']").val(data.different_outlet).trigger('change')
            // $('#editQuest').find("select[name='id_province']").val(data.id_province).trigger('change')
            // $('#editQuest').find("input[name='different_province']").val(data.different_province).trigger('change')
            // $('#editQuest').find("input[name='id_quest_detail']").val(data.id_quest_detail)
            // $('.digit_mask').inputmask({
            //     removeMaskOnSubmit: true, 
            //     placeholder: "",
            //     alias: "currency", 
            //     digits: 0, 
            //     rightAlign: false,
            //     min: 0,
            //     max: '999999999'
            // });
            var rule = ''
            if(data.order_by == 'nominal_transaction'){
                rule = 'Transaction Nominal'
            }else if(data.order_by == 'total_transaction'){
                rule = 'Transaction Total'
            }else if(data.order_by == 'total_product'){
                rule = 'Product Total'
            }else if(data.order_by == 'total_outlet'){
                rule = 'Outlet Different'
            }else if(data.order_by == 'total_province'){
                rule = 'Province Different'
            }
            $('#editQuest').find("input[name='total_rule']").val(rule)

            if(data.trx_nominal != null){
                $('#editQuest').find('.trx_rule_form').show()
                $('#editQuest').find("input[name='transaction_rule']").val(data.trx_nominal)
            }else{
                $('#editQuest').find('.trx_rule_form').hide()
            }
            if(data.id_product != null){
                $('#editQuest').find('.product_rule_form').show()
                $('#editQuest').find('.product_variant_rule_form').show()
                $.ajax({
                    type: 'GET',
                    url: "{{url('product/ajax/simple')}}"
                }).then(function (dataProduct) {
                    // create the option and append to Select2
                    $('.id_product').empty()
                    $.each( dataProduct, function( key, value ) {
                        if(value.id_product == data.id_product){
                            var option = new Option(value.product_name, value.id_product, true, true);
                        }else{
                            var option = new Option(value.product_name, value.id_product);
                        }
                        $('.id_product').append(option);
                    });
                });
            }else{
                $('#editQuest').find('.product_rule_form').hide()
                $('#editQuest').find('.product_variant_rule_form').hide()
            }

            if(data.product_total > 0 && data.order_by != 'total_product'){
                $('#editQuest').find('.product_total_form').show()
                $('#product_total_rule').val(data.product_total)
            }

            if(data.id_product_variant_group != null){
                $("#use_variant").attr('checked', 'checked');
                $('#editQuest').find('.product_variant_rule_option').show()
            }
            $.ajax({
                type: 'GET',
                url: "{{url('product-variant-group/ajax')}}/" + data.id_product
            }).then(function (dataVariant) {
                // create the option and append to Select2
                $('.id_product_variant').empty()
                $.each( dataVariant, function( key, value ) {
                    if(value.id_product_variant_group == data.id_product_variant_group){
                        var option = new Option(value.product_variant_group_name, value.id_product_variant_group, true, true);
                    }else{
                        var option = new Option(value.product_variant_group_name, value.id_product_variant_group, true, false);
                    }
                    $('.id_product_variant').append(option).trigger('change');
                });
                $('.id_product_variant').val(data.id_product_variant_group).trigger("change")
            });


            if(data.id_province != null || data.id_outlet){
                $('#editQuest').find('.additional_rule_form').show()
                if(data.id_province != null){
                    $('#editQuest').find("input[name='province_rule']").val(data.province_name)
                }
                if(data.id_province != null){
                    $('#editQuest').find("input[name='outlet_rule']").val(data.outlet_name)
                }
            }else{
                $('#editQuest').find('.additional_rule_form').hide() 
            }

            // $('#editQuest').find("input[name='total_rule']").val(rule)
            $(".select2-rule").select2({
                width: '100%'
            });
            $("#selectCategory").select2({
                tags: true
            });
            $("#selectProduct").select2({
                tags: true
            });

        });
    }
    function updater(table,response){
    }
    $(document).ready(function(){
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
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
                ['fontname', ['fontname']],
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
        $('.is-container').on('change','.checkbox-different',function(){
            var status = $(this).is(':checked')?1:0;
            if($(this).data('auto')){
                $(this).data('auto',0);
            }else{
                const selector = $(this);
                $.post({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    url: "{{url('outlet/different-price/update')}}",
                    data: {
                        ajax: 1,
                        id_outlet: $(this).data('id'),
                        status: status
                    },
                    success: function(response){
                        selector.data('auto',1);
                        if(response.status == 'success'){
                            toastr.info("Update success");
                            if(response.result == '1'){
                                selector.prop('checked',true);
                            }else{
                                selector.prop('checked',false);
                            }
                        }else{
                            toastr.warning("Update fail");
                            if(status == 1){
                                selector.prop('checked',false);
                            }else{
                                selector.prop('checked',true);
                            }
                        }
                        selector.change();
                    },
                    error: function(data){
                        toastr.warning("Update fail");
                        selector.data('auto',1);
                        if(status == 1){
                            selector.prop('checked',false);
                        }else{
                            selector.prop('checked',true);
                        }
                        selector.change();
                    }
                });
            }
        });
        $("#selectCategory").select2({
            dropdownParent: $('#editQuest')
        });
        $('#use_variant').change(function() {
            if ($(this).is(':checked')) {
                $('#editQuest').find('.product_variant_rule_option').show()
            }else{
                $('#editQuest').find('.product_variant_rule_option').hide()
            }
        });

        $('.id_product').change(function() {
            var id_product = $(this).val()
            $.ajax({
                type: 'GET',
                url: "{{url('product-variant-group/ajax')}}/" + id_product
            }).then(function (data) {
                // create the option and append to Select2
                $('.id_product_variant').empty()
                $.each( data, function( key, value ) {
                    var option = new Option(value.product_variant_group_name, value.id_product_variant_group, true, true);
                    $('.id_product_variant').append(option).trigger('change');
                });
                $('.id_product_variant').val("").trigger("change")
            });
        });
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
                <span class="caption-subject font-blue sbold uppercase">Quest List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class=" table-responsive is-container">
                <div class="row">
                    <div class="col-md-offset-9 col-md-3">
                        <form class="filter-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control search-field" name="keyword" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button class="btn blue search-btn" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-infinite">
                    <table class="table table-striped" id="tableTrx" data-template="differentprice"  data-page="0" data-is-loading="0" data-is-last="0" data-url="{{url()->current()}}" data-callback="updater" data-order="promo_campaign_referral_transactions.created_at" data-sort="asc">
                        <thead>
                            <tr>
                                <th style="width: 1%" class="text-center">No</th>
                                <th>Name</th>
                                <th>Quest Publish Start</th>
                                <th>Quest Publish End</th>
                                <th>Quest Start</th>
                                <th>Quest End</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div><span class="text-muted">Total record: </span><span class="total-record"></span></div>
            </div>
        </div>
    </div>

@endsection

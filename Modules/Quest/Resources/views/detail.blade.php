<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
    $grantedFeature     = session('granted_features');
    date_default_timezone_set('Asia/Jakarta');
 ?>
@extends('layouts.main-closed')
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
	
	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }
	    
	    .cont-col2{
	        margin-left: 30px;
	    }
        .page-container-bg-solid .page-content {
            background: #fff!important;
        }
        .v-align-top {
            vertical-align: top;
        }
        .width-voucher-img {
            max-width: 150px;
        }
        .custom-text-green {
            color: #28a745!important;
        }
        .font-black {
            color: #333!important;
        }
        .pull-right>.dropdown-menu{
            left: 0;
        }
        .fa-chevron-right {
            transition-duration: .2s;
        }
        a[aria-expanded=true] .fa-chevron-right {
            transform: rotate(-90deg);
        }
        a[aria-expanded=false] .fa-chevron-right {
            transform: rotate(90deg);
        }
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>

	<script>
    $(document).ready( function () {
        $('.select2-multiple').select2({
            placeholder : "Select",
            allowClear : true,
            width: '100%'
        })
        $('.digit_mask').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            min: 0,
            max: '999999999'
        });
        var index = 1;
        $('.addBox').click(function() {
            nomer = index++
            $('.btn-rmv').before(`<div class="box"> <div class="col-md-2 text-right" style="text-align: -webkit-right;"> <a href="javascript:;" onclick="removeBox(this)" class="remove-btn btn btn-danger"> <i class="fa fa-close"></i> </a> </div><div class="col-md-10"> <div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Name <span class="required" aria-required="true"> * </span> <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i> </label> </div><div class="col-md-8"> <input type="text" class="form-control" name="detail[`+nomer+`][name]" placeholder="Detail Quest" required maxlength="20"> </div></div><div class="form-group"><div class="input-icon right"><label class="col-md-3 control-label">Short Description<span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Short Description" data-container="body"></i></label></div><div class="col-md-8"><input type="text" class="form-control" name="detail[`+nomer+`][short_description]" placeholder="Short Description" required maxlength="20"></div></div><div class="form-group"><div class="input-icon right"><label class="col-md-3 control-label">Quest Category Product Rule<i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i></label></div><div class="col-md-4"><div class="input-icon right"><select class="form-control select2-multiple" data-placeholder="Select Category Product" name="detail[`+nomer+`][id_product_category]"><option></option>@foreach ($category as $item)<option value="{{$item['id_product_category']}}">{{$item['product_category_name']}}</option>@endforeach</select></div></div><div class="col-md-4"><div class="input-icon right"><div class="input-group"><select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[`+nomer+`][different_category_product]"><option></option><option value="1">Yes</option><option value="0">No</option></select><span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-question-circle tooltips" data-original-title="Rule for different category product" data-container="body"></i></button></span></div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Product Rule <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[`+nomer+`][id_product]"> <option></option>  @foreach ($product as $item) <option value="{{$item['id_product']}}">{{$item['product_name']}}</option> @endforeach </select> </div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <input type="text" class="form-control" name="detail[`+nomer+`][product_total]" placeholder="Total Product"> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i> </button> </span> </div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Transaction Rule <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <input type="text" class="form-control digit_mask" name="detail[`+nomer+`][trx_nominal]" placeholder="Transaction Nominal"> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i> </button> </span> </div></div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <input type="text" class="form-control digit_mask" name="detail[`+nomer+`][trx_total]" placeholder="Transaction Total"> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i> </button> </span> </div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Outlet Rule <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[`+nomer+`][id_outlet]"> <option></option> @foreach ($outlet as $item) <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option> @endforeach </select> </div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[`+nomer+`][different_outlet]"> <option></option> <option value="1">Yes</option> <option value="0">No</option> </select> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Rule for different outlet" data-container="body"></i> </button> </span> </div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Province Rule <i class="fa fa-question-circle tooltips" data-original-title="Select a province. leave blank, if the quest is not based on the province" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <select class="form-control select2-multiple" data-placeholder="Select Province" name="detail[`+nomer+`][id_province]"> <option></option> @foreach ($province as $item) <option value="{{$item['id_province']}}">{{$item['province_name']}}</option> @endforeach </select> </div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[`+nomer+`][different_province]"> <option></option> <option value="1">Yes</option> <option value="0">No</option> </select> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Rule for different province" data-container="body"></i> </button> </span> </div></div></div></div></div></div>`);
            $('.digit_mask').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 0,
                max: '999999999'
            });
            $(".select2-multiple").select2({
                allowClear: true,
                width: '100%'
            });
        });

        function sendFile(file, id){
            token = "<?php echo csrf_token(); ?>";
            var data = new FormData();
            data.append('image', file);
            data.append('_token', token);
            // document.getElementById('loadingDiv').style.display = "inline";
            $.ajax({
                url : "{{url('summernote/picture/upload/advert')}}",
                data: data,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(url) {
                    if (url['status'] == "success") {
                        console.log(url);
                        $('#'+id).summernote('editor.saveRange');
                        $('#'+id).summernote('editor.restoreRange');
                        $('#'+id).summernote('editor.focus');
                        $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                    }
                    // document.getElementById('loadingDiv').style.display = "none";
                },
                error: function(data){
                    // document.getElementById('loadingDiv').style.display = "none";
                }
            })
        }

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
        $('#quest-content-container').on('click', '.delete-btn', function() {
            $($(this).parents('.accordion-item')[0]).remove();
        });

        $('.sortable').sortable({
            items: '> div:not(.unsortable)',
            handle: ".sortable-handle",
            connectWith: ".sortable",
            axis: 'y',
        });
    })
    function removeBox(params) {
        $(params).parent().parent().remove()
    }
    function editBadge(params) {
        console.log(params)
        $('#editBadge').find("input[name='name']").val(params.name)
        $('#editBadge').find("input[name='short_description']").val(params.short_description)
        $('#editBadge').find("select[name='id_product_category']").val(params.id_product_category).trigger('change')
        $('#editBadge').find("input[name='different_category_product']").val(params.different_category_product).trigger('change')
        $('#editBadge').find("select[name='id_product']").val(params.id_product).trigger('change')
        $('#editBadge').find("input[name='trx_nominal']").val(params.trx_nominal)
        $('#editBadge').find("input[name='trx_total']").val(params.trx_total)
        $('#editBadge').find("input[name='product_total']").val(params.product_total)
        $('#editBadge').find("select[name='id_outlet']").val(params.id_outlet).trigger('change')
        $('#editBadge').find("select[name='different_outlet']").val(params.different_outlet).trigger('change')
        $('#editBadge').find("select[name='id_province']").val(params.id_province).trigger('change')
        $('#editBadge').find("select[name='different_province']").val(params.different_province).trigger('change')
        $('#editBadge').find("input[name='id_quest_detail']").val(params.id_quest_detail)
        $('.digit_mask').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            min: 0,
            max: '999999999'
        });
        $(".select2-multiple").select2({
            allowClear: true,
            width: '100%'
        });
    }
    function removeBadge(params, data) {
        var btn = $(params).parent().parent().parent().before().children()
        btn.find('#loadingBtn').show()
        btn.find('#moreBtn').hide()
        $.post( "{{ url('quest/remove') }}", { id_quest_detail: data, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            if (data.status == 'success') {
                var removeDiv = $(params).parents()[5]
                removeDiv.remove()
            }
            btn.find('#loadingBtn').hide()
            btn.find('#moreBtn').show()
        });
    }
    let detail_count = $('#quest-content-container').children().length;
    function addCustomContent() {
        detail_count++;
        $('#quest-content-container').append(`
            <div id="accordion${detail_count}" class="accordion-item" style="padding-bottom: 10px;">
                <div class="row">
                    <div class="col-md-6 content-title">
                        <div class="input-group">
                            <span class="input-group-addon sortable-handle"><a><i class="fa fa-arrows-v"></i></a></span>
                            <input type="text" class="form-control" name="content[${detail_count}][title]"  placeholder="Content Title" required maxlength="20" value="">
                            <input type="hidden" name="content[${detail_count}][id_quest_content]" value="0" >
                            <input type="hidden" name="content_order[]" value="${detail_count}">
                            <span class="input-group-addon">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion${detail_count}" aria-expanded="false" href="#collapse_${detail_count}">
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" class="make-switch visibility-switch" data-on="success" data-on-color="success" data-on-text="Visible" data-off-text="Hidden" data-size="normal" name="content[${detail_count}][is_active]">
                    </div>
                    <div class="col-md-3 text-right">
                        <button class="btn btn-danger delete-btn" type="button"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="col-md-12 accordion-body collapse" style="margin-top: 10px; " id="collapse_${detail_count}">
                        <textarea name="content[${detail_count}][content]" class="form-control summernote" placeholder="Content"></textarea>
                    </div>
                </div>
                <hr style="border-bottom: 1px solid #F0F5F7;margin: 10px 0"/>
            </div>
        `);
        $(`input[name="content[${detail_count}][is_active]"]`).bootstrapSwitch();
        $(`textarea[name="content[${detail_count}][content]"]`).summernote({
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
			<a href="{{url('/')}}">Home</a>
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
</div>
@include('layouts.notifications')
@include('quest::detail_modal')
<div class="row" style="margin-top:20px">
    {{-- <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="3">{{ !empty($result['total_coupon']) ? number_format(($result['total_coupon']??0)-($result['count']??0)) : isset($result['total_coupon']) ? 'unlimited' : '' }}</span>
                            </div>
                            <div class="desc"> Available </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 red">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="20">{{ number_format($result['count']??0) }}</span>
                            </div>
                            <div class="desc"> Total Used </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{$result['total_coupon']??''}}">{{ !empty($result['total_coupon']) ? number_format($result['total_coupon']??0) : isset($result['total_coupon']) ? 'unlimited' : '' }}</span>
                            </div>
                            <div class="desc"> Total {{ isset($result['total_coupon']) ? 'Coupon' : '' }} </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $data['quest']['name'] }}</span>
            </div>
        </div>
        <div class="portlet-body">

            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @if(MyHelper::hasAccess([230], $grantedFeature))
                        @if ($data['quest']['is_complete'] != 1)
                            <form action="{{url('quest/detail/'.$data['quest']['id_quest'].'/start')}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary blue" style="float: right; "><i class="fa fa-play"></i> Start Quest</button>
                            </form>
                        @endif
                    @endif
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#overview" data-toggle="tab"> Quest Overview </a>
                        </li>
                        <li>
                            <a href="#content" data-toggle="tab"> Content Info </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="margin-top:20px">
                        <div class="tab-pane active" id="overview">
                            @include('quest::detail_tab_overview')
                        </div>
                        <div class="tab-pane" id="content">
                            @include('quest::detail_tab_content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
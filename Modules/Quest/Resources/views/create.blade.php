@extends('layouts.main') 

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
@endsection 

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
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
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'help']]
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
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>

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
            var index = 1;
            $('.add').click(function() {
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
                $("#selectCategory").select2({
                    tags: true
                });
                $(".select2-multiple").select2({
                    allowClear: true
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
        });
        function removeBox(params) {
            $(params).parent().parent().remove()
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
                <span class="caption-subject font-blue bold uppercase">Achivement</span>
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
                                                <input type="text" class="form_datetime form-control" name="quest[publish_end]" value="{{ old('quest.publish_end.') }}" autocomplete="off">
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
                            </div>
                            <hr>
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
                                                <input type="text" class="form-control" name="detail[0][name]" placeholder="Detail Quest" required maxlength="20">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                    Short Description
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Short Description" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="detail[0][short_description]" placeholder="Short Description" required maxlength="20">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Category Product Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select class="form-control select2-multiple" data-placeholder="Select Category Product" name="detail[0][id_product_category]">
                                                        <option></option>
                                                        @foreach ($category as $item)
                                                            <option value="{{$item['id_product_category']}}">{{$item['product_category_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[0][different_category_product]">
                                                            <option></option>    
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Rule for different category product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Product Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[0][id_product]">
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
                                                        <input type="text" class="form-control" name="detail[0][product_total]" placeholder="Total Product">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Transaction Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control digit_mask" name="detail[0][trx_nominal]" placeholder="Transaction Nominal">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control digit_mask" name="detail[0][trx_total]" placeholder="Transaction Total">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Outlet Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[0][id_outlet]">
                                                        <option></option>
                                                        @foreach ($outlet as $item)
                                                            <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[0][different_outlet]">
                                                            <option></option>    
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Rule for different outlet" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Quest Province Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a province. leave blank, if the quest is not based on the province" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select class="form-control select2-multiple" data-placeholder="Select Province" name="detail[0][id_province]">
                                                        <option></option>
                                                        @foreach ($province as $item)
                                                            <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[0][different_province]">
                                                            <option></option>    
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Rule for different province" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
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
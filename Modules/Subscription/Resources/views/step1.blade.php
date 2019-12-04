<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
@extends('layouts.main')

@section('page-style')

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .content-title {
            padding-bottom: 15px;
        }
        .content-detail {
            padding-bottom: 10px;
            padding-left: 40px;
        }
        .p-l-40px {
            padding-left: 40px;
        }
        .p-l-30px {
            padding-left: 30px;
        }
        a[aria-expanded=false] .fa-chevron-down {
            display: none;
        }
        a[aria-expanded=true] .fa-chevron-right {
            display: none;
        }
        .bottom-border {
            border-bottom: 1px solid #c2cad8;
        }
        .btn-grey {
            color: #337ab7;
            background-color: #eee;
            border-color: #ccc;
        }
        .text-decoration-none {
            text-decoration: none!important;
        }
    </style>
@endsection

@section('page-script')

    <!-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/subscription.js') }}" type="text/javascript"></script>

    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    $(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });

    </script>

    <script type="text/javascript">        
        var oldOutlet=[];
        function redrawOutlets(list,selected,convertAll){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if(convertAll&&$('select[name="id_outlet[]"]').val().length==list.length){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }
        $(document).ready(function() {

            var _URL = window.URL || window.webkitURL;

            $('.price').each(function() {
                var input = $(this).val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id" );
                });
            });
            token = '<?php echo csrf_token();?>';

            /* PRICES */
            $('.prices').click(function() {
                var nilai = $(this).val();

                if (nilai != "free") {
                    $('#prices').show();

                    $('.payment').hide();

                    $('#'+nilai).show();
                    $('.'+nilai).prop('required', true);
                    $('.'+nilai+'Opp').removeAttr('required');
                    $('.'+nilai+'Opp').val('');
                }
                else {
                    $('#prices').hide();
                    $('.freeOpp').removeAttr('required');
                    $('.freeOpp').val('');
                }
            });

            /* VOUCHER TYPE */
            $("input[name='voucher_type']").click(function() {
                var nilai = $(this).val();

                $('#voucher-value').show();
                $('#discount-max-form, #discount-max-value').hide();
                $("input[name='percent_max']").prop('checked', false);
                $("input[name='subscription_voucher_percent_max']").prop('required', false);

                if (nilai == "percent") {

                    $('#voucher-percent, #discount-max').show();
                    $('#voucher-cash').hide();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', true);
                    $("input[name='subscription_voucher_nominal']").prop('required', false);
                }
                else {
                    $('#voucher-percent, #discount-max').hide();
                    $('#voucher-cash').show();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', false);
                    $("input[name='subscription_voucher_nominal']").prop('required', true);

                }
            });

            /* DISCOUNT MAX */
            $("input[name='percent_max']").click(function() {
                var nilai = $(this).val();

                $('#voucher-percent').show();

                if (nilai == "true") {

                    $('#discount-max-form, #discount-max-value').show();
                    $("input[name='subscription_voucher_percent_max']").prop('required', true);
                }
                else {

                    $('#discount-max-form, #discount-max-value').hide();
                    $("input[name='subscription_voucher_percent_max']").prop('required', false);
                }
            });

            /* SUBSCRIPTION TOTAL */
            $("input[name='subscription_total_type']").click(function() {
                var nilai = $(this).val();

                if (nilai == "limited") {

                    $('#subscription-total-form, #subscription-total-value').show();
                    $("input[name='subscription_total']").prop('required', true);
                }
                else {
                    $('#subscription-total-form, #subscription-total-value').hide();
                    $("input[name='subscription_total']").prop('required', false);
                }
            });

            /* EXPIRY */
            $('.expiry').click(function() {
                var nilai = $(this).val();

                $('#times').show();

                $('.voucherTime').hide();

                $('#'+nilai).show();
                $('.'+nilai).prop('required', true);
                $('.'+nilai+'Opp').removeAttr('required');
                $('.'+nilai+'Opp').val('');
            });

            $('.subscriptionPromoType').click(function() {
                $('.subscriptionPromoTypeShow').show();
                var nilai = $(this).val();

                if (nilai == "promoid") {
                    $('.subscriptionPromoTypeValuePromo').show();
                    $('.subscriptionPromoTypeValuePromo').prop('required', true);

                    $('.subscriptionPromoTypeValuePrice').val('');
                    $('.subscriptionPromoTypeValuePrice').hide();
                    $('.subscriptionPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.subscriptionPromoTypeValuePrice').show();
                    $('.subscriptionPromoTypeValuePrice').prop('required', true);

                    $('.subscriptionPromoTypeValuePromo').val('');
                    $('.subscriptionPromoTypeValuePromo').hide();
                    $('.subscriptionPromoTypeValuePromo').removeAttr('required', true);
                }
            });

            // upload & delete image on summernote
            $('.summernote').summernote({
                placeholder: true,
                tabsize: 2,
                height: 120,
                toolbar: [
                  ['style', ['style']],
                  ['style', ['bold', 'underline', 'clear']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['insert', ['table']],
                  ['insert', ['link', 'picture', 'video']],
                  ['misc', ['fullscreen', 'codeview', 'help']]
                ],
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
                            url: "{{url('summernote/picture/delete/subscription')}}",
                            success: function(data){
                                // console.log(data);
                            }
                        });
                    }
                }
            });

            function sendFile(file){
                token = "{{ csrf_token() }}";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/subscription')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
                            $('#field_content_long').summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

            $('.fileinput-preview').bind('DOMSubtreeModified', function() {
                var mentah    = $(this).find('img')
                // set image
                var cariImage = mentah.attr('src')
                var ko        = new Image()
                ko.src        = cariImage
                // load image
                ko.onload     = function(){
                    if (this.naturalHeight === 250 && this.naturalWidth === 600) {
                    } else {
                        mentah.attr('src', "https://www.placehold.it/600x250/EFEFEF/AAAAAA&text=no+image")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            });
            window.onload = function() {
                $("body").on('click', ".removeRepeater", function() {
                    var mbok = $(this).parent().parent().parent();
                    mbok.remove();
                });
            }
            $('.collapse').collapse({
              toggle: true
            })
            $('.sortable').sortable({
                handle: ".sortable-handle",
                connectWith: ".sortable",
                axis: 'y',
            });
            $('.sortable-detail-0').sortable({
                handle: '.sortable-detail-handle-0',
                connectWith: '.sortable-detail-0',
                axis: 'y'
            });
            $('.sortable-detail-1').sortable({
                handle: '.sortable-detail-handle-1',
                connectWith: '.sortable-detail-1',
                axis: 'y'
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
        <div class="col-md-12">
            <div class="mt-element-step">
                <div class="row step-line">
                    <div class="col-md-4 mt-step-col first active">
                        <a href="{{ ($subscription['id_subscription']??0) ? url('subscription/step1/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Info</div>
                            <div class="mt-step-content font-grey-cascade">Title, Image, & Periode</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col ">
                        <a href="{{ ($subscription['id_subscription']??0) ? url('subscription/step2/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Rule</div>
                            <div class="mt-step-content font-grey-cascade">Discount, Limit, & Expired</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col last">
                        <a href="{{ ($subscription['id_subscription']??0) ? url('subscription/step3/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Content</div>
                            <div class="mt-step-content font-grey-cascade">Detail Content Subscription</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">New {{ $title }}</span>
            </div>
        </div>
        <div class="portlet-body form">

            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Title
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul subscription" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="subscription_title" value="{{ $subscription['subscription_title']?? old('subscription_title') }}" placeholder="Title" required maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Sub Title
                            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul subscription jika ada" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="subscription_sub_title" value="{{ $subscription['subscription_sub_title']??old('subscription_sub_title') }}" placeholder="Sub Title" maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Image
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar subscription" data-container="body"></i>
                            <br>
                            <span class="required" aria-required="true"> (600*250) </span>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 300px; height: 125px;">
                                      <img src="{{$subscription['url_subscription_image']??'https://www.placehold.it/600x250/EFEFEF/AAAAAA&amp;text=no+image'}}" alt="">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 125px;"></div>
                                    <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/*" name="subscription_image" required id="file">

                                        </span>

                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> subscription Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control date-top-right" name="subscription_start" value="{{ ($subscription['subscription_start']??0) ? date('d-M-Y H:i', strtotime( $subscription['subscription_start'])) : old('subscription_start') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode subscription" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control date-top-right" name="subscription_end" value="{{ ($subscription['subscription_end']??0) ? date('d-M-Y H:i', strtotime( $subscription['subscription_end'])) : old('subscription_end') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode subscription" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="subscription_publish_start" value="{{ ($subscription['subscription_publish_start']??0) ? date('d-M-Y H:i', strtotime( $subscription['subscription_publish_start'])) : old('subscription_publish_start') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai subscription dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="subscription_publish_end" value="{{ ($subscription['subscription_publish_end']??0) ? date('d-M-Y H:i', strtotime( $subscription['subscription_publish_end'])) : old('subscription_publish_end') }}" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai subscription dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-5 col-md-7">
                            <button type="submit" class="btn green">Next Step</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
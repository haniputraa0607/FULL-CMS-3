@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#day').multiDatesPicker();

            $(".file").change(function(e) {
                var type      = $(this).data('jenis');
                var widthImg  = 1080;
                var heightImg = 1920;

                var _URL = window.URL || window.webkitURL;
                var image, file;

                if ((file = this.files[0])) {
                    image = new Image();

                    image.onload = function() {
                        if (this.width == widthImg && this.height == heightImg) {
                        }
                        else {
                            toastr.warning("Please check dimension of your photo.");
                            $(this).val("");

                            if (type == "square" || type == "icon") {
                                $('#field_image_square').val("");
                                $('#image_square').children('img').attr('src', 'https://www.placehold.it/1080x1920/EFEFEF/AAAAAA&amp;text=no+image');
                            }
                        }
                    };
                    image.src = _URL.createObjectURL(file);
                }
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
                <span class="caption-subject font-dark sbold uppercase">Create FAQ</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal form-bordered" action="{{ url('setting/intro/save') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">
                                Active
                            <i class="fa fa-question-circle tooltips" data-original-title="pertanyaan yang sering diajukan" data-container="body"></i>
                        </label>
                        <div class="col-md-9">
                            <input type="checkbox" name="value" @if($value == '1') checked @endif class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">
                                Intro List
                            <i class="fa fa-question-circle tooltips" data-original-title="jawaban" data-container="body"></i>
                        </label>
                        <div class="col-md-9">
                            <div class="col-md-12">
                                <div class="form-group mt-repeater">
                                    <div data-repeater-list="value_text" id="sortable">
                                        @php
                                            if (isset($detail['value_text'])) {
                                                $value_text = $detail['value_text'];
                                            } elseif (isset($result['value_text'])) {
                                                $value_text = $result['value_text'];
                                            } else {
                                                $value_text = null;
                                            }
                                        @endphp
                                        @if ($value_text != null)
                                        @foreach ($value_text as $item)
                                        <div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
                                            <div class="mt-repeater-cell" style="position: relative;">
                                                <div class="sort-icon">
                                                    <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="input-icon right">
                                                        <label class="col-md-3 control-label">
                                                        Image Landscape
                                                        <span class="required" aria-required="true"> * </span>
                                                        <br>
                                                        <span class="required" aria-required="true"> (1080*1920) </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran landscape ditampilkan pada header halaman detail news ukuran persegi ditampilkan pada list news" data-container="body"></i>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                                                            <img class='previewImage' src="{{env('S3_URL_API')}}{{$item['custom_page_image']}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 200px; max-height: 100px;"></div>
                                                            <div class='btnImage' hidden>
                                                                <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Select image </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="text" accept="image/*" value="{{'id_image_header='.$item['id_custom_page_image']}}" class="file form-control demo featureImageForm" name="value_text" data-jenis="landscape">
                                                                </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
                                            <div class="mt-repeater-cell" style="position: relative;">
                                                <div class="sort-icon">
                                                    <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="input-icon right">
                                                        <label class="col-md-3 control-label">
                                                        Image Landscape
                                                        <span class="required" aria-required="true"> * </span>
                                                        <br>
                                                        <span class="required" aria-required="true"> (1080*1920) </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran landscape ditampilkan pada header halaman detail news ukuran persegi ditampilkan pada list news" data-container="body"></i>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 150px; height: 200px;">
                                                                <img class='previewImage' src="https://www.placehold.it/1080x1920/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 200px; max-height: 100px;"></div>
                                                            <div class='btnImage'>
                                                                <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Select image </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" accept="image/*" class="file form-control demo featureImageForm" name="value_text" data-jenis="landscape">
                                                                </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @if (!isset($detail))
                                    <div class="form-action col-md-12">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                                            <i class="fa fa-plus"></i> Add New Input</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">
                                        <i class="fa fa-check"></i> Submit</button>
                                    <button type="button" class="btn default">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
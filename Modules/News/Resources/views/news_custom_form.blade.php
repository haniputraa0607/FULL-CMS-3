<?php
    use App\Lib\MyHelper;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Kopi Kenangan | News Form</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Technopartner Indonesia CRM System" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ url('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ url('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ url('assets/pages/css/invoice-2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" /><link href="{{ url('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ url('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ url('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 

        <style type="text/css">
            @media only screen and (max-width: 768px) {
                /* For mobile phones: */
                [class*="col-"] {
                    width: 100%;
                }

            }
        </style>
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
        <!-- BEGIN CONTAINER -->
        <div class="page-container" style="margin-top: 10px;margin-left: -250px;margin-bottom: 40px;">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content" >
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-body form">
                                    @include('layouts.notifications')
{{-- form --}}
<form role="form" action="{{ url($form_action) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id_user" value="{{ $id_user }}">
    <input type="hidden" name="id_news" value="{{ $news['id_news'] }}">

    <div class="form-body">
        <?php 
            $old = session()->getOldInput();
            $checkbox_id = 1;
            $radio_id = 1;
        ?>

        @foreach ($news['news_form_structures'] as $key => $item)
            <div class="form-group form-md-line-input">
                <input type="hidden" name="news_form[{{$key}}][input_type]" value="{{ $item['form_input_types'] }}">
                <input type="hidden" name="news_form[{{$key}}][input_label]" value="{{ $item['form_input_label'] }}">
                <input type="hidden" name="news_form[{{$key}}][is_unique]" value="{{$item['is_unique']}}">

                <?php 
                    $field_name = "news_form[" .$key. "][input_value]";
                    $old_value = "";
                    if (!empty($old) && isset($old['news_form'][$key]['input_value'])) {
                        $old_value = $old['news_form'][$key]['input_value'];
                    }
                ?>

                @if($item['form_input_types'] == 'Short Text')
                    <input type="text" class="form-control" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=1) }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Long Text')
                    <textarea class="form-control" rows="3" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=1) }}</textarea>
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Number Input')
                    <input type="text" class="form-control price" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }} value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=0) }}">
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Date')
                    <div class="input-icon right">
                        <input type="text" class="form-control datepicker" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=1) }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                        <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                        <i class="fa fa-calendar"></i>
                    </div>
                @elseif($item['form_input_types'] == 'Date & Time')
                    <div class="input-icon right">
                        <input type="text" class="form-control date form_datetime form_datetime bs-datetime" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }} value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=0) }}">
                        <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                        <i class="fa fa-calendar"></i>
                    </div>
                @elseif($item['form_input_types'] == 'Dropdown Choice' && $item['form_input_options'] != "")
                    @php
                        $listOption = explode(',', $item['form_input_options']);
                    @endphp
                    <select class="form-control" placeholder="Select {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                        @foreach ($listOption as $opt)
                            <option value="{{$opt}}" {{ ($old_value==$opt ? "selected" : "") }}>{{ucwords($opt)}}</option>
                        @endforeach
                    </select>
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Radio Button Choice' && $item['form_input_options'] != "")
                    @php $listOption = explode(',', $item['form_input_options']) @endphp
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="md-radio-list">
                        @foreach ($listOption as $i => $opt)
                        <div class="md-radio">
                            @if($item['is_required']==1 && $i==0)
                                <input type="radio" id="radio{{$radio_id}}" name="{{ $field_name }}" value="{{$opt}}" class="md-radiobtn" required {{ ($old_value==$opt ? "checked" : "") }}>
                            @else
                                <input type="radio" id="radio{{$radio_id}}" name="{{ $field_name }}" value="{{$opt}}" class="md-radiobtn" {{ ($old_value==$opt ? "checked" : "") }}>
                            @endif
                            <label for="radio{{$radio_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ucwords($opt)}} </label>
                        </div>
                        <?php $radio_id++; ?>
                        @endforeach
                    </div>
                @elseif($item['form_input_types'] == 'Multiple Choice' && $item['form_input_options'] != "")
                    @php
                        $listOption = explode(',', $item['form_input_options']);
                        if ($old_value != "") {
                            $old_value = implode(' ', $old_value);
                        }
                    @endphp
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="md-checkbox-list {{ ($item['is_required']==1 ? 'checkbox-required' : '') }}">
                        @foreach ($listOption as $i => $opt)
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox{{$checkbox_id}}"  name="{{ $field_name }}[]" value="{{$opt}}" class="md-check" {{ (strpos($old_value, $opt)!==false ? "checked" : "") }}>
                                <label for="checkbox{{$checkbox_id}}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ucwords($opt)}} </label>
                            </div>
                            <?php $checkbox_id++; ?>
                        @endforeach
                    </div>
                @elseif($item['form_input_types'] == 'File Upload')
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput" style="display:block;">
                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput" style="width:100% !important">
                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                            <span class="fileinput-filename"> </span>
                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput" style="float:right"> </a>
                        </div>
                        <span class="input-group-addon btn default btn-file" style="display:none">
                            <span class="fileinput-new"></span>
                            <input type="file" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                        </span>
                        <span class="fileinput-exists"></span>
                    </div>
                @elseif($item['form_input_types'] == 'Image Upload')
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput" style="display:block;">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                        <div>
                            <span class="btn default btn-file">
                                <span class="fileinput-new"> Select image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                            </span>
                            <a href="javascript:;" class="btn red fileinput-exists" style="margin-left:5px" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
        <div class="form-actions noborder">
            <input type="submit" value="Submit" class="btn blue btn-block">
        </div>
    </div>
</form>
{{-- end form --}}
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!--[if lt IE 9] -->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ url('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
        
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ url('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script src="{{ url('js/prices.js')}}"></script>
        <script>
            $('.datepicker').datepicker({
                'format' : 'd-M-yyyy',
                'todayHighlight' : true,
                'autoclose' : true
            });

            $(document).ready(function() {
                // check required checkbox
                $("form").on('submit', function(e) {
                    $('.md-checkbox-list.checkbox-required').each(function(i) {
                        if($(this).find('input[type="checkbox"]:checked').length == 0){
                            e.preventDefault();
                            alert('Please check the checkbox at least 1');
                            return false;
                        };
                    });
                });
            });
        </script>
</body>


</html>
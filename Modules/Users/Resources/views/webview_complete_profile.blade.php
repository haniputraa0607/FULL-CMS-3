<?php
    use App\Lib\MyHelper;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Kopi Kenangan | User Profile</title>
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
        <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" /><link href="{{ url('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ url('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ url('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        <style type="text/css">
            .select2-container .select2-selection--single{
                height: 32px;
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
@if($user != null)
    @if($user['birthday'] == null || $user['gender'] == null || $user['id_city'] == null)
    {{-- form --}}
    <form role="form" action="{{ url('webview/complete-profile', $user['phone']) }}" method="post">
        {{ csrf_field() }}

        <div class="form-body">
            @if($user['birthday'] == null)
            <div class="form-group form-md-line-input">
                <label>
                    Birthday <span class="required" aria-required="true"> * </span>
                </label>
                <input type="text" class="form-control datepicker" placeholder="Enter birthday" name="birthday" value="{{ old('birthday') }}" required>
            </div>
            @endif

            @if($user['gender'] == null)
            <div class="form-group form-md-line-input">
                <label>
                    Gender <span class="required" aria-required="true"> * </span>
                </label>
                <div class="row">
                    <div class="col-xs-2">
                        <div class="md-radio">
                            <input type="radio" id="radio-1" name="gender" value="Male" class="md-radiobtn" {{ old('gender')=='Male' ? 'checked' : '' }} required>
                            <label for="radio-1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Male </label>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="md-radio">
                            <input type="radio" id="radio-2" name="gender" value="Female" class="md-radiobtn" {{ old('gender')=='Female' ? 'checked' : '' }}>
                            <label for="radio-2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Female </label>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($user['id_city'] == null)
            <div class="form-group form-md-line-input">
                <label style="margin-bottom: 7px;">
                    City <span class="required" aria-required="true"> * </span>
                </label>
                <select class="form-control select2" placeholder="Select City" name="id_city" required>
                    @foreach ($cities as $city)
                        <option value="{{$city['id_city']}}" {{ (old('id_city')==$city['id_city'] ? "selected" : "") }}>{{ $city['city_type']. " " .$city['city_name'] }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-actions noborder">
                <input type="submit" value="Submit" class="btn blue btn-block">

                <a href="{{ url('webview/complete-profile/later', $user['phone']) }}" class="btn btn-default btn-block" style="margin-top: 15px;">Remind Me Later</a>
            </div>
        </div>
    </form>
    {{-- end form --}}
    @else
        <div class="alert alert-warning">Data is completed</div>
    @endif
@else
    <div class="alert alert-warning">Data not found</div>
@endif
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
        <script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ url('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $('.datepicker').datepicker({
                'format' : 'd-M-yyyy',
                'autoclose' : true
            });

            $('.select2').select2();

        </script>
</body>

</html>
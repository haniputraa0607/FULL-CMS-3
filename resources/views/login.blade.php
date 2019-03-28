<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Kopi Kenangan | User Login</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Kopi Kenangan Admin Portal" name="description" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		
		<meta property="og:description" content="Technopartner Indonesia CRM System" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Kopi Kenangan" />
		<meta property="og:image" content="{{Cdn::asset('kk-ass/public/images/logo_face_200.png')}}" />
		<meta property="og:image:width" content="200" />
		<meta property="og:image:height" content="200" />
		<link href="{{Cdn::asset('kk-ass/public/images/logo_face_200.png')}}" rel="image_src" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="shortcut icon" sizes="200x200" href="{{Cdn::asset('kk-ass/public/images/logo_face_200.png')}}">
		
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{Cdn::asset('kk-ass/public/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{Cdn::asset('kk-ass/public/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{Cdn::asset('kk-ass/public/assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
		<link rel="shortcut icon" href="{{Cdn::asset('kk-ass/public/images/favicon-behave.ico')}}" />

        <style type="text/css">
            .captcha_div > div{
                margin-left: auto;
                margin-right: auto;
            }
        </style>
        
	</head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="{{Cdn::asset('kk-ass/public/images/logo_kk.png?')}}'" alt="" style="width:250px" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{url('login')}}" method="post">
			{{csrf_field()}}
                <h3 class="form-title">Sign In</h3>
				@include('layouts.notifications')
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" value="{{ old('username') }}" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">PIN</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="PIN" name="password" required maxlength="6" />
				</div>
				<div class="form-group" style="margin-bottom: 0">
                    {!!  GoogleReCaptchaV3::renderField('captcha_div','login', 'captcha_div') !!}
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn blue uppercase btn-block">Login</button>
                    <!--
					<label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
                    </label>
					-->
                    <!-- <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> -->
                </div>
				<!--
                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
                    </p>
                </div>
				-->
            </form>
            <!-- END LOGIN FORM -->
           
        </div>
        <div class="copyright"> Copyright © 2018 Technopartner Indonesia</div>
        <!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<script src="assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
        <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{Cdn::asset('kk-ass/public/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/login.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        {!!  GoogleReCaptchaV3::init() !!}

        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
    </body>

</html>
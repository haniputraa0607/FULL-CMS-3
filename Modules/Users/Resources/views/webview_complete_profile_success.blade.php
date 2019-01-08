<?php
    use App\Lib\MyHelper;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>User Profile</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Technopartner Indonesia CRM System" name="description" />
        <meta content="" name="author" />
        
        <link href="{{ url('assets/webview/css/pace-flash.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ url('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ url('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ url('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ url('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 

        <style type="text/css">
            @font-face {
                font-family: "Seravek";
                src: url('{{ url('/fonts/Seravek.otf') }}');
            }
            body{
                background-color: #fff;
                font-size: 14px;
                font-family: "Seravek", sans-serif;
            }
        </style>
    </head>
    <!-- END HEAD -->

    <body>
        <div class="col-md-offset-4 col-md-4">
            <div class="text-center" style="margin-top: 30px;">
                @foreach($messages as $message)
                    <div style="margin-bottom: 10px;">{{ $message }}</div>
                @endforeach
            </div>
        </div>
    </body>


</html>
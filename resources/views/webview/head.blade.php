<head>
	<title>{{ $title }}</title>
	<meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <script src="{{ url('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <link href="{{ url('assets/webview/css/pace-flash.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ url('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->

    <!-- another css plugin -->
	@yield('page-style-plugin')

    <style type="text/css">
        @font-face {
                font-family: "Seravek";
                src: url('{{ url('/fonts/Seravek.ttf') }}');
        }
        body{
            background-color: #fff;
            color: #858585;
            font-family: "Seravek", sans-serif !important;
        }
    </style>

    <!-- css internal -->
	@yield('css')

</head>
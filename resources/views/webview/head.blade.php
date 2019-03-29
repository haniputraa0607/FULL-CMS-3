<head>
	<title>{{ $title }}</title>
	<meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <script src="{{Cdn::asset('kk-ass/assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <link href="{{Cdn::asset('kk-ass/assets/webview/css/pace-flash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    
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
        .pace .pace-progress{
            top: 0;
        }
        .pace .pace-activity{
            top: 15px;
            border-radius: 10px !important;
        }
    </style>

    <!-- css internal -->
	@yield('css')

</head>
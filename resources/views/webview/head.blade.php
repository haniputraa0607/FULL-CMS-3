<head>
	<title>{{ $title }}</title>
	<meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <link href="{{ env('AWS_ASSET_URL') }}{{ ('assets/webview/css/pace-flash.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- another css plugin -->
	@yield('page-style-plugin')

    <style type="text/css">
        @font-face {
                font-family: "Seravek";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/Seravek.ttf') }}');
        }
        @font-face {
                font-family: "GoogleSans-Bold";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/GoogleSans-Bold.ttf') }}');
        }
        @font-face {
                font-family: "GoogleSans-BoldItalic";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/GoogleSans-BoldItalic.ttf') }}');
        }
        @font-face {
                font-family: "GoogleSans-Italic";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/GoogleSans-Italic.ttf') }}');
        }
        @font-face {
                font-family: "GoogleSans-Medium";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/GoogleSans-Medium.ttf') }}');
        }
        @font-face {
                font-family: "GoogleSans-MediumItalic";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/GoogleSans-MediumItalic.ttf') }}');
        }
        @font-face {
                font-family: "GoogleSans";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/GoogleSans-Regular.ttf') }}');
        }
        @font-face {
                font-family: "ProductSans-Bold";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/ProductSans-Bold.ttf') }}');
        }
        @font-face {
                font-family: "ProductSans-BoldItalic";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/ProductSans-BoldItalic.ttf') }}');
        }
        @font-face {
                font-family: "ProductSans-Italic";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/ProductSans-Italic.ttf') }}');
        }
        @font-face {
                font-family: "ProductSans";
                font-style: normal;
                font-weight: 400;
                src: url('{{ env('AWS_ASSET_URL') }}{{ ('/fonts/ProductSans-Regular.ttf') }}');
        }
        .Seravek{
            font-family: "Seravek";
        }
        .GoogleSans{
            font-family: "GoogleSans";
        }
        .GoogleSans-MediumItalic{
            font-family: "GoogleSans-MediumItalic";
        }
        .GoogleSans-Medium{
            font-family: "GoogleSans-Medium";
        }
        .GoogleSans-Italic{
            font-family: "GoogleSans-Italic";
        }
        .GoogleSans-BoldItalic{
            font-family: "GoogleSans-BoldItalic";
        }
        .GoogleSans-Bold{
            font-family: "GoogleSans-Bold";
        }
        .Seravek{
            font-family: "Seravek";
        }
        .ProductSans{
            font-family: "ProductSans";
        }
        .ProductSans-MediumItalic{
            font-family: "ProductSans-MediumItalic";
        }
        .ProductSans-Medium{
            font-family: "ProductSans-Medium";
        }
        .ProductSans-Italic{
            font-family: "ProductSans-Italic";
        }
        .ProductSans-BoldItalic{
            font-family: "ProductSans-BoldItalic";
        }
        .ProductSans-Bold{
            font-family: "ProductSans-Bold";
        }
        body{
            background-color: #fff;
            color: #858585;
            font-family: {{env('FONT_FAMILY', "Seravek")}}, sans-serif !important;
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
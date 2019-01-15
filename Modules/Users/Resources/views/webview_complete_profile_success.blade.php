<?php
    use App\Lib\MyHelper;
    $title = "User Profile";
?>
@extends('webview.main')

@section('page-style-plugin')
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ url('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ url('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
@stop

@section('content')
    <div class="col-md-offset-4 col-md-4">
        <div class="text-center" style="margin-top: 30px;">
            @foreach($messages as $message)
                <div style="margin-bottom: 10px;">{{ $message }}</div>
            @endforeach
        </div>
    </div>
@stop
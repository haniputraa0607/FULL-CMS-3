@extends('layouts.main')

@section('page-style')
    <link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
@endsection
    
@section('page-script')
    <script type="text/javascript">
        function addTextReplace(param){
            var textvalue = $('#display_text').val();
            var textvaluebaru = textvalue+" "+param;
            $('#display_text').val(textvaluebaru);
        }
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
                <span class="caption-subject font-blue bold uppercase">Version Control Setting</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="" method="post">
                <div class="form-body">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-yellow sbold uppercase">Android Setting</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Android Version
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi android terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="version_android" value="@if(isset($version['version_android'])){{ $version['version_android'] }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Playstore Link
                                            <!-- <span class="required" aria-required="true"> * </span>   -->
                                            <i class="fa fa-question-circle tooltips" data-original-title="Link di playstore untuk download aplikasi Android terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="version_playstore" value="@if(isset($version['version_playstore'])){{ $version['version_playstore'] }}@endif">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Rules For Different Version
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi android yang digunakan berbeda dengan versi aplikasi android terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                            <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" id="radio14" name="version_rule_android" class="md-radiobtn" value="allow" @if (isset($version['version_rule_android']) && $version['version_rule_android'] == 'allow') checked @endif required>
                                                <label for="radio14">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Allowed </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" id="radio16" name="version_rule_android" class="md-radiobtn" value="not allow" @if (isset($version['version_rule_android']) && $version['version_rule_android'] == 'not allow') checked @endif required>
                                                <label for="radio16">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Allowed </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-yellow sbold uppercase">IOS Setting</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            IOS Version
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi android terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="version_ios" value="@if(isset($version['version_ios'])){{ $version['version_ios'] }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Appstore Link
                                            <!-- <span class="required" aria-required="true"> * </span>   -->
                                            <i class="fa fa-question-circle tooltips" data-original-title="Link di appstore untuk download aplikasi IOS terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="version_appstore" value="@if(isset($version['version_appstore'])){{ $version['version_appstore'] }}@endif">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Rules For Different Version
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi IOS yang digunakan berbeda dengan versi aplikasi IOS terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                            <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" id="radio11" name="version_rule_ios" class="md-radiobtn" value="allow" @if (isset($version['version_rule_ios']) && $version['version_rule_ios'] == 'allow') checked @endif required>
                                                <label for="radio11">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Allowed </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" id="radio12" name="version_rule_ios" class="md-radiobtn" value="not allow" @if (isset($version['version_rule_ios']) && $version['version_rule_ios'] == 'not allow') checked @endif required>
                                                <label for="radio12">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Allowed </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-yellow sbold uppercase">Outlet Apps Setting</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Outlet Apps Version
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Versi Outlet Apps terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="version_outletapp" value="@if(isset($version['version_outletapp'])){{ $version['version_outletapp'] }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Outlet Apps Link
                                            <!-- <span class="required" aria-req uired="true"> * </span>   -->
                                            <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download Outlet Apps terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="version_outletstore" value="@if(isset($version['version_outletstore'])){{ $version['version_outletstore'] }}@endif">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Rules For Different Version
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi Outlet Apps yang digunakan berbeda dengan versi Outlet Apps terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                            <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" id="radio17" name="version_rule_outletapp" class="md-radiobtn" value="allow" @if (isset($version['version_rule_outletapp']) && $version['version_rule_outletapp'] == 'allow') checked @endif required>
                                                <label for="radio17">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Allowed </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" id="radio18" name="version_rule_outletapp" class="md-radiobtn" value="not allow" @if (isset($version['version_rule_outletapp']) && $version['version_rule_outletapp'] == 'not allow') checked @endif required>
                                                <label for="radio18">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Allowed </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-yellow sbold uppercase">Display Text & Button</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Text
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="version_text_alert" required id="display_text">@if(isset($version['version_text_alert'])){{ $version['version_text_alert'] }}@endif</textarea>
                                        <br>
                                        You can use this variables to display version app :
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-3" style="margin-bottom:5px;">
                                                <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('%version_app%');">version app</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Button Text
                                            <span class="required" aria-required="true"> * </span>  
                                            <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="version_text_button" value="@if(isset($version['version_text_button'])){{ $version['version_text_button'] }}@endif" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <button type="submit" class="btn green">Save</button>
                                <button type="button" class="btn default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
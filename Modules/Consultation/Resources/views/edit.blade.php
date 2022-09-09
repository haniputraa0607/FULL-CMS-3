@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        $('.timepicker').timepicker({
            autoclose: true,
            showSeconds: false,
        });

        var tmp = [0];
        function valueChanged()
        {
            console.log("tesss");
            if($('.use_reason').is(":checked"))   
                $("#use_reason_field").show();
            else
                $("#use_reason_field").hide();
        }
        
        var i=1;
        function addShift() {
            var html =  '<div class="form-group" id="div_shift_child_'+i+'">'+
                        '<div class="col-md-3" style="text-align: right">'+
                        '<a class="btn btn-danger" onclick="deleteChild('+i+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input name="shift['+i+'][name]" class="form-control shift_name" placeholder="Shift Name" required>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_start_'+i+'" data-placeholder="select time" name="shift['+i+'][start]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_end_'+i+'" data-placeholder="select time" name="shift['+i+'][end]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '</div>';

            $("#div_shift_child").append(html);
            $('.timepicker').timepicker({
                autoclose: true,
                showSeconds: false,
            });
            tmp.push(i);
            i++;
        }

        function deleteChild(number){
            $('#div_shift_child_'+number).remove();
            var index = tmp.indexOf(number);
            if(index >= 0){
                tmp.splice(index, 1);
            }
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
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" id="form_submit" role="form" action="{{url('consultation/be', $result['transaction']['id_transaction'])}}/update" method="POST">
                {{ csrf_field() }}
                <div class="form-body">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Consultation Status <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe jam kerja" data-container="body"></i>
                        </label>
                        <div class="col-md-3">
                            <input type="hidden" name="id_transaction" value="{{$result['transaction']['id_transaction']}}">
                            <select class="form-control select2" name="consultation_status" required>
                                <option></option>
                                <option value="soon">Soon</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="done">Done</option>
                                <option value="completed">Completed</option>
                                <option value="missed">Missed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                        <center>
                            <label for="multiple" style="padding-top:8px;">Perubahan Data Konsultasi akan tercatat sebagai user pengubah adalah <b>{{$result['modifier_user']['name']}}</b><label>
                                <input type="hidden" name="id_user_modifier" value="{{$result['modifier_user']['id']}}">
                            </div>
                        </center>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Use Reason</label>
                        <div class="col-md-8" style="margin-top: 0.7%">
                            <label><input type="checkbox" class="use_reason" name="use_reason" value="1" onClick="valueChanged()"></label>
                        </div>
                    </div>
                    <div id="use_reason_field" style="display: none">
                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">Consultation Status <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe jam kerja" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <textarea type="text" name="reason_status_change" placeholder="Input your address here..." class="form-control" required>{{isset($doctor) ? $doctor['address'] : ''}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    <button class="btn blue">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

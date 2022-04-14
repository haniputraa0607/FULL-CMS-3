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
@endsection

@section('page-script')
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
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".save").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
                        let status    = $(this).data('status');

                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want change to status "+status.toLowerCase()+" ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, save it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $('#action_type').val(status);
                                    $('form#form_submit').submit();
                                });
                        })
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            SweetAlert.init()
        });
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

    @if($detail['merchant_status'] == 'Active' || $detail['merchant_status'] == 'Inactive')
        <a href="{{url('merchant')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @else
        <a href="{{url('merchant/candidate')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @endif

    @include('layouts.notifications')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            @if($detail['merchant_completed_step'] == 0)
            <div class="alert alert-warning">
                Can not reject or approve this candidate because the candidate has not completed the registration stage.
            </div>
            @endif
            @if($detail['merchant_status'] == 'Active' || $detail['merchant_status'] == 'Inactive')
                <form class="form-horizontal" id="form_submit" role="form" action="{{url('merchant/update', $detail['id_merchant'])}}" method="post">
            @else
                <form class="form-horizontal" id="form_submit" role="form" action="{{url('merchant/candidate/update', $detail['id_merchant'])}}" method="post">
            @endif
                <div class="form-body">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Complete Step</label>
                        <div class="col-md-8">
                            @if($detail['merchant_completed_step'] == 1)
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #1BBC9B;padding: 5px 12px;color: #fff;">Completed</span>
                            @else
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E87E04;padding: 5px 12px;color: #fff;">Not Complete</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Status</label>
                        <div class="col-md-8">
                            @if($detail['merchant_status'] == 'Pending')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #9b9e9c;padding: 5px 12px;color: #fff;">Candidate</span>
                            @elseif($detail['merchant_status'] == 'Active')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Active</span>
                            @elseif($detail['merchant_status'] == 'Rejected')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
                            @elseif($detail['merchant_status'] == 'Inactive')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Inactive</span>
                            @else
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #faf21e;padding: 5px 12px;color: #fff;">{{$detail['merchant_status'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_name" class="form-control" required placeholder="Name" value="{{$detail['merchant_name']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">License Number
                            <i class="fa fa-question-circle tooltips" data-original-title="Nomor ijin usaha" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_license_number" class="form-control" maxlength="25" required placeholder="License Number" value="{{$detail['merchant_license_number']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Email
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_email" class="form-control" required placeholder="Name" value="{{$detail['merchant_email']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Phone <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon perusahaan" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_phone" class="form-control" required placeholder="Phone" value="{{$detail['merchant_phone']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Province <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Provinsi" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="id_province" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') disabled @endif>
                                <option></option>
                                @foreach($provinces as $val)
                                    <option value="{{$val['id_province']}}" @if($val['id_province'] == $detail['id_province']) selected @endif>{{$val['province_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">City <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kota" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="id_city" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') disabled @endif>
                                <option></option>
                                @foreach($cities as $val)
                                    <option value="{{$val['id_city']}}" @if($val['id_city'] == $detail['id_city']) selected @endif>{{$val['city_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Address <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap perusahaan" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <textarea name="merchant_address" class="form-control" required placeholder="Address" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>{{$detail['merchant_address']}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Postal Code <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode pos perusahaan" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_postal_code" class="form-control" required placeholder="Postal Code" value="{{$detail['merchant_postal_code']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">PIC Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama penanggung jawab" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_pic_name" class="form-control" required placeholder="PIC Name" value="{{$detail['merchant_pic_name']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">PIC ID Card Number <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nomot ktp penanggung jawab" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_pic_id_card_number" class="form-control" required placeholder="PIC ID Card Number" value="{{$detail['merchant_pic_id_card_number']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">PIC Email <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="alamat email penanggung jawab" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_pic_email" class="form-control" required placeholder="PIC Email" value="{{$detail['merchant_pic_email']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">PIC Phone <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="nomot telepon penanggung jawab" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input name="merchant_pic_phone" class="form-control" required placeholder="PIC Phone" value="{{$detail['merchant_pic_phone']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action_type" id="action_type">
                {{ csrf_field() }}
                @if($detail['merchant_status'] == 'Active' || $detail['merchant_status'] == 'Inactive')
                    <div class="form-actions" style="text-align: center">
                        <button onclick="submit()" class="btn blue">Submit</button>
                    </div>
                @elseif($detail['merchant_status'] == 'Pending')
                    <div class="row" style="text-align: center">
                        {{ csrf_field() }}
                        <a class="btn red save" data-name="{{ $detail['merchant_name'] }}" data-status="rejected"  @if($detail['merchant_completed_step'] == 0) disabled @endif>Reject</a>
                        <a class="btn green-jungle save" data-name="{{ $detail['merchant_name'] }}" data-status="approve" @if($detail['merchant_completed_step'] == 0) disabled @endif>Approve</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

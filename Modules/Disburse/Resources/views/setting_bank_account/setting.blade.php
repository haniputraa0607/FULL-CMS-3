<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $idUserFrenchisee = session('id_id_user_franchise');
 ?>
@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
        function loadOutlets(type){
            if(type == 'all'){
                document.getElementById('div_outlet').style.display = 'none';
            }else{
                var token  = "{{ csrf_token() }}";
                var url = "{{url('disburse/getOutlets')}}";
                var user = $("#id_user_franchise").val();
                $("#outlet").empty();

                $.ajax({
                    type : "POST",
                    url : url,
                    data : {
                        _token : token,
                        id_user_franchise : user
                    },
                    success : function(result) {
                        if(result.status === 'success'){
                            document.getElementById('div_outlet').style.display = 'block';
                            var len = result.result.length;
                            var data = result.result;
                            for (var i=0; i<len;i++){
                                $("#outlet").append('<option value=' + data[i].id_outlet + '>' + data[i].outlet_code +' - '+ data[i].outlet_name + '</option>');
                            }
                        }else{
                            document.getElementById('div_outlet').style.display = 'none';
                        }
                    },
                    error: function (jqXHR, exception) {
                        document.getElementById('div_outlet').style.display = 'none';
                        toastr.warning('Failed get outlet');
                    }
                });
            }
        }
        
        function loadUserFranchise(userType) {
            $("#outlet").empty();
            document.getElementById('div_outlet').style.display = 'none';
            var token  = "{{ csrf_token() }}";
            var url = "{{url('disburse/getUserFranchise')}}";
            $("#id_user_franchise").empty();

            $.ajax({
                type : "POST",
                url : url,
                data : {
                    _token : token,
                    user_type : userType
                },
                success : function(result) {
                    $("#id_user_franchise").append('<option></option>');
                    if(result.status === 'success'){
                        var len = result.result.length;
                        var data = result.result;
                        for (var i=0; i<len;i++){
                            $("#id_user_franchise").append('<option value=' + data[i].id_user_franchise + '>' + data[i].phone + '</option>');
                        }
                        document.getElementById('div_radio_outlet').style.display = 'block';
                    }else{
                        document.getElementById('div_radio_outlet').style.display = 'none';
                    }
                },
                error: function (jqXHR, exception) {
                    document.getElementById('div_radio_outlet').style.display = 'none';
                    toastr.warning('Failed get outlet');
                }
            });
        }
    </script>
@endsection

@extends(($idUserFrenchisee == NULL ? 'layouts.main' : 'disburse::layouts.main'))

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
                <span class="caption-subject font-blue sbold uppercase ">Setting Bank Account</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('disburse/setting/bank-account') }}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bank Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Bank yang dituju" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <select class="form-control select2" data-placeholder="Bank" name="id_bank_name" data-value="{{old('id_bank_name')}}">
                                    <option></option>
                                    @if(!empty($bank))
                                        @foreach($bank as $val)
                                            <option value="{{$val['id_bank_name']}}">{{$val['bank_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Beneficiary Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="nama penerima" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Beneficiary Name" class="form-control" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Beneficiary Alias
                            <i class="fa fa-question-circle tooltips" data-original-title="nama alias penerima" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Beneficiary Alias" class="form-control" name="beneficiary_alias" value="{{ old('beneficiary_alias') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Beneficiary Account
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="nomor rekening penerima" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="111116xxxxxx" class="form-control" name="beneficiary_account" value="{{ old('beneficiary_account') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Beneficiary Email
                            <i class="fa fa-question-circle tooltips" data-original-title="email penerima" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="email@example.com" class="form-control" name="beneficiary_email" value="{{ old('beneficiary_email') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Outlet Type
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe Outlet yang akan diupdate" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <select class="form-control select2" data-placeholder="Outlet Type" name="outlet_type" data-value="{{old('outlet_type')}}" required onchange="loadUserFranchise(this.value)">
                                    <option></option>
                                    <option value="Non Franchise">Outlet Pusat</option>
                                    <option value="Franchise">Outlet Franchise</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">User
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="user yang outeltnya akan di setting" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <select class="form-control select2" id="id_user_franchise" data-placeholder="User" name="id_user_franchise" data-value="{{old('id_user_franchise')}}" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="display: none" id="div_radio_outlet">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-4">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios4" name="outlets" class="md-radiobtn publishType" value="all" checked onclick="loadOutlets('all')">
                                    <label for="optionsRadios4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> All Outlet </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios5" name="outlets" class="md-radiobtn publishType" value="not-all" onclick="loadOutlets('not-all')">
                                    <label for="optionsRadios5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Specific Oultet </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="display: none">
                            <button class="btn green" onclick="showOutlet()">Select Outlet</button>
                        </div>
                    </div>

                    <div class="form-group" style="display: none" id="div_outlet">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label"></label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2-multiple" data-placeholder="Outlets" id="outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}">
                            </select>
                        </div>
                    </div>
                    <div class="form-actions" style="text-align: center">
                        {{ csrf_field() }}
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
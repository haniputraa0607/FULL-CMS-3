<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
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
                $("#outlet").empty();

                $.ajax({
                    type : "POST",
                    url : url,
                    data : {
                        _token : token
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
    </script>
@endsection

@extends('layouts.main')

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
                                            <option value="{{$val['id_bank_name']}}">{{$val['bank_code']}} - {{$val['bank_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Account Number
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nomor rekening" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Account Number" class="form-control" name="account_number" value="{{ old('account_number') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Recipient Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama penerima" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Recipient Name" class="form-control" name="recipient_name" value="{{ old('recipient_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">List Outlet</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover" id="tableReport">
                    <thead>
                    <tr>
                        <th scope="col" width="30%"> Outlet </th>
                        <th scope="col" width="25%"> Bank </th>
                        <th scope="col" width="10%"> Account Number </th>
                        <th scope="col" width="25%"> Recipient Number </th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($outlets))
                            @foreach($outlets as $data)
                                <tr>
                                    <td>{{$data['outlet_code']}} - {{$data['outlet_name']}}</td>
                                    <td>{{$data['bank_code']}} - {{$data['bank_name']}}</td>
                                    <td>{{$data['account_number']}}</td>
                                    <td>{{$data['recipient_name']}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5" style="text-align: center">Data Not Available</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <br>
            @if ($outletPaginator)
                {{ $outletPaginator->fragment('participate')->links() }}
            @endif
        </div>
    </div>

@endsection
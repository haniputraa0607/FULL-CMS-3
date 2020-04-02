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
        function showModal(id_mdr){
            $('#detail_payment_name').val(document.getElementById ( id_mdr+'_payment_name' ).innerText);
            $('#detail_mdr').val(document.getElementById ( id_mdr+'_mdr' ).innerText);
            $('#detail_percent_type').val(document.getElementById ( id_mdr+'_percent_type' ).innerText).trigger("change");
            $('#detail_charged').val(document.getElementById ( id_mdr+'_charged' ).innerText).trigger("change");
            $('#detail_id_mdr').val(id_mdr);
            $('#mdrModal').modal('show');
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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">Setting Global Charged</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('disburse/setting/mdr-global') }}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <div class="col-md-12" style="text-align: center">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios4" name="charged" class="md-radiobtn publishType" value="Outlet" @if(isset($mdr_global['charged']) && $mdr_global['charged'] == 'Outlet') checked @endif>
                                    <label for="optionsRadios4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Oultet </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios5" name="charged" class="md-radiobtn publishType" value="Customer" @if(isset($mdr_global['charged']) && $mdr_global['charged'] == 'Customer') checked @endif>
                                    <label for="optionsRadios5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Customer </label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_mdr" value="{{$mdr_global['id_mdr']}}">
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
                <span class="caption-subject font-blue sbold uppercase ">List Payment Chanel</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover" id="tableReport">
                    <thead>
                    <tr>
                        <th scope="col" width="10%"> Action </th>
                        <th scope="col" width="30%"> Payment Channel Name </th>
                        <th scope="col" width="25%"> MDR </th>
                        <th scope="col" width="10%"> MDR Type </th>
                        <th scope="col" width="25%"> Charged </th>
                        <th scope="col" width="25%"> Updated At </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($mdr))
                        @foreach($mdr as $data)
                            <tr>
                                <td>
                                    <a class="btn btn-xs green" onClick="showModal('{{$data['id_mdr']}}')"><i class="fa fa-edit"></i> Update</a>
                                </td>
                                <td id="{{$data['id_mdr']}}_payment_name">{{$data['payment_name']}}</td>
                                <td id="{{$data['id_mdr']}}_mdr">{{$data['mdr']}}</td>
                                <td id="{{$data['id_mdr']}}_percent_type">{{$data['percent_type']}}</td>
                                <td id="{{$data['id_mdr']}}_charged">{{$data['charged']}}</td>
                                <td>{{ date('d M Y H:i', strtotime($data['updated_at'])) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="8" style="text-align: center">Data Not Available</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>

    <div class="modal fade" id="mdrModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Request & Response Detail</h4>
            </div>
            <form role="form" role="form" action="{{ url('disburse/setting/mdr') }}" method="post">
                <div class="modal-body form">
                    <div class="form-body">
                        <div class="form-group">
                            <label>Payment Name</label>
                            <input type="text" class="form-control" disabled id="detail_payment_name">
                        </div>
                        <div class="form-group">
                            <label>MDR</label>
                            <input type="text" class="form-control" name="mdr" id="detail_mdr">
                        </div>
                        <div class="form-group">
                            <label>MDR Type</label>
                            <select class="form-control select2-multiple" data-placeholder="MDR Type" id="detail_percent_type" name="percent_type">
                                <option></option>
                                <option value="Percent">Percent (%)</option>
                                <option value="Nominal">Nominal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Charged</label>
                            <select class="form-control select2" data-placeholder="Charged" id="detail_charged" name="charged">
                                <option></option>
                                <option value="Outlet">Outlet</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                        <input type="hidden" id="detail_id_mdr" name="id_mdr">
                    </div>
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <button type="submit" class="btn green btn-outline">Submit</button>
                    <button type="button" class="btn red btn-outline" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $idUserFrenchisee = session('id_user_franchise');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $("#detail_bank").select2({
                dropdownParent: $("#editBank")
            });
            $("body").tooltip({selector:'[data-toggle=tooltip]'});
        });

        function showModal(beneficiary_account, bank_code){
            var arrBank = <?php echo json_encode($bank); ?>;
            var arrOutlets = <?php echo json_encode($outlets); ?>;
            $("#detail_bank").empty();
            $("#detail_bank").append('<option></option>');
            $("#outlets").empty();
            $("#outlets").append('<option></option>');

            for(var i=0; i<arrBank.length;i++){
                if(bank_code == arrBank[i].bank_code){
                    $("#detail_bank").append('<option value="'+arrBank[i].id_bank_name+'" selected>'+arrBank[i].bank_name+'</option>');
                }else{
                    $("#detail_bank").append('<option value="'+arrBank[i].id_bank_name+'">'+arrBank[i].bank_name+'</option>');
                }
            }

            var dataOutlets = JSON.parse($('#'+beneficiary_account+'_outlets').val());
            for(var i=0; i<arrOutlets.length;i++){
                var check = dataOutlets.indexOf(arrOutlets[i].id_outlet);
                if(check < 0){
                    $("#outlets").append('<option value="'+arrOutlets[i].id_outlet+'">'+arrOutlets[i].outlet_code+'-'+arrOutlets[i].outlet_name+'</option>');
                }else{
                    $("#outlets").append('<option value="'+arrOutlets[i].id_outlet+'" selected>'+arrOutlets[i].outlet_code+'-'+arrOutlets[i].outlet_name+'</option>');
                }
            }

            $('#detail_beneficiary_name').val(document.getElementById ( beneficiary_account+'_beneficiary_name' ).innerText);
            $('#detail_beneficiary_alias').val(document.getElementById ( beneficiary_account+'_beneficiary_alias' ).innerText);
            $('#detail_beneficiary_account').val(document.getElementById ( beneficiary_account+'_beneficiary_account' ).innerText);
            $('#detail_beneficiary_email').val(document.getElementById ( beneficiary_account+'_beneficiary_email' ).innerText);
            $('#detail_account_bank').val(beneficiary_account);
            var sendEmailTo = document.getElementById ( beneficiary_account+'_send_email_to' ).innerText;
            if(sendEmailTo == 'Email Bank'){
                $("#optionsRadios2").prop("checked", true);
            }else if(sendEmailTo == 'Email Outlet'){
                $("#optionsRadios1").prop("checked", true);
            }

            $('#editBank').modal('show');
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

    <?php
    if(Session::has('filter-disburse-list-outlet')){
        $search_param = Session::get('filter-disburse-list-outlet');
        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }
    }
    ?>
    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('disburse::setting_bank_account.filter_list_outlet')
    </form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">List Bank Account</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover" id="tableReport">
                    <thead>
                    <tr>
                        <th scope="col" width="30%"> Action </th>
                        <th scope="col" width="30%"> Outlet </th>
                        <th scope="col" width="25%"> Beneficiary Bank </th>
                        <th scope="col" width="10%"> Beneficiary Name </th>
                        <th scope="col" width="25%"> Beneficiary Alias </th>
                        <th scope="col" width="25%"> Beneficiary Account </th>
                        <th scope="col" width="25%"> Beneficiary Email </th>
                        <th scope="col" width="25%"> Send Email To </th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($bankAccount))
                            @foreach($bankAccount as $data)
                                <tr>
                                    <td>
                                        <a class="btn btn-xs green" onClick="showModal('{{$data['beneficiary_account']}}','{{$data['bank_code']}}')"><i class="fa fa-edit"></i> Edit</a>
                                    </td>
                                    <td>
                                        <?php $id=[];?>
                                        @if(!empty($data['bank_account_outlet']))
                                            <ul>
                                                @foreach($data['bank_account_outlet'] as $outlet)
                                                    <li>{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</li>
                                                        <?php $id[]=$outlet['id_outlet'];?>
                                                @endforeach
                                            </ul>
                                        @else - @endif
                                        <input type="hidden" id="{{$data['beneficiary_account']}}_outlets" value="{{json_encode($id)}}">
                                    </td>
                                    <td>{{$data['bank_code']}} - {{$data['bank_name']}}</td>
                                    <td id="{{$data['beneficiary_account']}}_beneficiary_name">{{$data['beneficiary_name']}}</td>
                                    <td id="{{$data['beneficiary_account']}}_beneficiary_alias">{{$data['beneficiary_alias']}}</td>
                                    <td id="{{$data['beneficiary_account']}}_beneficiary_account">{{$data['beneficiary_account']}}</td>
                                    <td id="{{$data['beneficiary_account']}}_beneficiary_email">{{$data['beneficiary_email']}}</td>
                                    <td id="{{$data['beneficiary_account']}}_send_email_to">{{$data['send_email_to']}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9" style="text-align: center">Data Not Available</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <br>
            @if ($bankAccountPaginator)
                {{ $bankAccountPaginator->links() }}
            @endif
        </div>
    </div>

    <div class="modal fade" id="editBank" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Edit Bank Account</h4>
                </div>
                <form role="form" role="form" action="{{ url('disburse/setting/bank-account-update') }}" method="post">
                    <div class="modal-body form">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Bank Name
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" title="Nama Bank yang dituju" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <select class="form-control select2" data-placeholder="Bank" name="id_bank_name" id="detail_bank" style="width: 100%">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Beneficiary Name
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" title="nama penerima" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <input type="text" placeholder="Beneficiary Name" class="form-control" name="beneficiary_name" id="detail_beneficiary_name" required>
                            </div>

                            <div class="form-group">
                                <label>Beneficiary Alias
                                    <i class="fa fa-question-circle tooltips" title="nama alias penerima" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <input type="text" placeholder="Beneficiary Alias" class="form-control" id="detail_beneficiary_alias" name="beneficiary_alias">
                            </div>

                            <div class="form-group">
                                <label>Beneficiary Account
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" title="nomor rekening penerima" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <input type="text" placeholder="111116xxxxxx" class="form-control" name="beneficiary_account" id="detail_beneficiary_account" required>
                            </div>

                            <div class="form-group">
                                <label>Beneficiary Email
                                    <i class="fa fa-question-circle tooltips" title="alamat email penerima" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <input type="text" placeholder="email@example.com" class="form-control" name="beneficiary_email" id="detail_beneficiary_email">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Send Email To
                                    <i class="fa fa-question-circle tooltips" data-original-title="ketika diburse sukses, informasi detail akan dikirim ke email bank atau email outlet" data-container="body"></i>
                                </label>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 1%">
                                        <div class="md-radio">
                                            <input type="radio" id="optionsRadios2" name="send_email_to" class="md-radiobtn publishType" value="Email Bank">
                                            <label for="optionsRadios2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Email Bank </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 1%">
                                        <div class="md-radio">
                                            <input type="radio" id="optionsRadios1" name="send_email_to" class="md-radiobtn publishType" value="Email Outlet">
                                            <label for="optionsRadios1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Email Outlet </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Outlets
                                    <i class="fa fa-question-circle tooltips" title="Outlet yang akan di setting" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <select class="form-control select2" data-placeholder="Outlets" name="id_outlet[]" id="outlets" style="width: 100%" multiple>
                                </select>
                            </div>

                            <input type="hidden" id="detail_account_bank" name="beneficiary_account_number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ csrf_field() }}
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
        var arrOutlet = <?php echo json_encode($outlets_available)?>;
        $(document).ready(function () {
            loadTable();
        });

        function loadTable() {
            $("#tableListOutletBody").empty();
            var data_display = 30;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('outlet/delivery-outlet-ajax')}}";
            var tab = $.fn.dataTable.isDataTable( '#tableListOutlet' );
            var code = '{{$code}}';
            if(tab){
                $('#tableListOutlet').DataTable().destroy();
            }

            var data = {
                _token : token
            };

            $('#tableListOutlet').DataTable( {
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": false,
                "bInfo": true,
                "iDisplayLength": data_display,
                "bProcessing": true,
                "serverSide": true,
                "searching": true,
                "ajax": {
                    url : url,
                    dataType: "json",
                    type: "POST",
                    data: data,
                    "dataSrc": function (json) {
                        return json.data;
                    }
                },
                columnDefs: [
                    {
                        targets: 1,
                        render: function ( data, type, row, meta ) {
                            var status = 0;

                            for(var i=0;i<row.delivery_outlet.length;i++){
                                if(row.delivery_outlet[i]['code'] == code){
                                    status = 1;
                                }
                            }

                            if(arrOutlet.indexOf(data) >= 0){
                                status = 1;
                            }

                            if(status == 1){
                                var html = '<input type="checkbox" id="switch_'+data+'" onchange=inputOutlet('+data+') class="make-switch" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1" checked>';
                            }else{
                                var html = '<input type="checkbox" onchange=inputOutlet('+data+') class="make-switch" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1">';
                            }
                            return html;
                        }
                    }
                ],
                "fnDrawCallback": function() {
                    $(".make-switch").bootstrapSwitch();
                },
            });
        }

        function inputOutlet(data) {
            var state = $('#switch_'+data).prop('checked');
            if(state == false){
                var index = arrOutlet.indexOf(data);
                if (index > -1) {
                    arrOutlet.splice(index, 1);
                }
            }else{
                var index = arrOutlet.indexOf(data);
                if (index < 0) {
                    arrOutlet.push(data);
                }
            }
            console.log(arrOutlet);
            $('#input_outlet').val(arrOutlet);
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
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">Limitation Delivery Outlet</span>
        </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" action="{{ url('transaction/setting/delivery-outlet/detail',$code) }}" method="post">
            <table class="table table-striped table-bordered table-hover" width="100%" id="tableListOutlet">
                <thead>
                <tr>
                    <th>Outlet</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody id="tableListOutletBody"></tbody>
            </table>
            <input type="hidden" name="id_outlet[]" id="input_outlet" value="{{json_encode($outlets_available)}}">
            <div class="form-actions text-center">
                {{ csrf_field() }}
                <button type="submit" class="btn blue">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

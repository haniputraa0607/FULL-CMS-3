@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp
@include('filter-v2')
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    @yield('filter_script')
    <script type="text/javascript">
        // range date trx, receipt, order id, outlet, customer
        rules={
            all_data:{
                display:'All Data',
                operator:[],
                opsi:[]
            },
            transaction_receipt_number:{
                display:'Receipt Number',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[],
                placeholder: "ex. J+123456789"
            },
            order_id:{
                display:'Order Id',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[],
                placeholder: "ex. J3LX"
            },
            id_outlet:{
                display:'Outlet',
                operator:[],
                opsi:{!!json_encode($outlets)!!},
                placeholder: "ex. J3LX"
            },
            name:{
                display:'Customer Name',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            phone:{
                display:'Customer Phone',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
        };

        $('#sample_1').dataTable({
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#sample_1').DataTable().page.info();
                    data.page = (info.start / info.length) + 1;
                },
                dataSrc: (res) => {
                    $('#list-filter-result-counter').text(res.recordsTotal);
                    return res.data;
                }
            },
            columns: [
                {data: 'transaction_date'},
                {data: 'transaction_receipt_number'},
                {
                    data: 'outlet_name',
                    render: function(value, type, row) {
                        return row.outlet_code + ' - ' + value;
                    }
                },
                {
                    data: 'name',
                    render: function(value, type, row) {
                        return `${row.name} (${row.phone})`;
                    }
                },
                // {data: 'name'},
                // {data: 'phone'},
                {data: 'trasaction_payment_type'},
                {
                    data: 'transaction_grandtotal',
                    render: value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'manual_refund_nominal',
                    render:  value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'need_manual_refund',
                    render: function(value) {
                        if (value == 1) {
                            return '<div class="badge badge-warning">Unprocessed</div>';
                        } else {
                            return '<div class="badge badge-success">Processed</div>';
                        }
                    }
                },
                {
                    data: 'transaction_receipt_number',
                    render: function(value, row, data) {
                        return `<a class="btn btn-primary btn-sm" href="{{url('transaction/failed-void-payment')}}/${value}">${data.need_manual_refund == 1 ? 'Confirm Process' : 'Detail'}</a>`;
                    }
                },
            ],
            searching: false
        });

        $('#sample_1').on('click', '.delete', function() {
            let token  = "{{ csrf_token() }}";
            let column = $(this).parents('tr');
            let id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('transaction/delete') }}",
                data : "_token="+token+"&id_transation="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Transaction has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete Transaction.");
                    }
                }
            });
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

    @include('layouts.notifications')
    @yield('filter_view')
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Failed Void Payment</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" id="sample_1">
            <thead>
              <tr>
                <th>Transaction Date</th>
                <th>Receipt Number</th>
                <th>Outlet</th>
                <th>Customer</th>
                <th>Payment Type</th>
                <th>Grandtotal</th>
                <th>Manual Refund</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
    </div>
@endsection

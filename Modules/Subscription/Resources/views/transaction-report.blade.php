@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    </script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },
                emptyTable: "No data available in table",
                // info: "Showing _START_ to _END_ of _TOTAL_ entries",
                info: "Showing "+{{ $subsFrom }}+" to "+ {{ $subsUpTo }} +" of "+{{ $subsTotal }}+" entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered1 from _MAX_ total entries)",
                lengthMenu: "_MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found"
            },
            buttons: [],
            order: [2, "asc"],
            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            pageLength: 10,
            "searching": false,
            "paging": false,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('news/delete') }}",
                data : "_token="+token+"&id_news="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("News has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete news.");
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">Filter</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('deals/transaction/filter') }}" method="post" id="form">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Date Range <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="datepicker form-control" name="date_start" value="{{ date('d-M-Y', strtotime($date_start??null)) }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <!-- <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="datepicker form-control" name="date_end" value="{{ date('d-M-Y', strtotime($date_end??null)) }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <!-- <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Outlet Available <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <!-- <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i> -->
                                <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet">
                                <optgroup label="Outlet List">
                                    <!-- <option value="">Select Outlet</option> -->
                                    @if (!empty($outlet))
                                        <option value="all" @if(isset($id_outlet)) @if($id_outlet == "all") selected @endif  @endif>All Outlets</option>
                                        @foreach($outlet as $suw)
                                            <option value="{{ $suw['id_outlet'] }}" @if(isset($id_outlet)) @if($id_outlet == $suw['id_outlet']) selected @endif  @endif>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Deals <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <!-- <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i> -->
                                <select class="form-control select2-multiple" data-placeholder="Select Deals" name="id_deals" required>
                                <optgroup label="Deals List">
                                    <!-- <option value="">Select Outlet</option> -->
                                    @if (!empty($dealsType))
                                        <option value="all" @if(isset($id_outlet)) @if($id_deals == "all") selected @endif  @endif>All Deals</option>
                                        @foreach($dealsType as $suw)
                                            <option value="{{ $suw['id_deals'] }}" @if(isset($id_deals)) @if($id_deals == $suw['id_deals']) selected @endif  @endif>{{ $suw['deals_title'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Result</span>
            </div>
        </div>
        <div class="portlet-body form">
        	<div class="">
	            <table class="table table-striped table-bordered table-hover" id="sample_1">
	                <thead>
	                    <tr>
	                        <th> Subscription Name </th>
	                        <th> Voucher Code </th>
	                        <th> User </th>
	                        <th> Subscription Price </th>
	                        <th> Bought at </th>
	                        <th> Expired at </th>
	                        <th> Used at </th>
	                        <th> Receipt Number </th>
	                        <th> Transaction Grandtotal </th>
	                        <th> Outlet </th>
	                        <th> Subscription Nominal </th>
	                        <th> Charge Central </th>
	                        <th> Charge Outlet </th>
	                    </tr>
	                </thead>
	                <tbody>
	                    @if (!empty($subs))
	                        @foreach($subs as $value)
	                        	@php
	                        		$subs_price = 'Free';
	                        		if(!empty($value['subscription_user']['subscription_price_point'])){
	                        			$subs_price = number_format($value['subscription_user']['subscription_price_point']).' Point';
	                        		}
	                        		if(!empty($value['subscription_user']['subscription_price_cash'])){
	                        			$subs_price = 'IDR '.number_format($value['subscription_user']['subscription_price_point']);
	                        		}
	                        		$subs_nominal 	= $value['transaction']['transaction_payment_subscription']['subscription_nominal'];
	                        		$charge_outlet 	= $value['transaction']['disburse_outlet_transaction']['subscription'];
	                        		$charge_central = $subs_nominal - $charge_outlet;
	                        		$bought_at 		= $value['subscription_user']['bought_at'];
	                        		$expired_at 	= $value['subscription_user']['subscription_expired_at'];
	                        		$used_at 		= $value['used_at'];
	                        	@endphp
	                            <tr>
	                                <td>{{ $value['subscription_user']['subscription']['subscription_title'] }}</td>
	                                <td>{{ $value['voucher_code'] }}</td>
	                                <td>{{ $value['subscription_user']['user']['name'].' - '.$value['subscription_user']['user']['phone'] }}</td>
	                                <td>{{ $subs_price }}</td>
	                                <td>{{ !empty($bought_at) ? date('d-M-y', strtotime($bought_at)) : '-' }}</td>
	                                <td>{{ !empty($expired_at) ? date('d-M-y', strtotime($expired_at)) : '-' }}</td>
	                                <td>{{ !empty($used_at) ? date('d-M-y', strtotime($used_at)) : '-' }}</td>
	                                <td>{{ $value['transaction']['transaction_receipt_number'] }}</td>
	                                <td>{{ !empty($value['transaction']['transaction_grandtotal']) ? 'IDR '.number_format($value['transaction']['transaction_grandtotal']) : '' }}</td>
	                                <td>{{ $value['transaction']['outlet']['outlet_code'].' - '.$value['transaction']['outlet']['outlet_name'] }}</td>
	                                <td>{{ !empty($subs_nominal) ? 'IDR '.number_format($subs_nominal) : '' }}</td>
	                                <td>{{ !empty($charge_central) ? 'IDR '.number_format($charge_central) : '' }}</td>
	                                <td>{{ !empty($charge_outlet) ? 'IDR '.number_format($charge_outlet) : '' }}</td>
	                            </tr>
	                        @endforeach
	                    @endif
	                </tbody>
	            </table>
        	</div>
            @if ($subsPaginator)
                {{ $subsPaginator->links() }}
            @endif
        </div>
    </div>
@endsection
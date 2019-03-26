@extends('layouts.main')

@section('page-style')
    <link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	  <link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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
    
    <form role="form" action="{{ url('transaction/'.$key.'/'.date('YmdHis').'/filter') }}" method="post">
		@include('transaction::transaction.transaction_filter')
	</form>
    
    @include('layouts.notifications')

    @if (!empty($search))
	    <div class="alert alert-block alert-info fade in">
			<button type="button" class="close" data-dismiss="alert"></button>
			<h4 class="alert-heading">Displaying search result :</h4>
				<p>{{ $count }}</p><br>
        <a href="{{ url('transaction/'.$key.'/'.date('YmdHis')) }}" class="btn btn-sm btn-warning">Reset</a>
			<br>
		</div>
    @endif

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">List Transaction {{ $key }}</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
            <thead>
              <tr>
                  <th>Receipt Number</th>
                  <th>Customer Name</th>
                  <th>Phone</th>
                  <th>Total Price</th>
                  <th>Payment Status</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                @if(!empty($trx))
                    @foreach($trx as $res)
                        <tr>
                            <td>{{ $res['transaction_receipt_number'] }}</td>
                            @if (isset($res['name']))
                              <td>{{ $res['name'] }}</td>
                            @else
                              <td>{{ $res['user']['name'] }}</td>
                            @endif

                            @if (isset($res['phone']))
                              <td>{{ $res['phone'] }}</td>
                            @else
                              <td>{{ $res['user']['phone'] }}</td>
                            @endif
                            <td>Rp {{ number_format($res['transaction_grandtotal'], 2) }}</td>
                            <td>{{ $res['transaction_payment_status'] }}</td>
                            <td>
                                <a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail') }}/{{ $res['id_transaction'] }}/{{ $key }}"><i class="icon-pencil"></i> Detail </a>
                                {{-- <a class="btn btn-block red btn-xs" href="{{ url('transaction/delete', $res['transaction_receipt_number']) }}" data-toggle="confirmation" data-placement="top"><i class="icon-close"></i> Delete </a> --}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
            @if ($trxPaginator)
                      {{ $trxPaginator->links() }}
                    @endif
        </div>
    </div>
@endsection

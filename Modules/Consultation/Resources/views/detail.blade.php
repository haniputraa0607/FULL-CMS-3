<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')
@include('infinitescroll')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />

	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }

	    .cont-col2{
	        margin-left: 30px;
	    }
	</style>
@yield('is-style')
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
    @yield('is-script')
    <script type="text/javascript">
        function enableConfirmation(table,response){
            $(`.page${table.data('page')+1} [data-toggle='confirmation']`).confirmation({
                'btnOkClass':'btn btn-sm green',
                'btnCancelClass':'btn btn-sm red',
                'placement':'left'
            });
            table.parents('.is-container').find('.total-record').text(response.total?response.total:0).val(response.total?response.total:0);
        }
        $(document).ready(function(){
            template = {
                useraddress: function(item){
                    return `
                    <tr class="page${item.page}">
                        <td class="text-center">${item.increment}</td>
                        <td>${item.name}</td>
                        <td>${item.favorite?'Yes':'No'}</td>
                        <td>${item.short_address}</td>
                        <td>${item.address}</td>
                        <td>${item.description?item.description:'-'}</td>
                        <td>${new Date(item.updated_at).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",timeStyle:"medium",hour:"2-digit",minute:"2-digit"})}</td>
                    </tr>
                    `;
                },
                useraddressfavorite: function(item){
                    return `
                    <tr class="page${item.page}">
                        <td class="text-center">${item.increment}</td>
                        <td>${item.name}</td>
                        <td>${item.type?item.type:'-'}</td>
                        <td>${item.short_address}</td>
                        <td>${item.address}</td>
                        <td>${item.description?item.description:'-'}</td>
                    </tr>
                    `;
                }
            };
        })
    </script>
	<script>
	function checkAll(var1,var2){
		for(x=1;x<=var2;x++){
			var value = document.getElementById('module_'+var1).checked;
			if(value == true){
				document.getElementById(var1+'_'+x).checked = true;
			} else {
				document.getElementById(var1+'_'+x).checked = false;
			}
		}
	}

	function checkSingle(var1,var2){
		var compare=0;
		var2 = $('.checkbox'+var1).length;
		for(x=1;x<=var2;x++){
			var value = document.getElementById(var1+'_'+x).checked;
			if(value == true){
				compare = compare + 1;
			}
		}
		console.log(var2+ ' ' +compare)
		if(compare == var2){
			document.getElementById('module_'+var1).checked = true;
		} else {
			document.getElementById('module_'+var1).checked = false;
		}
	}

	// $('.sample_1').dataTable({
    //             language: {
    //                 aria: {
    //                     sortAscending: ": activate to sort column ascending",
    //                     sortDescending: ": activate to sort column descending"
    //                 },
    //                 emptyTable: "No data available in table",
    //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //                 infoEmpty: "No entries found",
    //                 infoFiltered: "(filtered1 from _MAX_ total entries)",
    //                 lengthMenu: "_MENU_ entries",
    //                 search: "Search:",
    //                 zeroRecords: "No matching records found"
    //             },
    //             buttons: [],
    //             responsive: {
    //                 details: {
    //                     type: "column",
    //                     target: "tr"
    //                 }
    //             },
    //             order: [0, "asc"],
    //             lengthMenu: [
    //                 [5, 10, 15, 20, -1],
    //                 [5, 10, 15, 20, "All"]
    //             ],
    //             pageLength: 10,
    //             dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    //     });
	// $('#sample_1').dataTable({
    //             language: {
    //                 aria: {
    //                     sortAscending: ": activate to sort column ascending",
    //                     sortDescending: ": activate to sort column descending"
    //                 },
    //                 emptyTable: "No data available in table",
    //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //                 infoEmpty: "No entries found",
    //                 infoFiltered: "(filtered1 from _MAX_ total entries)",
    //                 lengthMenu: "_MENU_ entries",
    //                 search: "Search:",
    //                 zeroRecords: "No matching records found"
    //             },
    //             buttons: [],
    //             responsive: {
    //                 details: {
    //                     type: "column",
    //                     target: "tr"
    //                 }
    //             },
    //             order: [0, "asc"],
    //             lengthMenu: [
    //                 [5, 10, 15, 20, -1],
    //                 [5, 10, 15, 20, "All"]
    //             ],
    //             pageLength: 10,
    //             dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    //     });

    // $('#sample_2').dataTable({
    //             language: {
    //                 aria: {
    //                     sortAscending: ": activate to sort column ascending",
    //                     sortDescending: ": activate to sort column descending"
    //                 },
    //                 emptyTable: "No data available in table",
    //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //                 infoEmpty: "No entries found",
    //                 infoFiltered: "(filtered1 from _MAX_ total entries)",
    //                 lengthMenu: "_MENU_ entries",
    //                 search: "Search:",
    //                 zeroRecords: "No matching records found"
    //             },
    //             buttons: [],
    //             responsive: {
    //                 details: {
    //                     type: "column",
    //                     target: "tr"
    //                 }
    //             },
    //             order: [0, "asc"],
    //             lengthMenu: [
    //                 [5, 10, 15, 20, -1],
    //                 [5, 10, 15, 20, "All"]
    //             ],
    //             pageLength: 10,
    //             dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    //     });

    // $('#sample_3').dataTable({
    //             language: {
    //                 aria: {
    //                     sortAscending: ": activate to sort column ascending",
    //                     sortDescending: ": activate to sort column descending"
    //                 },
    //                 emptyTable: "No data available in table",
    //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //                 infoEmpty: "No entries found",
    //                 infoFiltered: "(filtered1 from _MAX_ total entries)",
    //                 lengthMenu: "_MENU_ entries",
    //                 search: "Search:",
    //                 zeroRecords: "No matching records found"
    //             },
    //             buttons: [],
    //             responsive: {
    //                 details: {
    //                     type: "column",
    //                     target: "tr"
    //                 }
    //             },
    //             order: [0, "asc"],
    //             lengthMenu: [
    //                 [5, 10, 15, 20, -1],
    //                 [5, 10, 15, 20, "All"]
    //             ],
    //             pageLength: 10,
    //             dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    //     });

    // $('#sample_4').dataTable({
    //             language: {
    //                 aria: {
    //                     sortAscending: ": activate to sort column ascending",
    //                     sortDescending: ": activate to sort column descending"
    //                 },
    //                 emptyTable: "No data available in table",
    //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //                 infoEmpty: "No entries found",
    //                 infoFiltered: "(filtered1 from _MAX_ total entries)",
    //                 lengthMenu: "_MENU_ entries",
    //                 search: "Search:",
    //                 zeroRecords: "No matching records found"
    //             },
    //             buttons: [],
    //             responsive: {
    //                 details: {
    //                     type: "column",
    //                     target: "tr"
    //                 }
    //             },
    //             order: [2, "desc"],
    //             lengthMenu: [
    //                 [5, 10, 15, 20, -1],
    //                 [5, 10, 15, 20, "All"]
    //             ],
    //             pageLength: 10,
    //             dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    //     });

    // $('#sample_5').dataTable({
    //             language: {
    //                 aria: {
    //                     sortAscending: ": activate to sort column ascending",
    //                     sortDescending: ": activate to sort column descending"
    //                 },
    //                 emptyTable: "No data available in table",
    //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //                 infoEmpty: "No entries found",
    //                 infoFiltered: "(filtered1 from _MAX_ total entries)",
    //                 lengthMenu: "_MENU_ entries",
    //                 search: "Search:",
    //                 zeroRecords: "No matching records found"
    //             },
    //             buttons: [],
    //             responsive: {
    //                 details: {
    //                     type: "column",
    //                     target: "tr"
    //                 }
    //             },
    //             order: [0, "asc"],
    //             lengthMenu: [
    //                 [5, 10, 15, 20, -1],
    //                 [5, 10, 15, 20, "All"]
    //             ],
    //             pageLength: 10,
    //             dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    //     });

    $('.datatable').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    //info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    //infoEmpty: "No entries found",
                    //infoFiltered: "(filtered1 from _MAX_ total entries)",
                    //lengthMenu: "_MENU_ entries",
                    //search: "Search:",
                    //zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                //order: [2, "desc"],
                //lengthMenu: [
                    //[5, 10, 15, 20, -1],
                    //[5, 10, 15, 20, "All"]
                //],
                //pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

	function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
            <i class="fa fa-circle"></i>
		</li>
        <li>
            <span>{{ $title }}</span>
            <i class="fa fa-circle"></i>
        </li>
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="profile">
				<div class="tab-content">
					<div class="tab-pane active" id="overview">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-12" style="margin-top:30px">
										<h4 class="font-blue sbold uppercase">Transaction Detail</h4>
											<div class="tabbable-line tabbable-full-width">
												<ul class="nav nav-tabs">
													<li class="active">
														<a href="#detail_transaction" data-toggle="tab"> Detail Transaksi </a>
													</li>
													<li>
														<a href="#summary" data-toggle="tab"> Hasil Konsultasi </a>
													</li>
													<li>
														<a href="#product_recomendation" data-toggle="tab"> Rekomendasi Produk </a>
													</li>
													<li>
														<a href="#drug_recomendation" data-toggle="tab"> Resep Obat </a>
													</li>
												</ul>
											</div>
											<div class="tab-content" style="margin-top:20px">
												<div class="tab-pane active" id="detail_transaction">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($result['transaction']))
															<table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
																<thead>
																  <tr>
																	  <th>Key</th>
																	  <th>Value</th>
																  </tr>
																</thead>
																<tbody>
																		<tr>
																			<td>Nomor Transaksi</td>
																			<td>{{$result['transaction']['transaction_receipt_number']}}</td>
																		</tr>
																		<tr>
																			<td>Tanggal Transaksi</td>
																			<td>{{$result['transaction']['transaction_date']}}</td>
																		</tr>
																		<tr>
																			<td>Doctor</td>
																			<td>{{$result['doctor']['doctor_name']}}</td>
																		</tr>
																		<tr>
																			<td>Customer</td>
																			<td>{{$result['customer']['name']}}</td>
																		</tr>
																		<tr>	
																			<td>Jenis Pembayaran</td>
																			<td>{{$result['transaction']['trasaction_payment_type']}}</td>
																		</tr>
																		<tr>
																			<td>Status Pembayaran </td>
																			<td>{{$result['transaction']['transaction_payment_status']}}</td>
																		</tr>
																		<tr>	
																			<td>Tipe Konsultasi</td>
																			<td>{{$result['consultation']['consultation_type']}}</td>
																		</tr>
																		<tr>	
																			<td>Waktu Mulai</td>
																			<td>{{$result['consultation']['schedule_start_time']}}</td>
																		</tr>
																		<tr>	
																			<td>Waktu Selesai</td>
																			<td>{{$result['consultation']['schedule_end_time']}}</td>
																		</tr>
																		<tr>	
																			<td>Status Konsultasi</td>
																			<td>{{$result['consultation']['consultation_status']}}</td>
																		</tr>	
																</tbody>
															</table>
														@else
															Detail Transaction is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>
												<div class="tab-pane" id="summary">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($result['consultation']))
															<table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
																<thead>
																  <tr>
																	  <th>Key</th>
																	  <th>Value</th>
																  </tr>
																</thead>
																<tbody>
																	<tr>
																		<td>Keluhan</td>
																		<td>{{$result['consultation']['disease_complaint']}}</td>
																	</tr>
																	<tr>
																		<td>Analisis</td>
																		<td>{{$result['consultation']['disease_analysis']}}</td>
																	</tr>
																	<tr>
																		<td>Rekomendasi Treatment</td>
																		<td>{{$result['consultation']['treatment_recomendation']}}</td>
																	</tr>
																</tbody>
															</table>
														@else
															Transaction is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>
                                                <div class="tab-pane" id="product_recomendation">
                                                    <table class="table table-striped table-bordered table-hover dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Produk</th>
                                                                <th>Variant</th>
																<th>Outlet</th>
																<th>Harga</th>
																<th>Qty</th>
																<th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															@if(!empty($result['recomendation_product']))
																@foreach($result['recomendation_product'] as $res)
																<tr>
																	<td>{{$res['name']}}</td>
																	<td>{{$res['variant']}}</td>
																	<td>{{$res['outlet']}}</td>
																	<td>{{$res['price']}}</td>
																	<td>{{$res['qty']}}</td>
																	@php $subtotal = $res['price'] * $res['qty']; @endphp
																	<td>{{$subtotal}}</td>
																</tr>
																@endforeach
															@else
																<tr><td colspan="5" style="text-align:center">Recomendation Product is empty</td></tr>
															@endif
                                                        </tbody>
                                                    </table>
                                                </div>
												<div class="tab-pane" id="drug_recomendation">
                                                    <table class="table table-striped table-bordered table-hover dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Obat</th>
                                                                <th>Variant</th>
																<th>Outlet</th>
																<th>Harga</th>
																<th>Qty</th>
																<th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															@if(!empty($result['recomendation_drug']))
																@foreach($result['recomendation_drug'] as $res)
																<tr>
																	<td>{{$res['name']}}</td>
																	<td>{{$res['variant']}}</td>
																	<td>{{$res['outlet']}}</td>
																	<td>{{$res['price']}}</td>
																	<td>{{$res['qty']}}</td>
																	@php $subtotal = $res['price'] * $res['qty']; @endphp
																	<td>{{$subtotal}}</td>
																</tr>
																@endforeach
															@else
																<tr><td colspan="5" style="text-align:center">Resep Obat is empty</td></tr>
															@endif
                                                        </tbody>
                                                    </table>
													
                                                </div>
											</div>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
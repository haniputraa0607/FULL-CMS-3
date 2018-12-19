@extends('layouts.main')

@section('page-style')
    <link href="{{ url('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection
    
@section('page-script')
    {{-- <script src="{{ url('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/global.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
            height: 120
          });

          $(".price").each(function() {
	        var input = $(this).val();
	        var input = input.replace(/[\D\s\._\-]+/g, "");
	        input = input ? parseInt( input, 10 ) : 0;

	        $(this).val( function() {
	            return ( input === 0 ) ? "" : input.toLocaleString( "id" );
	        } );
	      });
		});
		
        $("#multiple").change(function() {
        	var id = $(this).val();
        	var url = '{{ url("product/price") }}/'+id;
        	window.location.href = url;
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
                <span class="caption-subject sbold uppercase font-blue">Product Price</span>
            </div>
            <div class="actions">
                <div class="btn-group" style="width: 300px">
                   <select id="multiple" class="form-control select2-multiple" name="id_outlet" data-placeholder="select outlet">
				        <optgroup label="Outlet List">
				            @if (!empty($outlet))
				                @foreach($outlet as $suw)
				                    <option value="{{ $suw['id_outlet'] }}" @if ($suw['id_outlet'] == $key) selected @endif>{{ $suw['outlet_name'] }}</option>
				                @endforeach
				            @endif
				        </optgroup>
				    </select>
                </div>
            </div>
        </div>
        @if (!empty($outlet))
        	@foreach ($outlet as $row => $data)
        		@if ($data['id_outlet'] == $key)
        			<div class="portlet-body form">
			            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="formWithPrice">
							<div class="portlet-body form">
								<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
									<thead>
										<tr>
											<th> Product </th>
											<th> Price </th>
											<th> Visible </th>
											<th> POS Status </th>
										</tr>
									</thead>
									<tbody>
										@if (!empty($product))
											@foreach ($product as $col => $pro)
												<tr>
													<td> {{ $pro['product_name'] }} </td>
													<td> 
														<input type="hidden" name="id_outlet" value="{{ $key }}">
														<input type="hidden" name="id_product[]" value="{{ $pro['id_product'] }}">
														@if (!empty($data['product_prices']))
															@php
																$marker = 0;
															@endphp
															@foreach ($data['product_prices'] as $dpp)
																@if ($dpp['id_product'] == $pro['id_product'])
																	@php
																		$marker = 1;
																	@endphp
																	<input type="text" name="price[]" value="{{ $dpp['product_price'] }}" data-placeholder="input price" class="form-control mt-repeater-input-inline price">
																@endif
															@endforeach

															@if ($marker == 0)
															<input type="text" name="price[]" data-placeholder="input price" class="form-control mt-repeater-input-inline price">
															@endif
														@else
															<input type="text" name="price[]" data-placeholder="input price" class="form-control mt-repeater-input-inline price"> 
														@endif
													</td>
													<td>
														@php
															$markerBottom = 0;
														@endphp
														@foreach ($data['product_prices'] as $dpp)
														@if ($dpp['id_product'] == $pro['id_product'])
															@php
																$markerBottom = 1;
															@endphp
															<select class="form-control" name="visible[]">
																<option value="Visible" @if($dpp['product_visibility'] == 'Visible') selected @endif>Visible</option>
																<option value="Hidden" @if($dpp['product_visibility'] == 'Hidden') selected @endif>Hidden</option>
															</select>
														@endif
														@endforeach

														@if ($markerBottom == 0)
														<select class="form-control" name="visible[]">
															<option value="Visible">Visible</option>
															<option value="Hidden" selected>Hidden</option>
														</select>
														@endif
													</td>
													<td>
													@if (!empty($data['product_prices']))
														@php
															$marker = 0;
														@endphp
														@foreach ($data['product_prices'] as $dpp)
															@if ($dpp['id_product'] == $pro['id_product'])
																@php
																	$marker = 1;
																@endphp
																<input type="text" value="{{ $dpp['product_status'] }}" class="form-control mt-repeater-input-inline" disabled>
															@endif
														@endforeach

														@if ($marker == 0)
														<input type="text" value="" class="form-control mt-repeater-input-inline " disabled>
														@endif
													@else
														<input type="text" value="" class="form-control mt-repeater-input-inline" disabled> 
													@endif
													</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
								<div class="form-actions">
									{{ csrf_field() }}
									<div class="row">
										@if ($paginator)
										<div class="col-md-10">
											{{ $paginator->links() }}
										</div>
										@endif
										<div class="col-md-2">
											<button type="submit" class="btn blue pull-right" style="margin:10px 0">Save Price</button>
										</div>
									</div>
								</div>
							</div>
						</form>
			        </div>
        		@endif
        	@endforeach
        @endif
    </div>
@endsection

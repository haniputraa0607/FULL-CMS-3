<?php
    use App\Lib\MyHelper;
	$grantedFeature     = session('granted_features');
	$configs    		= session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" /> 
	
	<link href="{{ url('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/pages/scripts//components-color-pickers.min.js') }}" type="text/javascript"></script>
	 <script src="{{ url('js/prices.js')}}"></script>
	<script>
	function typeChange(varnya){
		if(varnya == 'count'){
			var Req = document.getElementsByClassName('levelReq');
			var h;
			for (h = 0; h < Req.length; h++) {
				Req[h].className = 'input-icon input-group levelReq';
			}
			
			var reqIDR = document.getElementsByClassName('levelReqIDR');
			var i;
			for (i = 0; i < reqIDR.length; i++) {
				reqIDR[i].style.display = 'none';
			}
			
			var reqX = document.getElementsByClassName('levelReqX');
			var j;
			for (j = 0; j < reqX.length; j++) {
				reqX[j].style.display = 'table-cell';
			}
			
			var retIDR = document.getElementsByClassName('levelRetIDR');
			var k;
			for (k = 0; k < retIDR.length; k++) {
				retIDR[k].style.display = 'none';
			}
			
			var retX = document.getElementsByClassName('levelRetX');
			var l;
			for (l = 0; l < retX.length; l++) {
				retX[l].style.display = 'table-cell';
			}
			
			var Ret = document.getElementsByClassName('levelRet');
			var m;
			for (m = 0; m < Ret.length; m++) {
				Ret[m].className = 'input-icon input-group levelRet';
			}
		} else {
			var Req = document.getElementsByClassName('levelReq');
			var h;
			for (h = 0; h < Req.length; h++) {
				Req[h].className = 'input-icon input-group right levelReq';
			}
			
			var reqIDR = document.getElementsByClassName('levelReqIDR');
			var i;
			for (i = 0; i < reqIDR.length; i++) {
				reqIDR[i].style.display = 'table-cell';
			}
			
			var reqX = document.getElementsByClassName('levelReqX');
			var j;
			for (j = 0; j < reqX.length; j++) {
				reqX[j].style.display = 'none';
			}
			
			var retIDR = document.getElementsByClassName('levelRetIDR');
			var k;
			for (k = 0; k < retIDR.length; k++) {
				retIDR[k].style.display = 'table-cell';
			}
			
			var retX = document.getElementsByClassName('levelRetX');
			var l;
			for (l = 0; l < retX.length; l++) {
				retX[l].style.display = 'none';
			}
			
			var Ret = document.getElementsByClassName('levelRet');
			var m;
			for (m = 0; m < Ret.length; m++) {
				Ret[m].className = 'input-icon input-group right levelRet';
			}
		}
	}

	function addNewLevel(){
        setTimeout(function(){
            $('.price').each(function() {
				var input = $(this).val();
				var input = input.replace(/[\D\s\._\-]+/g, "");
				input = input ? parseInt( input, 10 ) : 0;

				$(this).val( function() {
					return ( input === 0 ) ? "" : input.toLocaleString( "id" );
				});
			});

			$( ".price" ).on( "keyup", numberFormat);

			$( ".price" ).on( "blur", checkFormat);
		
        }, 100);
	}

	function numberFormat(event){
		var selection = window.getSelection().toString();
		if ( selection !== '' ) {
			return;
		}

		if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
			return;
		}
		var $this = $( this );
		var input = $this.val();
		var input = input.replace(/[\D\s\._\-]+/g, "");
		input = input ? parseInt( input, 10 ) : 0;

		$this.val( function() {
			return ( input === 0 ) ? "" : input.toLocaleString( "id" );
		});
	}

	function checkFormat(event){
		var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
		if(!$.isNumeric(data)){
			$( this ).val("");
		}
	}
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
		</li>
	</ul>
</div>
@include('layouts.notifications')

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-dark sbold uppercase font-blue">Membership</span>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal" role="form" id="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			<div class="form-body">
				<div class="form-group">
					<div class="input-icon right">
						<label class="col-md-3 control-label">
							Level Requirement
							<i class="fa fa-question-circle tooltips" data-original-title="Apa yang menjadi pedoman membership level? apakah berdasarkan nilai total transaksi setiap member, atau berdasarkan jumlah kunjungan / nota setiap member?" data-container="body"></i>
						</label>
					</div>
					<div class="col-md-4">
						<?php 
							if(isset($result) && !empty($result)){
								if(!is_null($result[0]['min_total_value']) && is_null($result[0]['min_total_count'])) $value = "value";
								if(is_null($result[0]['min_total_value']) && !is_null($result[0]['min_total_count'])) $value = "count";
								if(!is_null($result[0]['min_total_value']) && !is_null($result[0]['min_total_count'])) $value = "neither";
								if(is_null($result[0]['min_total_value']) && is_null($result[0]['min_total_count'])) $value = "both";
							}							
						?>
						
						<select class="form-control" name="type" onChange="typeChange(this.value)">
							<option value="value" @if(isset($value) && $value == 'value') selected @endif>By Total Transaction Value </option>
							<option value="count"@if(isset($value) && $value == 'count') selected @endif>By Total Visit </option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon right">
						<label class="col-md-3 control-label">
							Retain Level Evaluation
							<i class="fa fa-question-circle tooltips" data-original-title="Waktu evaluasi ulang level member (dalam hari)" data-container="body"></i>
						</label>
					</div>
					<div class="col-md-3">
						<div class="input-icon input-group">
							<input class="form-control" type="text" name="retain_days" required value="@if(isset($result[0]['retain_days'])) {{$result[0]['retain_days']}} @endif" placeholder="Membership Retain (days)">
							<span class="input-group-btn">
								<button class="btn blue" type="button" >Days</button>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						Membership Level
					</label>
				</div>
				<div class="form-group mt-repeater">
					<div data-repeater-list="membership">
						@if(isset($result))
							@foreach($result as $membership)
							<div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
								<div class="mt-repeater-cell">
									<div class="col-md-12">
									
									<input type="hidden" name="id_membership" value="{{$membership['id_membership']}}">
									
									@if(MyHelper::hasAccess([14], $grantedFeature))
									<div class="col-md-1 col-md-offset-1">
										<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
											<i class="fa fa-close"></i>
										</a>
									</div>
									@endif

									<div class="input-icon right">
										<div class="col-md-3" style="padding-top: 5px;">
											Level Name
											<i class="fa fa-question-circle tooltips" data-original-title="Nama level Membership, Misal: Gold" data-container="body"></i>
										</div>
									</div>
									<div class="col-md-4" >
										<div class="input-icon right">
											<input class="form-control" type="text" name="membership_name" required value="{{$membership['membership_name']}}" placeholder="Membership Level Name">
										</div>
									</div>
									</div>
									
									<!--<div class="col-md-12" style="margin-top:20px">
									<div class="input-icon right">
										<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
											Level Text Color
											<i class="fa fa-question-circle tooltips" data-original-title="Warna teks nama level pada aplikasi" data-container="body"></i>
										</div>
									</div>
									<div class="col-md-4" >
										<div class="input-icon right">
											<input type="text" id="hue-demo" name="membership_name_color" class="form-control demo" data-control="hue" value="{{$membership['membership_name_color']}}">
										</div>
									</div>
									</div>-->
									
									<div class="col-md-12" style="margin-top:20px">
									<div class="input-icon right">
										<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
											Level Image
											<i class="fa fa-question-circle tooltips" data-original-title="Icon membership untuk ditampilkan pada aplikasi ketika membuka halaman detail membership." data-container="body"></i>
										</div>
									</div>
									<div class="col-md-4" >
										<div class="input-icon right">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="max-width: 200px;">
													@if($membership['membership_image'] != "")
														<img src="{{env('API_URL')}}/{{$membership['membership_image']}}" alt="" /> 
													@else
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> 
													@endif
												</div>
													
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
												<div>
													<span class="btn default btn-file">
														<span class="fileinput-new"> Select image </span>
														<span class="fileinput-exists"> Change </span>
														<input type="file" name="membership_image"> </span>
													<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
												</div>
											</div>
										</div>
									</div>
									</div>
									
									<div class="col-md-12" style="margin-top:20px">
										<div class="input-icon right">
											<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
												Level Requirement
												<i class="fa fa-question-circle tooltips" data-original-title="Value minimal untuk mendapatkan level membership ini" data-container="body"></i>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-icon right input-group levelReq">
												<span class="input-group-btn levelReqIDR" @if($value != 'value') style="display:none;" @endif>
													<button class="btn blue" type="button" >IDR</button>
												</span>
												<input class="form-control price" type="text" name="min_value" @if($value == 'value') value="{{$membership['min_total_value']}}" @elseif($value == 'count') value="{{$membership['min_total_count']}}" @endif placeholder="Level Requirement">
												<span class="input-group-btn levelReqX" @if($value != 'count') style="display:none;" @endif>
													<button class="btn yellow" type="button" >X trx</button>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top:20px">
										<div class="input-icon right">
											<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
												Retain Requirement
												<i class="fa fa-question-circle tooltips" data-original-title="Value minimal untuk mempertahankan level membership ini dalam jangka waktu retain yang ditentukan" data-container="body"></i>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-icon right input-group levelRet">
												<span class="input-group-btn levelRetIDR" @if($value != 'value') style="display:none;" @endif>
													<button class="btn blue" type="button" >IDR</button>
												</span>
												<input class="form-control price" type="text" name="min_retain_value" @if($value == 'value') value="{{$membership['retain_min_total_value']}}" @elseif($value == 'count') value="{{$membership['retain_min_total_count']}}" @endif placeholder="Minimum Retain Value">
												<span class="input-group-btn levelRetX" @if($value != 'count') style="display:none;" @endif>
													<button class="btn yellow" type="button" >X trx</button>
												</span>
											</div>
										</div>
									</div>
									{{-- cek configs point --}}
									@if(MyHelper::hasAccess([18], $configs))
										{{-- cek configs membership benefit point --}}
										@if(MyHelper::hasAccess([21], $configs))
										<div class="col-md-12" style="margin-top:20px">
											<div class="input-icon right">
												<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
													Point Received
													<i class="fa fa-question-circle tooltips" data-original-title="Persentase point yang diterima dengan acuan basic point setelah transaksi" data-container="body"></i>
												</div>
											</div>
											<div class="col-md-4">
												<div class="input-icon input-group">
													<input class="form-control price" type="text" name="benefit_point_multiplier" @if(empty($membership['benefit_point_multiplier'])) value="0" @else value="{{$membership['benefit_point_multiplier']}}" @endif placeholder="Point Received">
													<span class="input-group-btn">
														<button class="btn blue" type="button" >%</button>
													</span>
												</div>
											</div>
										</div>
										@endif
									@endif
									{{-- cek configs balance --}}
									@if(MyHelper::hasAccess([19], $configs))
										{{-- cek configs membership benefit cashback --}}
										@if(MyHelper::hasAccess([22], $configs))
											<div class="col-md-12" style="margin-top:20px">
												<div class="input-icon right">
													<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
														Kopi Point Received
														<i class="fa fa-question-circle tooltips" data-original-title="Persentase kopi point yang diterima dengan acuan basic kopi point setelah transaksi" data-container="body"></i>
													</div>
												</div>
												<div class="col-md-4">
													<div class="input-icon input-group">
														<input class="form-control price" type="text" name="benefit_cashback_multiplier" @if(empty($membership['benefit_cashback_multiplier'])) value="0" @else value="{{$membership['benefit_cashback_multiplier']}}" @endif placeholder="Kopi Point Received">
														<span class="input-group-btn">
															<button class="btn blue" type="button" >%</button>
														</span>
													</div>
												</div>
											</div>
											<div class="col-md-12" style="margin-top:20px">
												<div class="input-icon right">
													<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
														Kopi Point Maximum
														<i class="fa fa-question-circle tooltips" data-original-title="Nilai maksimum kopi point yang akan didapat oleh customer" data-container="body"></i>
													</div>
												</div>
												<div class="col-md-4">
													<div class="input-icon right input-group">
														<span class="input-group-btn">
															<button class="btn blue" type="button">IDR</button>
														</span>
														<input class="form-control price" type="text" name="cashback_maximum" @if(empty($membership['cashback_maximum'])) value="0" @else value="{{$membership['cashback_maximum']}}" @endif placeholder="Kopi Point Maximum">
													</div>
												</div>
											</div>
										@endif
									@endif
									{{-- cek configs membership benefit discount --}}
									@if(MyHelper::hasAccess([23], $configs))
										<div class="col-md-12" style="margin-top:20px">
											<div class="input-icon right">
												<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
													Discount Received
													<i class="fa fa-question-circle tooltips" data-original-title="Persentase Diskon final yang diterima untuk setiap transaksi" data-container="body"></i>
												</div>
											</div>
											<div class="col-md-4">
												<div class="input-icon input-group">
													<input class="form-control price" type="text" name="benefit_discount"  @if(empty($membership['benefit_discount'])) value="0" @else value="{{$membership['benefit_discount']}}" @endif placeholder="Discount Received">
													<span class="input-group-btn">
														<button class="btn blue" type="button" >%</button>
													</span>
												</div>
											</div>
										</div>
									@endif
									{{-- cek configs membership benefit promo id --}}
									@if(MyHelper::hasAccess([24], $configs))
										<div class="col-md-12" style="margin-top:20px">
											<div class="input-icon right">
												<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
													POS Promo ID
													<i class="fa fa-question-circle tooltips" data-original-title="Kode Promo dari Raptor" data-container="body"></i>
												</div>
											</div>
											<div class="col-md-4">
												<div class="input-icon right">
													<input class="form-control price" type="text" name="benefit_promo_id"  @if(empty($membership['benefit_promo_id'])) value="0" @else value="{{$membership['benefit_promo_id']}}" @endif placeholder="Promo ID Received">
												</div>
											</div>
										</div>
									@endif
								</div>
							</div>
							@endforeach
						@else

							<div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
								<div class="mt-repeater-cell">
									<div class="col-md-12">
									
									<input type="hidden" name="id_membership" value="">
									
									@if(MyHelper::hasAccess([14], $grantedFeature))
									<div class="col-md-1 col-md-offset-1">
										<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
											<i class="fa fa-close"></i>
										</a>
									</div>
									@endif

									<div class="input-icon right">
										<div class="col-md-3" style="padding-top: 5px;">
											Level Name
											<i class="fa fa-question-circle tooltips" data-original-title="Nama level Membership, Misal: Gold" data-container="body"></i>
										</div>
									</div>
									<div class="col-md-4" >
										<div class="input-icon right">
											<input class="form-control" type="text" name="membership_name" required value="" placeholder="Membership Level Name">
										</div>
									</div>
									</div>
									
									<!--<div class="col-md-12" style="margin-top:20px">
									<div class="input-icon right">
										<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
											Level Text Color
											<i class="fa fa-question-circle tooltips" data-original-title="Warna teks nama level pada aplikasi" data-container="body"></i>
										</div>
									</div>
									<div class="col-md-4" >
										<div class="input-icon right">
											<input type="text" id="hue-demo" name="membership_name_color" class="form-control demo" data-control="hue" value="">
										</div>
									</div>
									</div>-->
									
									<!--<div class="col-md-12" style="margin-top:20px">
									<div class="input-icon right">
										<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
											Level Image
											<i class="fa fa-question-circle tooltips" data-original-title="Image background untuk info membership di aplikasi." data-container="body"></i>
										</div>
									</div>
									<div class="col-md-4" >
										<div class="input-icon right">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 200px;">
													<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> 
												</div>
													
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
												<div>
													<span class="btn default btn-file">
														<span class="fileinput-new"> Select image </span>
														<span class="fileinput-exists"> Change </span>
														<input type="file" name="membership_image"> </span>
													<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
												</div>
											</div>
										</div>
									</div>
									</div>
									-->
									<div class="col-md-12" style="margin-top:20px">
										<div class="input-icon right">
											<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
												Level Requirement
												<i class="fa fa-question-circle tooltips" data-original-title="Value minimal untuk mendapatkan level membership ini" data-container="body"></i>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-icon right input-group levelReq">
												<span class="input-group-btn levelReqIDR">
													<button class="btn blue" type="button" >IDR</button>
												</span>
												<input class="form-control price" type="text" name="min_value" placeholder="Level Requirement">
												<span class="input-group-btn levelReqX" style="display:none;">
													<button class="btn yellow" type="button" >X trx</button>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top:20px">
										<div class="input-icon right">
											<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
												Retain Requirement
												<i class="fa fa-question-circle tooltips" data-original-title="Value minimal untuk mempertahankan level membership ini dalam jangka waktu retain yang ditentukan" data-container="body"></i>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-icon right input-group levelRet">
												<span class="input-group-btn levelRetIDR" >
													<button class="btn blue" type="button" >IDR</button>
												</span>
												<input class="form-control price" type="text" name="min_retain_value" placeholder="Minimum Retain Value">
												<span class="input-group-btn levelRetX" style="display:none;">
													<button class="btn yellow" type="button" >X trx</button>
												</span>
											</div>
										</div>
									</div>
									{{-- cek configs point --}}
									@if(MyHelper::hasAccess([18], $configs))
										{{-- cek configs membership benefit point --}}
										@if(MyHelper::hasAccess([21], $configs))
										<div class="col-md-12" style="margin-top:20px">
											<div class="input-icon right">
												<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
													Point Received
													<i class="fa fa-question-circle tooltips" data-original-title="Persentase point yang diterima dengan acuan basic point setelah transaksi" data-container="body"></i>
												</div>
											</div>
											<div class="col-md-4">
												<div class="input-icon input-group">
													<input class="form-control price" type="text" name="benefit_point_multiplier" value="0" placeholder="Point Received">
													<span class="input-group-btn">
														<button class="btn blue" type="button" >%</button>
													</span>
												</div>
											</div>
										</div>
										@endif
									@endif
									{{-- cek configs balance --}}
									@if(MyHelper::hasAccess([19], $configs))
										{{-- cek configs membership benefit cashback --}}
										@if(MyHelper::hasAccess([22], $configs))
											<div class="col-md-12" style="margin-top:20px">
												<div class="input-icon right">
													<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
														Kopi Point Received
														<i class="fa fa-question-circle tooltips" data-original-title="Persentase kopi point yang diterima dengan acuan basic kopi point setelah transaksi" data-container="body"></i>
													</div>
												</div>
												<div class="col-md-4">
													<div class="input-icon input-group">
														<input class="form-control price" type="text" name="benefit_cashback_multiplier" value="0" placeholder="Kopi Point Received">
														<span class="input-group-btn">
															<button class="btn blue" type="button" >%</button>
														</span>
													</div>
												</div>
											</div>
											<div class="col-md-12" style="margin-top:20px">
												<div class="input-icon right">
													<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
														Kopi Point Maximum
														<i class="fa fa-question-circle tooltips" data-original-title="Nilai maksimum kopi point yang akan didapat oleh customer" data-container="body"></i>
													</div>
												</div>
												<div class="col-md-4">
													<div class="input-icon right input-group">
														<span class="input-group-btn">
															<button class="btn blue" type="button">IDR</button>
														</span>
														<input class="form-control price" type="text" name="cashback_maximum" value="0" placeholder="Kopi Point Maximum">
													</div>
												</div>
											</div>
										@endif
									@endif
									{{-- cek configs membership benefit discount --}}
									@if(MyHelper::hasAccess([23], $configs))
										<div class="col-md-12" style="margin-top:20px">
											<div class="input-icon right">
												<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
													Discount Received
													<i class="fa fa-question-circle tooltips" data-original-title="Persentase Diskon final yang diterima untuk setiap transaksi" data-container="body"></i>
												</div>
											</div>
											<div class="col-md-4">
												<div class="input-icon input-group">
													<input class="form-control price" type="text" name="benefit_discount"  value="0" placeholder="Discount Received">
													<span class="input-group-btn">
														<button class="btn blue" type="button" >%</button>
													</span>
												</div>
											</div>
										</div>
									@endif
									{{-- cek configs membership benefit promo id --}}
									@if(MyHelper::hasAccess([24], $configs))
										<div class="col-md-12" style="margin-top:20px">
											<div class="input-icon right">
												<div class="col-md-offset-2 col-md-3" style="padding-top: 5px;">
													POS Promo ID
													<i class="fa fa-question-circle tooltips" data-original-title="Kode Promo dari POS" data-container="body"></i>
												</div>
											</div>
											<div class="col-md-4">
												<div class="input-icon right">
													<input class="form-control price" type="text" name="benefit_promo_id"  value="0" placeholder="Promo ID Received">
												</div>
											</div>
										</div>
									@endif
								</div>
							</div>
						@endif
					</div>
					<div class="form-action col-md-12">
						<div class="col-md-2"></div>
						<div class="col-md-10">
							@if(MyHelper::hasAccess([12], $grantedFeature))
								<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onclick="addNewLevel()">
								<i class="fa fa-plus"></i> Add New Level</a>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-offset-5 col-md-4">
						@if(MyHelper::hasAccess([12,13,14], $grantedFeature))
							<button type="submit" class="btn green">Submit</button>
						@endif
						<!-- <button type="button" class="btn default">Cancel</button> -->
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
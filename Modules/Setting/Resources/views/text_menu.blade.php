<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('page-plugin')
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
		$(".file").change(function(e) {
			var type      = $(this).data('type');
			var widthImg  = 0;
			var heightImg = 0;
			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();

				image.onload = function() {
					if (this.width !== this.height) {
						toastr.warning("Please check dimension of your photo. Recommended dimensions are 1:1");
						$("#removeImage_"+type).trigger( "click" );
					}
				};
				image.src = _URL.createObjectURL(file);
			}
		});
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
			<a href="javascript:;">Setting</a>
		</li>
	</ul>
</div>
<br>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Text Menu Home</span>
				</div>
			</div>
			@if(count($text_menu_list['text_menu_home']) > 0)
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="{{url('setting/text_menu/update','menu-home')}}" method="POST">
						<div class="form-body">
							@foreach($text_menu_list['text_menu_home'] as $key => $value)
								<div class="form-group col-md-12">
									<div class="col-md-6">
										<p style="margin-bottom:1%;">{{$value['text_menu']}} (Text Menu)<span class="required" aria-required="true"> * </span></p>
										<input class="form-control" type="text" name="{{$key}}_text_menu" value="{{$value['text_menu']}}" maxlength="10" required>

									</div>
									<div class="col-md-6">
										<p style="margin-bottom:1%;">{{$value['text_menu']}} (Text Header)<span class="required" aria-required="true"> * </span></p>
										<input class="form-control" type="text" name="{{$key}}_text_header" value="{{$value['text_header']}}" maxlength="30" required>
									</div>
								</div>
							@endforeach
						</div>
						<div class="form-actions" style="text-align:center">
							{{ csrf_field() }}
							<button type="submit" class="btn blue">Submit</button>
						</div>
					</form>
				</div>
			@endif
		</div>
	</div>
</div>

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Text Menu Account</span>
				</div>
			</div>
			@if(count($text_menu_list['text_menu_account']) > 0)
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="{{url('setting/text_menu/update','menu-account')}}" method="post" enctype="multipart/form-data">
						<div class="form-body">
							<?php
								//========= start setting column and row =========//
								$countMenuAccount = count($text_menu_list['text_menu_account']);
								$totalRow = $countMenuAccount / 2;

								if(is_float($totalRow) === true){
									$totalRow = (int)$totalRow + 1;
								}

								$dataColumn1 = array_slice($text_menu_list['text_menu_account'], 0, $totalRow);
								$dataColumn2 = array_slice($text_menu_list['text_menu_account'], $totalRow, $totalRow);
								$allData = [$dataColumn1, $dataColumn2];
								//========= end setting =========//
							?>

							<div class="form-group col-md-12">
							@foreach($allData as $data)
								<div class="col-md-6">
								@foreach($data as $key => $value)

										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption">
													<span class="caption-subject font-dark sbold uppercase">{{$key}}</span>
												</div>
											</div>
											<div class="portlet-body form">
												<div class="row" style="margin-left: 1%;margin-right: 1%;">
													<p style="margin-top:2%;margin-bottom:1%;"> Text Menu <span class="required" aria-required="true"> * </span></p>
													<input class="form-control" type="text" name="{{$key}}_text_menu" value="{{$value['text_menu']}}" maxlength="10" required>

													<p style="margin-top:2%;margin-bottom:1%;"> Text Header<span class="required" aria-required="true"> * </span></p>
													<input class="form-control" type="text" name="{{$key}}_text_header" value="{{$value['text_header']}}" maxlength="30" required>

													<div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 2%;">
														<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
															@if(isset($value['icon']) && $value['icon'] != "")
																<img src="{{$value['icon']}}" id="preview_icon_{{$key}}" />
															@endif
														</div>

														<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
														<div>
															<span class="btn default btn-file">
															<span class="fileinput-new"> Select image </span>
															<span class="fileinput-exists"> Change </span>
															<input type="file" accept="image/png" name="images[icon_{{$key}}]" class="file" data-type="{{$key}}"> </span>
																<a href="javascript:;" id="removeImage_{{$key}}" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
														</div>
													</div>
												</div>
											</div>
										</div>
								@endforeach
								</div>
							@endforeach
							</div>
						</div>
						<div class="form-actions" style="text-align:center">
							{{ csrf_field() }}
							<button type="submit" class="btn blue">Submit</button>
						</div>
					</form>
				</div>
			@endif
		</div>
	</div>
</div>
@endsection
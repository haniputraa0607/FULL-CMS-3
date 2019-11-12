<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
		$(".file").change(function(e) {
			var type      = $(this).data('type');
			var widthImg  = 0;
			var heightImg = 0;
			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();
				var size = file.size/1024;

				image.onload = function() {
					if (this.width !== this.height) {
						toastr.warning("Please check dimension of your photo. Recommended dimensions are 1:1");
						$("#removeImage_"+type).trigger( "click" );
					}
					if (this.width !== 800 ||  this.height !== 800) {
						toastr.warning("Please check dimension of your photo. Recommended dimensions are 800 x 800");
						$("#removeImage_"+type).trigger( "click" );
					}
					if (size > 10) {
						toastr.warning("The maximum size is 10 KB");
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
				Setting Text Menu
			</li>
		</ul>
	</div>
	<br>
	@include('layouts.notifications')
	<div class="portlet-body">
		<div class="tabbable-line tabbable-full-width">
			<ul class="nav nav-tabs">
				<li class=" @if(!isset($tipe)) active @endif">
					<a href="#text_menu_home" data-toggle="tab"> Text Menu Home </a>
				</li>
				<li class=" @if(isset($tipe) && $tipe == 'menu_account') active @endif">
					<a href="#text_menu_account" data-toggle="tab"> Text Menu Account </a>
				</li>
			</ul>
		</div>
		<div class="tab-content" style="margin-top:20px">
			<div class="tab-pane @if(!isset($tipe)) active @endif" id="text_menu_home">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gear"></i>Setting Text Menu Home</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"> </a>
						</div>
					</div>
					<div class="portlet-body">
						<p>Menu ini digunakan untuk mengatur tulisan menu dan tulisan header pada menu aplikasi dibagian bawah.</p>
						<ul>
							<li>Gambar (a) adalah urutan menu.</li>
							<li>Gambar (b) adalah contoh tampilan untuk "Text Menu".</li>
							<li>Gambar (c) adalah contoh tampilan untuk "Text Header".</li>
						</ul>

						<div class="row" style="margin-top: 2%;">
							<div class="col-md-4">
								<img src="{{ env('S3_URL_VIEW') }}images/text_menu/guide_menu_home_1.png" height="260px"/>
								<p style="text-align: center">(a)</p>
							</div>
							<div class="col-md-4">
								<img src="{{ env('S3_URL_VIEW') }}images/text_menu/guide_menu_home_2.png" height="260px"/>
								<p style="text-align: center">(b)</p>
							</div>
							<div class="col-md-4">
								<img src="{{ env('S3_URL_VIEW') }}images/text_menu/guide_menu_home_3.png" height="260px"/>
								<p style="text-align: center">(c)</p>
							</div>
						</div>
					</div>
				</div>
				@if(count($text_menu_list['text_menu_home']) > 0)
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/text_menu/update','menu-home')}}" method="POST">
							<div class="form-body">
								<?php
								//========= start setting column and row =========//
								$countMenuHome = count($text_menu_list['text_menu_home']);
								$totalRow = $countMenuHome / 2;
								$countNumberHome = 1;

								if(is_float($totalRow) === true){
									$totalRow = (int)$totalRow + 1;
								}

								$dataMenuHomeColumn1 = array_slice($text_menu_list['text_menu_home'], 0, $totalRow);
								$dataMenuHomeColumn2 = array_slice($text_menu_list['text_menu_home'], $totalRow, $totalRow);
								$allDataMenuHome = [$dataMenuHomeColumn1, $dataMenuHomeColumn2];
								//========= end setting =========//
								?>

								<div class="form-group col-md-12">
									@foreach($allDataMenuHome as $data)
										<div class="col-md-6">
											@foreach($data as $key => $value)

												<div class="portlet light bordered">
													<div class="portlet-title">
														<div class="caption">
															<span class="caption-subject font-dark sbold uppercase">Menu {{$countNumberHome}}</span>
														</div>
													</div>
													<div class="portlet-body form">
														<div class="row" style="margin-left: 1%;margin-right: 1%;">
															<div class="row" style="margin-bottom: 3%;">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Menu <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_menu" value="{{$value['text_menu']}}" maxlength="10" required>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Header <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_header" value="{{$value['text_header']}}" maxlength="20" required>
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php
													$countNumberHome++
												?>
											@endforeach
										</div>
									@endforeach
								</div>
								<div class="form-actions" style="text-align:center">
									{{ csrf_field() }}
									<button type="submit" class="btn blue">Submit</button>
								</div>
							</div>
						</form>
					</div>
				@endif
			</div>

			<div class="tab-pane @if(isset($tipe) && $tipe == 'menu_account') active @endif" id="text_menu_account">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gear"></i>Setting Text Menu Home</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"> </a>
						</div>
					</div>
					<div class="portlet-body">
						<p>Menu ini digunakan untuk mengatur tulisan menu, tulisan header, dan icon yang ada didalam daftar menu account.</p>
						<ul>
							<li>Gambar (a) adalah contoh tampilan untuk "Text Menu".</li>
							<li>Gambar (b) adalah contoh tampilan untuk "Text Header".</li>
							<li>Gambar (c) adalah contoh tampilan untuk "Icon".</li>
                        	<li>Gambar (d) adalah urutan menu.</li>
						</ul>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-4">
                                <img src="{{ env('S3_URL_VIEW') }}images/text_menu/guide_menu_account_2.png" height="180px"/>
                                <p style="text-align: center">(a)</p>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ env('S3_URL_VIEW') }}images/text_menu/guide_menu_account_3.png" height="180px"/>
                                <p style="text-align: center">(b)</p>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ env('S3_URL_VIEW') }}images/text_menu/guide_menu_account_4.png" height="180px"/>
                                <p style="text-align: center">(c)</p>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-3">
                                <img src="{{ env('S3_URL_VIEW') }}images/text_menu/guide_menu_account_1.png" height="280px"/>
                                <p style="text-align: center">(d)</p>
                            </div>
                        </div>
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
															<span class="caption-subject font-dark sbold uppercase">{{$value['text_menu']}}</span>
														</div>
													</div>
													<div class="portlet-body form">
														<div class="row" style="margin-left: 1%;margin-right: 1%;">
															<div class="row" style="margin-bottom: 3%;">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Menu <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_menu" value="{{$value['text_menu']}}" maxlength="10" required>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Header <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_header" value="{{$value['text_header']}}" maxlength="20" required>
																</div>
															</div>
															<div class="row" style="margin-top: 4%;">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Icon <span class="required" aria-required="true"> * </span></p>
																	<div style="color: #e02222;font-size: 12px;margin-top: 4%;">
																		- Only PNG <br>
																		- 800 x 800 <br>
																		- max size 10 KB <br>
																	</div>
																</div>
																<div class="col-md-8">
																	<div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 2%;">
																		<div class="fileinput-new thumbnail" style="width: 40px; height: 40px;">
																			@if(isset($value['icon']) && $value['icon'] != "")
																				<img src="{{$value['icon']}}" id="preview_icon_{{$key}}" />
																			@endif
																		</div>

																		<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>
																		<div>
																		<span class="btn default btn-file">
																		<span class="fileinput-new" style="font-size: 12px"> Select image </span>
																		<span class="fileinput-exists"> Change </span>
																		<input type="file" accept="image/png" name="images[icon_{{$key}}]" class="file" data-type="{{$key}}"> </span>
																			<a href="javascript:;" id="removeImage_{{$key}}" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											@endforeach
										</div>
									@endforeach
								</div>
								<div class="form-actions" style="text-align:center">
									{{ csrf_field() }}
									<button type="submit" class="btn blue">Submit</button>
								</div>
							</div>
						</form>
					</div>
				@endif
			</div>
		</div>

	</div>
@endsection
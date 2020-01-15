@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<style>
	.item{
		padding: 10px;
		border-bottom: 1px solid #eeeeee;
		background: #fff;
	}
	.item:hover{
		background: #f3f3f3
	}
	.handle-sort:hover{
		cursor: move;
	}
</style>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<script>
	template = '<div class="item">\
	<div class="row">\
	<div class="col-md-3">\
	<div class="btn-group">\
	<button class="btn red deleteBtn" data-toggle="confirmation" data-popout="true"><i class="fa fa-trash-o"></i></button>\
	<button class="btn green handle-sort"><i class="fa fa-sort"></i></button>\
	</div>\
	</div>\
	<label class="col-md-2 control-label text-right">Text\
	<span class="required" aria-required="true"> *\
	</span>\
	<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di popup" data-container="body"></i>\
	</label>\
	<div class="col-md-7">\
	<div class="form-group">\
	<input type="text" class="form-control" value="" name="new_item[::n::][text]" required maxlength="10"/>\
	</div>\
	</div>\
	</div>\
	<div class="row">\
	<label class="col-md-5 control-label text-right">\
	Image\
	<span class="required" aria-required="true"> * </span>\
	<br>\
	<span class="required" aria-required="true"> (100 * 100) </span>\
	<i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks" data-container="body"></i>\
	</label>\
	<div class="col-md-7">\
	<div class="fileinput fileinput-new" data-provides="fileinput">\
	<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">\
	<img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>\
	</div>\
	<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>\
	<div>\
	<span class="btn default btn-file">\
	<span class="fileinput-new"> Select image </span>\
	<span class="fileinput-exists"> Change </span>\
	<input type="file" accept="image/png" name="new_item[::n::][image]" class="file" required> \
	</span>\
	<a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>\
	</div>\
	</div>\
	</div>\
	</div>\
	<div class="row">\
	<label class="col-md-5 control-label text-right">\
	Image Selected\
	<span class="required" aria-required="true"> * </span>\
	<br>\
	<span class="required" aria-required="true"> (100 * 100) </span>\
	<i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks saat terpilih" data-container="body"></i>\
	</label>\
	<div class="col-md-7">\
	<div class="fileinput fileinput-new" data-provides="fileinput">\
	<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">\
	<img id="preview_image_selected" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>\
	</div>\
	<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>\
	<div>\
	<span class="btn default btn-file">\
	<span class="fileinput-new"> Select image </span>\
	<span class="fileinput-exists"> Change </span>\
	<input type="file" accept="image/png" name="new_item[::n::][image_selected]" class="file" required> \
	</span>\
	<a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>\
	</div>\
	</div>\
	</div>\
	</div>\
	</div>';
	$(document).ready(function(){
		$('.select2').select2();
		$('#outlet_selector').on('change',function(){
			var value = $(this).val();
			if(value == '0'){
				value = '';
			}
			window.location.href = "{{url('user-feedback')}}/"+value;
		});
		$('#newItemBtn').on('click',function(){
			var count = $('#rating-container .item').length;
			if(count>=3){
				toastr.warning("Maximum rating item (3) already reached");
				return false;
			}
			$('#rating-container').append(template.replace(/::n::/g,count));
		});
		$('#rating-container').on('click','.deleteBtn',function(){
			$(this).parents('.item').remove();
			var count = $('#rating-container .item').length;
			if(count===0){
				$('#newItemBtn').click();
			}
		})
		$(".file").change(function(e) {
			var widthImg  = 0;
			var heightImg = 0;
			var _URL = window.URL || window.webkitURL;
			var image, file;
			var domLock = $(this);
			if ((file = this.files[0])) {
				image = new Image();

				image.onload = function() {
					if ($(".file").val().split('.').pop().toLowerCase() != 'png') {
						toastr.warning("Please check dimension of your photo.");
						domLock.parents('.fileinput').find('.removeImage').click();
					}
					if (this.width != 100 || this.height != 100) {
						toastr.warning("Please check dimension of your photo.");
						domLock.parents('.fileinput').find('.removeImage').click();
					}
				};
				image.src = _URL.createObjectURL(file);
			}
		});
		$('#rating-container').sortable({
			'handle':'.handle-sort',
			'cancel':''
		}).disableSelection();
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
			<span class="caption-subject font-dark sbold uppercase font-blue">List Rating Item</span>
		</div>
	</div>
	<div class="portlet-body form" style="position: relative;">
		<form action="#" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div id="rating-container" class="col-md-8">
					@if($items??[])
					@foreach($items as $item)
					<div class="item">
						<div class="row">
							<div class="col-md-3">
								<div class="btn-group">
									<button class="btn red deleteBtn" data-toggle="confirmation" data-popout="true"><i class="fa fa-trash-o"></i></button>
									<button class="btn green handle-sort"><i class="fa fa-sort"></i></button>
								</div>
							</div>
							<label class="col-md-2 control-label text-right">Text
								<span class="required" aria-required="true"> *
								</span>
								<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di popup" data-container="body"></i>
							</label>
							<div class="col-md-7">
								<div class="form-group">
									<input type="text" class="form-control" value="{{$item['text']}}" name="item[{{$item['id_rating_item']}}][text]" required maxlength="10" />
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-md-5 control-label text-right">
								Image
								<span class="required" aria-required="true"> * </span>
								<br>
								<span class="required" aria-required="true"> (100 * 100) </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks" data-container="body"></i>
							</label>
							<div class="col-md-7">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
										@if(isset($item['image']) && $item['image'] != "")
										<img src="{{$item['image']}}" id="preview_image" />
										@else
										<img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
										@endif
									</div>

									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
									<div>
										<span class="btn default btn-file">
											<span class="fileinput-new"> Select image </span>
											<span class="fileinput-exists"> Change </span>
											<input type="file" accept="image/png" class="file" name="item[{{$item['id_rating_item']}}][image]" > 
										</span>
										<a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
									</div>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top: 10px">
							<label class="col-md-5 control-label text-right">
								Image Selected
								<span class="required" aria-required="true"> * </span>
								<br>
								<span class="required" aria-required="true"> (100 * 100) </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks saat terpilih" data-container="body"></i>
							</label>
							<div class="col-md-7">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
										@if(isset($item['image_selected']) && $item['image_selected'] != "")
										<img src="{{$item['image_selected']}}" id="preview_image_selected" />
										@else
										<img id="preview_image_selected" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
										@endif
									</div>

									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
									<div>
										<span class="btn default btn-file">
											<span class="fileinput-new"> Select image </span>
											<span class="fileinput-exists"> Change </span>
											<input type="file" accept="image/png" class="file" name="item[{{$item['id_rating_item']}}][image_selected]"> 
										</span>
										<a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					@else
					<div class="text-center text-muted">No Feedback Found</div>
					@endif
				</div>
				<div class="preview col-md-4 pull-right" style="right: 0;top: 50px; position: sticky">
					<img src="{{env('S3_URL_VIEW')}}img/setting/rating_preview.png" class="img-responsive">
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 text-center">
					<div class="text-center" style="margin-top: 10px">
						<button class="btn green" id="newItemBtn" type="button"><i class="fa fa-plus"></i> New Rating Item</button>
						<button class="btn yellow" id="saveItemBtn"><i class="fa fa-check"></i> Save</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
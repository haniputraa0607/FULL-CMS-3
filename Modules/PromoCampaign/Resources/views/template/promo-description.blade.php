<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@section('promo-description')
	@php
		$datenow = date("Y-m-d H:i:s");
		switch ($promo_source) {
			case 'promo_campaign':
				$data_promo = $result;
				break;
			
			case 'deals':
				$data_promo = $deals;
				break;

			case 'subscription':
				$data_promo = $subscription;
				break;

			default:
				$data_promo = [];
				break;
		}
	@endphp

	<div class="portlet-body form">
	    <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption">
	                <span class="caption-subject font-blue sbold uppercase">Promo Description</span>
	            </div>
	        </div>
		    <div class="portlet-body form">
				<div class="">
					<div class="profile-info">
						<div class="row static-info">
				            <div class="col-md-12 name"> Default Description :</div>
				            <div class="col-md-6">
				            	<blockquote style="font-size: 14px;margin-top: 12px"> {{ ($data_promo['description'] ?? '') }} </blockquote>
				            </div>
				        </div>
					    <div class="row static-info">
				            <div class="col-md-6 name"> Custom Description :</div>
				            <div class="col-md-6"></div>
				        </div>
						<form id="form-promo-description" class="form-horizontal" role="form" action="{{ url('promo-campaign/promo-description') }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
					        <div class="row static-info">
					            <div class="col-md-6 value">
					            	<div class="input-icon right">
										<textarea name="promo_description" id="field_content_long" class="form-control" placeholder="Deals Description" style="width: 490px;
			  height: 150px;">{{ old('promo_description')??$data_promo['promo_description']??'' }}</textarea>
									</div>
									<input type="hidden" value="{{ $data_promo['id_deals'] ?? null }}" name="id_deals" />
				                    <input type="hidden" value="{{ $data_promo['id_promo_campaign'] ?? null }}" name="id_promo_campaign" />
				                    <input type="hidden" value="{{ $data_promo['id_subscription'] ?? null }}" name="id_subscription" />
								</div>
							</div>
			                <button type="submit" class="btn green">update</button>
						</form>
					</div>
				</div>
			</div>
        </div>
	</div>

@endsection

@section('promo-description-script')
	<script type="text/javascript">
		$('.summernote').summernote({
			placeholder: true,
            tabsize: 2,
            height: 120,
            toolbar: [],
            callbacks: {
                onInit: function(e) {
                  this.placeholder
                    ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                    : e.editingArea.remove(".note-placeholder");
                }
            }
		});
	</script>
@endsection
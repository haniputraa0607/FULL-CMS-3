@include('promocampaign::template.promo-shipment-method', ['promo_source' => $promo_source])

@php
	switch ($promo_source) {
		case 'promo_campaign':
			$data = $result;
			break;
		
		default:
			# code...
			break;
	}
@endphp

@section('global-requirement')
<div class="col-md-12">
	<div class="portlet light bordered" id="promotype-form">
		<div class="portlet-title">
			<div class="caption font-blue ">
				<i class="icon-settings font-blue "></i>
				<span class="caption-subject bold uppercase">GLobal Rule</span>
			</div>
		</div>
		<div class="portlet-body" id="tabContainer">
			<div class="form-group" style="height: 55px;display: inline;">
				@yield('promo-shipment-method')
			</div>
		</div>
	</div>
</div>
@endsection

@section('global-requirement-script')
	@yield('promo-shipment-method-script')
@endsection
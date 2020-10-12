@include('promocampaign::template.promo-shipment-method', ['promo_source' => $promo_source])

@section('global-requirement')
	<div class="portlet light bordered" id="promotype-form">
		<div class="portlet-title">
			<div class="caption font-blue ">
				<span class="caption-subject bold uppercase">GLobal Rule</span>
			</div>
		</div>
		<div class="portlet-body" id="tabContainer">
			<div class="form-group" style="height: 55px;display: inline;">
				@yield('promo-shipment-method')
			</div>
		</div>
	</div>
@endsection

@section('global-requirement-script')
	@yield('promo-shipment-method-script')
@endsection
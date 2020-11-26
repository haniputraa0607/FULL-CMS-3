@php
	switch ($promo_source) {
		case 'promo_campaign':
			$data_promo = $result;
			$data_promo['end_period'] = $data_promo['date_end'];
			$data_promo['publish_end_period'] = null;
			break;
		
		case 'deals':
			$data_promo = $deals;
			$data_promo['end_period'] = $data_promo['deals_end'];
			$data_promo['publish_end_period'] = $data_promo['deals_publish_end'];
			break;

		case 'subscription':
			$data_promo = $subscription;
			$data_promo['end_period'] = $data_promo['subscription_end'];
			$data_promo['publish_end_period'] = $data_promo['subscription_publish_end'];
			break;

		default:
			$data_promo = [];
			break;
	}
@endphp

<a data-toggle="modal" href="#extend-period" class="btn btn-primary" style="float: right; margin-right: 5px">Extend Period</a>
{{-- Extend Period Modal --}}
<div id="extend-period" class="modal fade bs-modal-sm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        	<form action="{{ url('promo-campaign/extend-period') }}" method="post">
        		{{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Extend Period</h4>
                </div>
                <div class="modal-body" style="padding-top: 0;padding-bottom: 0">
                    <div class="row">
	                    {{-- End Periode --}}
	                    @if ( (isset($data_promo['deals_type']) && ($data_promo['deals_type'] == "Deals" || $data_promo['deals_type'] == "WelcomeVoucher")) 
	                    	|| (isset($data_promo['id_subscription'])) 
	                    	|| (isset($data_promo['id_promo_campaign'])) 
	                    )
	                    <div class="form-group">
	                        <label class="control-label"> End Periode <span class="required" aria-required="true"> * </span> </label>
	                        <div class="">
	                            <div class="input-icon right">
	                                <div class="input-group">
	                                    <input type="text" class="form_datetime form-control" name="end_period" value="{{ !empty($data_promo['end_period']) || old('end_period') ? date('d-M-Y H:i', strtotime(old('end_period')??$data_promo['end_period'])) : ''}}" required autocomplete="off">
	                                    <span class="input-group-btn">
	                                        <button class="btn default" type="button">
	                                            <i class="fa fa-calendar"></i>
	                                        </button>
	                                    </span>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    @endif

	                    {{-- Publish End Periode --}}
	                    @if ( (isset($data_promo['deals_type']) && $data_promo['deals_type'] == "Deals") 
	                    	|| (isset($data_promo['subscription_type']) && $data_promo['subscription_type'] == "subscription")
	                    )
	                    <div class="form-group">
	                        <label class="control-label"> Publish End Periode <span class="required" aria-required="true"> * </span> </label>
	                        <div class="">
	                            <div class="input-icon right">
	                                <div class="input-group">
	                                    <input type="text" class="form_datetime form-control" name="publish_end_period" value="{{ !empty($data_promo['publish_end_period']) || old('publish_end_period') ? date('d-M-Y H:i', strtotime(old('publish_end_period') ?? $data_promo['publish_end_period'])) : '' }}" required autocomplete="off">
	                                    <span class="input-group-btn">
	                                        <button class="btn default" type="button">
	                                            <i class="fa fa-calendar"></i>
	                                        </button>
	                                    </span>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                    <input type="hidden" value="{{ $data_promo['id_deals'] ?? null }}" name="id_deals" />
                    <input type="hidden" value="{{ $data_promo['id_promo_campaign'] ?? null }}" name="id_promo_campaign" />
                    <input type="hidden" value="{{ $data_promo['id_subscription'] ?? null }}" name="id_subscription" />
                    <button type="submit" class="btn green">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
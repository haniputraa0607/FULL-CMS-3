{{-- @php
	switch ($promo_source) {
		case 'promo_campaign':
			$data_global = $result;
			break;
		
		default:
			$data_global = $deals;
			break;
	}
@endphp

<div class="row static-info">
    <div class="col-md-4 name">Shipment Method</div>
    <div class="col-md-1 value">:</div>
    <div class="col-md-7 value" style="margin-left: -35px">
    	@if ($data_global['is_all_shipment'] == '1')
            <div style="margin-left: -5px">All Shipment</div>
        @elseif ($data_global['is_all_shipment'] == '0')
        	@foreach ($data_global[$promo_source.'_shipment_method'] as $val)
        		<div style="margin-bottom: 10px">{{ '- '.$val['shipment_method'] }}</div>
        	@endforeach
        @else
            -
        @endif
    </div>
</div>

<div class="row static-info">
    <div class="col-md-4 name">Payment Method</div>
    <div class="col-md-1 value">:</div>
    <div class="col-md-7 value" style="margin-left: -35px">
    	@if ($data_global['is_all_payment'] == '1')
            <div style="margin-left: -5px">All Payment Method</div>
        @elseif ($data_global['is_all_payment'] == '0')
        	@foreach ($data_global[$promo_source.'_payment_method'] as $val)
        		<div style="margin-bottom: 10px">{{ '- '.$val['payment_method'] }}</div>
        	@endforeach
        @else
            -
        @endif
    </div>
</div> --}}
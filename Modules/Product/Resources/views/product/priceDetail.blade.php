<?php
$id_product = $product[0]['id_product'];
?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
  <div class="form-body">
		@foreach($outlet as $key => $ou)
		<?php $marker = 0; ?>
        <div class="form-group">
            <label class="col-md-3 control-label">{{$ou['outlet_name']}}</label>
			@foreach($ou['product_prices'] as $keyPrice => $price)
				@if($price['id_product'] == $id_product)
					<?php $marker = 1;?>
					<div class="col-md-4">
						<input type="hidden" name="id_product_price[]" value="{{ $price['id_product_price'] }}">
						<input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
						<input type="text" class="form-control nominal" name="product_price[]" value="{{ $price['product_price'] }}">
					</div>
					<div class="col-md-3">
						<select class="form-control" name="product_visibility[]">
							<option value="Visible" @if($price['product_visibility'] == 'Visible') selected @endif>Visible</option>
							<option value="Hidden" @if($price['product_visibility'] != 'Visible') selected @endif>Hidden</option>
						</select>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control nominal" value="{{ $price['product_status'] }}" disabled>
					</div>
				@endif
			@endforeach
			@if($marker == 0)
				<div class="col-md-4">
					<input type="hidden" name="id_product_price[]" value="0">
					<input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
					<input type="text" class="form-control nominal" name="product_price[]" value="0">
				</div>
				<div class="col-md-3">
					<select class="form-control" name="product_visibility[]">
						<option value="Visible" selected>Visible</option>
						<option value="Hidden">Hidden</option>
					</select>
				</div>
				<div class="col-md-2">
					<input type="text" class="form-control nominal" value="Active" disabled>
				</div>
			@endif
        </div>
		@endforeach
	</div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-3 col-md-9">
            <input type="hidden" name="id_product" value="{{ $id_product }}">
            <button type="submit" class="btn green">Submit</button>
          </div>
      </div>
  </div>
</form>
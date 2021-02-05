<script>
	function changeSelect(){
		setTimeout(function(){
			$(".select2").select2({
				placeholder: "Search"
			});
		}, 100);
	}
	function changeSubject(val){
		var subject = val;
		var temp1 = subject.replace("conditions[", "");
		var index = temp1.replace("][subject]", "");
		var subject_value = document.getElementsByName(val)[0].value;

		if(subject_value == 'province') {
			var operator = "conditions[" + index + "][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for (i = operator_value.options.length - 1; i >= 0; i--) operator_value.remove(i);
			<?php
					foreach($provinces as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['province_name']; ?>', '<?php echo $row['id_province']; ?>');
					<?php
					}
					?>
			var parameter = "conditions[" + index + "][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}else if(subject_value == 'city') {
			var operator = "conditions[" + index + "][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for (i = operator_value.options.length - 1; i >= 0; i--) operator_value.remove(i);
			<?php
					foreach($cities as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['city_name']; ?>', '<?php echo $row['id_city']; ?>');
					<?php
					}
					?>
			var parameter = "conditions[" + index + "][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}else if(subject_value == 'brand') {
			var operator = "conditions[" + index + "][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for (i = operator_value.options.length - 1; i >= 0; i--) operator_value.remove(i);
			<?php
					foreach($brands as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['name_brand']; ?>', '<?php echo $row['id_brand']; ?>');
					<?php
					}
					?>
			var parameter = "conditions[" + index + "][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}else if(subject_value == 'status_franchise'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Mitra', '1');
			operator_value.options[operator_value.options.length] = new Option('Pusat', '0');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}else if(subject_value == 'delivery_order'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Active', '1');
			operator_value.options[operator_value.options.length] = new Option('Inactive', '0');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}else{
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}
	}

</script>

<div class="form-body">
	<div class="form-group mt-repeater">
		<div data-repeater-list="conditions">
			@if (!empty($conditions))
				@foreach ($conditions as $key => $con)
					@if(isset($con['outlet_group_filter_subject']))
						<div data-repeater-item class="mt-repeater-item mt-overflow">
							<div class="mt-repeater-cell">
								<div class="col-md-12">
									<div class="col-md-1">
										<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
											<i class="fa fa-close"></i>
										</a>
									</div>
									<div class="col-md-4">
										<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
											<option value="province" @if ($con['outlet_group_filter_subject'] == 'Province') selected @endif>Province</option>
											<option value="city" @if ($con['outlet_group_filter_subject'] == 'city') selected @endif>City</option>
											<option value="outlet_code" @if ($con['outlet_group_filter_subject'] == 'outlet_code') selected @endif>Outlet Code</option>
											<option value="outlet_name" @if ($con['outlet_group_filter_subject'] == 'outlet_name') selected @endif>Outlet Name</option>
											<option value="status_franchise" @if ($con['outlet_group_filter_subject'] == 'status_franchise') selected @endif>Status Franchise</option>
											<option value="delivery_order" @if ($con['outlet_group_filter_subject'] == 'delivery_order') selected @endif>Status Delivery</option>
											<option value="brand" @if ($con['outlet_group_filter_subject'] == 'brand') selected @endif>Brand</option>
										</select>
									</div>
									<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
											@if($con['outlet_group_filter_subject'] == 'city')
												@foreach($cities as $city)
													<option value="{{$city['id_city']}}" @if ($con['outlet_group_filter_operator']  == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
												@endforeach
											@elseif($con['outlet_group_filter_subject'] == 'province')
												@foreach($provinces as $province)
													<option value="{{$province['id_province']}}" @if ($con['outlet_group_filter_operator']  == $province['id_province']) selected @endif>{{$province['province_name']}}</option>
												@endforeach
											@elseif($con['outlet_group_filter_subject'] == 'brand')
												@foreach($brands as $brand)
													<option value="{{$brand['id_brand']}}" @if ($con['outlet_group_filter_operator']  == $brand['id_brand']) selected @endif>{{$brand['name_brand']}}</option>
												@endforeach
											@elseif($con['outlet_group_filter_subject'] == 'status_franchise')
												<option value="1" @if ($con['outlet_group_filter_operator']  == 1) selected @endif>Mitra</option>
												<option value="0" @if ($con['outlet_group_filter_operator']  == 0) selected @endif>Pusat</option>
											@elseif($con['outlet_group_filter_subject'] == 'delivery_order')
												<option value="1" @if ($con['outlet_group_filter_operator']  == 1) selected @endif>Active</option>
												<option value="0" @if ($con['outlet_group_filter_operator']  == 0) selected @endif>Inactive</option>
											@else
												<option value="=" @if ($con['outlet_group_filter_operator'] == '=') selected @endif>=</option>
												<option value="like" @if ($con['outlet_group_filter_operator']  == 'like') selected @endif>Like</option>
											@endif
										</select>
									</div>

									<div class="col-md-3">
										@if(empty($con['outlet_group_filter_parameter']))
											<input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['outlet_group_filter_parameter'])) value="{{ $con['outlet_group_filter_parameter'] }}" @endif/>
										@else
											<input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['outlet_group_filter_parameter'])) value="{{ $con['outlet_group_filter_parameter'] }}" @endif/>
										@endif
									</div>
								</div>
							</div>
						</div>
					@else
						<div data-repeater-item class="mt-repeater-item mt-overflow">
							<div class="mt-repeater-cell">
								<div class="col-md-12">
									<div class="col-md-1">
										<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
											<i class="fa fa-close"></i>
										</a>
									</div>
									<div class="col-md-4">
										<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
											<option value="" selected disabled>Search Subject</option>
											<option value="province">Province</option>
											<option value="city">City</option>
											<option value="outlet_code">Outlet Code</option>
											<option value="outlet_name">Outlet Name</option>
											<option value="status_franchise">Status Franchise</option>
											<option value="delivery_order">Status Delivery</option>
											<option value="brand">Brand</option>
										</select>
									</div>
									<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
											<option value="=" selected>=</option>
											<option value="like">Like</option>
										</select>
									</div>
									<div class="col-md-3">
										<input type="text" placeholder="Keyword" class="form-control" name="parameter" />
									</div>
								</div>
							</div>
						</div>
					@endif
				@endforeach
			@else
				<div data-repeater-item class="mt-repeater-item mt-overflow">
					<div class="mt-repeater-cell">
						<div class="col-md-12">
							<div class="col-md-1">
								<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
									<i class="fa fa-close"></i>
								</a>
							</div>
							<div class="col-md-4">
								<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
									<option value="" selected disabled>Search Subject</option>
									<option value="province">Province</option>
									<option value="city">City</option>
									<option value="outlet_code">Outlet Code</option>
									<option value="outlet_name">Outlet Name</option>
									<option value="status_franchise">Status Franchise</option>
									<option value="delivery_order">Status Delivery</option>
									<option value="brand">Brand</option>
								</select>
							</div>
							<div class="col-md-4">
								<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
									<option value="=" selected>=</option>
									<option value="like">Like</option>
								</select>
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Keyword" class="form-control" name="parameter" />
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
		<div class="form-action col-md-12">
			<div class="col-md-12">
				<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
					<i class="fa fa-plus"></i> Add New Condition</a>
			</div>
		</div>

		<div class="form-action col-md-12" style="margin-top:15px">
			<div class="col-md-5">
				<select name="rule" class="form-control input-sm " placeholder="Search Rule" required>
					<option value="and" @if (isset($rule) && $rule == 'and') selected @endif>Valid when all conditions are met</option>
					<option value="or" @if (isset($rule) && $rule == 'or') selected @endif>Valid when minimum one condition is met</option>
				</select>
			</div>
		</div>
	</div>
</div>
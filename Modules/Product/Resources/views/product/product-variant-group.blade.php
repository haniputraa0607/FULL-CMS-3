<form class="form-horizontal" id="form_product_variant_group" action="{{url('product/product-variant-group/'.$product[0]['product_code'])}}" method="POST">
    {{ csrf_field() }}
    <div class="form-body">
        @foreach($product_variant_group as $key=>$val)
            <div class="form-group">
                <label  class="col-md-3 control-label">Code</label>
                <div class="col-md-4">
                    <input class="form-control" placeholder="Product Variant Group Code" disabled value="{{$val['product_variant_group_code']}}">
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-3 control-label">Variant</label>
                <div class="col-md-4">
                    <?php
                        $arr = array_column($val['product_variant_pivot'], 'product_variant_name');
                        $name = implode(',',$arr);
                    ?>
                    <input class="form-control" disabled value="{{$name}}">
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-3 control-label">Price <span class="text-danger">*</span></label>
                <div class="col-md-4">
                    <input class="form-control price" maxlength="11" name="variants[{{$key}}][product_variant_group_price]" placeholder="Price Product Variant Group" value="{{(int)$val['product_variant_group_price']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Visible <span class="text-danger">*</span>
                </label>
                <div class="input-icon right">
                    <div class="col-md-2">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio-variant-visibility1_{{$key}}" name="variants[{{$key}}][product_variant_group_visibility]" class="md-radiobtn req-type" value="Visible" @if(!empty($val['variant_detail']) && $val['variant_detail']['product_variant_group_visibility'] == 'Visible') checked @endif>
                                <label for="radio-variant-visibility1_{{$key}}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Visible</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio-variant-visibility2_{{$key}}"name="variants[{{$key}}][product_variant_group_visibility]" class="md-radiobtn req-type" value="Hidden" @if(empty($val['variant_detail']) || $val['variant_detail']['product_variant_group_visibility'] == 'Hidden') checked @endif>
                                <label for="radio-variant-visibility2_{{$key}}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Hidden </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="multiple" class="control-label col-md-3">Wholesaler</label>
                <div class="col-md-8" id="div_variant_wholesaler_{{$key}}">
                    <a class="btn yellow" style="margin-bottom: 2%" onclick="addVariantWholesaler('{{$key.'_'.count($val['product_variant_group_wholesaler'])}}')">Add Wholesaler <i class="fa fa-plus-circle"></i></a>
                    @foreach($val['product_variant_group_wholesaler'] as $index=>$wholesaler)
                        <div class="row" style="margin-bottom: 2%" id="variant_wholesaler_{{$key}}_{{$index}}">
                            <div class="col-md-5">
                                <div class="input-group">
                            <span class="input-group-addon">
                                min
                            </span>
                                    <input class="form-control price" required name="variants[{{$key}}][wholesalers][{{$index}}][minimum]" value="{{$wholesaler['variant_wholesaler_minimum']}}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input class="form-control price" required name="variants[{{$key}}][wholesalers][{{$index}}][unit_price]" value="{{(int)$wholesaler['variant_wholesaler_unit_price']}}">
                                    <span class="input-group-addon">
                                /pcs
                            </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a class="btn red" style="margin-bottom: 2%" onclick="deleteVariantWholesaler('{{$key.'_'.$index}}')"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <input type="hidden" value="{{$val['id_product_variant_group']}}" name="variants[{{$key}}][id_product_variant_group]">
            <hr style="border-top: 1px dashed black;">
        @endforeach
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                <button type="submit" class="btn btn-success mr-2">Submit</button>
            </div>
        </div>
    </div>
</form>

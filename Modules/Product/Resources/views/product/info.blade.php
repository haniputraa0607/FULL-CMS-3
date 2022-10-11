<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($product as $syu)
    <div class="form-body">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Product Variant Status <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Jika produk memiliki variant silahkan centang checkbox ini" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="icheck-list">
                    <label><input type="checkbox" class="icheck" id="checkbox-variant" name="product_variant_status" @if($product[0]['product_variant_status'] == 1) checked @endif> </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Category <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih Kategori Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <select id="multiple" class="form-control select2-multiple" name="id_product_category" data-placeholder="select category" required>
                    <optgroup label="Category List">
                        <option value="0">Uncategorize</option>
                        @if (!empty($parent))
                            @foreach($parent as $suw)
                                <option value="{{ $suw['id_product_category'] }}" @if (($syu['category'][0]['id_product_category']??false) == $suw['id_product_category']) selected @endif>{{ $suw['product_category_name'] }}</option>
                                @if (!empty($suw['child']))
                                    @foreach ($suw['child'] as $child)
                                        <option value="{{ $child['id_product_category'] }}" @if ($syu['id_product_category'] == $child['id_product_category']) selected @endif data-ampas="{{ $child['product_category_name'] }}">&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </optgroup>
                </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="product_name" value="{{ $syu['product_name'] }}" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Code
                <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="product_code" value="{{ $syu['product_code'] }}" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Global Price <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Global Price Product" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control price" name="product_global_price" value="@if(isset($syu['global_price'][0]['product_global_price'])) {{number_format($syu['global_price'][0]['product_global_price'])}} @endif"  @if($product[0]['product_variant_status'] == 1) disabled @endif required>
                    <input type="hidden" id="old_global_price" value="@if(isset($syu['global_price'][0]['product_global_price'])) {{number_format($syu['global_price'][0]['product_global_price'])}} @endif">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Need Recipe
                <i class="fa fa-question-circle tooltips" data-original-title="Setting apakah produk memerlukan resep dari dokter" data-container="body"></i>
            </label>
            <div class="input-icon right">
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio_recipe1" name="need_recipe_status" class="md-radiobtn req-type" value="1" required @if($syu['need_recipe_status'] == 1) checked @endif>
                            <label for="radio_recipe1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Need</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio_recipe2" name="need_recipe_status" class="md-radiobtn req-type" value="0" required @if($syu['need_recipe_status'] == 0) checked @endif>
                            <label for="radio_recipe2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> No Need </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Product Visible
                <i class="fa fa-question-circle tooltips" data-original-title="Setting apakah produk akan ditampilkan di aplikasi" data-container="body"></i>
            </label>
            <div class="input-icon right">
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio1" name="product_visibility" class="md-radiobtn req-type" value="Visible" required @if($syu['product_visibility'] == 'Visible') checked @endif>
                            <label for="radio1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Visible</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio2" name="product_visibility" class="md-radiobtn req-type" value="Hidden" required @if($syu['product_visibility'] == 'Hidden') checked @endif>
                            <label for="radio2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Hidden </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="form-group">
            <label class="col-md-3 control-label">
                Photo <span class="required" aria-required="true">* </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                     <img src="@if(isset($syu['photos'][0]['url_product_photo'])){{$syu['photos'][0]['url_product_photo']}}@endif" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo">
                        </span>

                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>


        <!--<div class="form-group">-->
        <!--    <label class="col-md-3 control-label">Video-->
        <!--        <br>-->
        <!--        <span class="required" aria-required="true"> (from youtube) </span> -->
        <!--        <i class="fa fa-question-circle tooltips" data-original-title="Video Tentang Produk" data-container="body"></i>-->
        <!--    </label>-->
        <!--    <div class="col-md-8">-->
        <!--        <div class="input-icon right">-->
        <!--            <input type="url" placeholder="Example: https://www.youtube.com/watch?v=u9_2wWSOQ" class="form-control" name="product_video" value="{{ $syu['product_video'] }}">-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!--<div class="form-group">-->
        <!--    <label class="col-md-3 control-label">Weight-->
        <!--        <br>-->
        <!--        <span class="required" aria-required="true"> (gram) </span> -->
        <!--        <i class="fa fa-question-circle tooltips" data-original-title="Berat Produk" data-container="body"></i>-->
        <!--    </label>-->
        <!--    <div class="col-md-8">-->
        <!--        <div class="input-icon right">-->
        <!--            <input type="number" class="form-control" name="product_weight" value="{{ $syu['product_weight'] }}" required>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <div class="form-group">
           <label for="multiple" class="control-label col-md-3">Description
               <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
           </label>
           <div class="col-md-8">
               <div class="input-icon right">
                   <textarea name="product_description" id="pro_text" class="form-control">{{ $syu['product_description'] }}</textarea>
               </div>
           </div>
        </div>

        <div class="form-group" id="div_parent_wholesaler" @if($product[0]['product_variant_status'] == 1) style="display: none" @endif>
            <label for="multiple" class="control-label col-md-3">Wholesaler
                <i class="fa fa-question-circle tooltips" data-original-title="Harga grosir" data-container="body"></i>
            </label>
            <div class="col-md-8" id="div_wholesaler">
                <a class="btn yellow" style="margin-bottom: 2%" onclick="addWholesaler({{count($syu['product_wholesaler'])}})">Add Wholesaler <i class="fa fa-plus-circle"></i></a>
                @foreach($syu['product_wholesaler'] as $key=>$wholesaler)
                    <div class="row" style="margin-bottom: 2%" id="wholesaler_{{$key}}">
                        <div class="col-md-5">
                            <div class="input-group">
                            <span class="input-group-addon">
                                min
                            </span>
                                <input class="form-control price" required name="product_wholesaler[{{$key}}][minimum]" value="{{$wholesaler['product_wholesaler_minimum']}}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input class="form-control price" required name="product_wholesaler[{{$key}}][unit_price]" value="{{(int)$wholesaler['product_wholesaler_unit_price']}}">
                                <span class="input-group-addon">
                                /pcs
                            </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a class="btn red" onclick="deleteWholesaler({{$key}})"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <input type="hidden" name="id_product" value="{{ $syu['id_product'] }}">
    @endforeach

    @if(MyHelper::hasAccess([51], $grantedFeature))
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-3 col-md-8">
                    <button type="submit" id="submit" class="btn green">Update</button>
                @if($next_id)
                    <a href="{{url('product/detail'.$next_id)}}" type="button" class="btn default">Next</a>
                @endif
                </div>
            </div>
        </div>
    @endif
</form>
 <!--begin::Modal-->
 <div class="modal fade" id="m_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    New Tag
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">
                            Tag Name:
                        </label>
                        <input type="text" class="form-control" id="tag_name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal" id="close_modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="new_tag">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
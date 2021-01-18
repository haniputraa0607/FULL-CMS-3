@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        var i = 0;
        var outlet_selected = <?php echo json_encode(old('id_outlet'))?>;
        $(document).ready(function() {
            var data_product = <?php echo json_encode((empty(old('data_product')) ? [] : array_values(old('data_product'))))?>;
            if(data_product && data_product.length > 0){
                i=data_product.length + 1;
                for(var a=0;a<data_product.length;a++){
                    var brands = <?php echo json_encode($brands)?>;
                    var html = '';
                    html += '<div id="product_'+i+'">';
                    html += '<hr style="border-top: 2px dashed;">';
                    html += '<div class="row">';
                    html += '<div class="col-md-6">';
                    html += '<div class="form-group">';
                    html += '<label for="multiple" class="control-label col-md-4">Brand <span class="required" aria-required="true"> * </span></label>';
                    html += '<div class="col-md-8">';
                    html += '<div class="input-icon right">';
                    html += '<select  class="form-control select2 select2-multiple-product brands" name="data_product['+i+'][id_brand]" id="brand_'+i+'" data-placeholder="Select brand" required onchange="loadProduct(this.value, '+i+')">';
                    html += '<option></option>';
                    for(var j=0;j<brands.length;j++){
                        if(data_product[a].id_brand == brands[j].id_brand){
                            html += '<option value='+brands[j].id_brand+' selected>'+brands[j].name_brand+'</option>';
                        }else{
                            html += '<option value='+brands[j].id_brand+'>'+brands[j].name_brand+'</option>';
                        }
                    }
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label for="multiple" class="control-label col-md-4">Product <span class="required" aria-required="true"> * </span></label>';
                    html += '<div class="col-md-8">';
                    html += '<div class="input-icon right">';
                    html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][id_product]" id="select_product_'+i+'" data-placeholder="Select product" required disabled onchange="loadProductVariant(this.value, '+i+')">';
                    html += '<option></option>';
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label for="multiple" class="control-label col-md-4">Product Variant</label>';
                    html += '<div class="col-md-8">';
                    html += '<div class="input-icon right">';
                    html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][id_product_variant_group]" id="product_variant_'+i+'" data-placeholder="Select product variant" disabled onchange="loadPrice('+i+', null, this.value)">';
                    html += '<option></option>';
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-4 control-label">Global Price</label>';
                    html += '<div class="col-md-8">';
                    html += '<div class="input-icon right">';
                    html += '<input type="text" placeholder="Global Price" id="global_price_'+i+'" class="form-control" disabled>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-4 control-label">Quantity <span class="required" aria-required="true"> * </span></label>';
                    html += '<div class="col-md-8">';
                    html += '<div class="input-icon right">';
                    html += '<input type="text" placeholder="Quantity" class="form-control" name="data_product['+i+'][qty]" value="'+data_product[a].qty+'" required>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="form-group">';
                    html += '<label for="multiple" class="control-label col-md-5">Discount Type <span class="required" aria-required="true"> * </span></label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][discount_type]" data-placeholder="Select discount type" required onchange="changeDisableMaxDiscoint(this.value, '+i+')">';
                    html += '<option></option>';
                    if(data_product[a].discount_type == 'Percent'){
                        html += '<option value="Percent" selected>Percent</option>';
                        html += '<option value="Nominal">Nominal</option>';
                    }else{
                        html += '<option value="Percent">Percent</option>';
                        html += '<option value="Nominal" selected>Nominal</option>';
                    }

                    html += '</select>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-5 control-label">Discount Per Item<span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Diskon berlaku untuk 1 item" data-container="body"></i></label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    html += '<input type="text" placeholder="Discount" class="form-control" name="data_product['+i+'][discount]" value="'+data_product[a].discount+'" required>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-5 control-label">Max Discount Per Item <span class="required" aria-required="true"> * </span>';
                    html += '<i class="fa fa-question-circle tooltips" data-original-title="Maksimum diskon untuk setiap item" data-container="body"></i>';
                    html += '</label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    if(data_product[a].discount_type == 'Percent'){
                        html += '<input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_'+i+'" name="data_product['+i+'][maximum_discount]" value="'+data_product[a].maximum_discount+'">';
                    }else{
                        html += '<input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_'+i+'" name="data_product['+i+'][maximum_discount]" disabled>';
                    }

                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-5 control-label">Charged Central <span class="required" aria-required="true"> * </span></label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    html += '<div class="input-group">';
                    html += '<input type="text" placeholder="Charged Central" class="form-control" name="data_product['+i+'][charged_central]" value="'+data_product[a].charged_central+'" required>';
                    html += '<span class="input-group-addon">%</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-5 control-label">Charged Outlet <span class="required" aria-required="true"> * </span></label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    html += '<div class="input-group">';
                    html += '<input type="text" placeholder="Charged Outlet" class="form-control" name="data_product['+i+'][charged_outlet]" value="'+data_product[a].charged_outlet+'" required>';
                    html += '<span class="input-group-addon">%</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div style="text-align: right"><a class="btn red" onclick="deleteProduct('+i+')">Delete Product <i class="fa fa-trash"></i></a></div>';
                    html += '</div>';

                    $("#list_product").append(html);
                    $('.select2-multiple-product').select2({
                        'placeholder':$(this).data('placeholder')
                    });
                    loadProduct(data_product[a].id_brand, i, data_product[a].id_product);
                    loadProductVariant(data_product[a].id_product, i, data_product[a].id_product_variant_group);
                    if(data_product[a].id_product_variant_group){
                        loadPrice(i, null, data_product[a].id_product_variant_group);
                    }else{
                        loadPrice(i, data_product[a].id_product, null);
                    }
                    var key_name = "brand_"+i;
                    tmpBrand.set(key_name, data_product[a].id_brand);
                    i++;
                }
                loadOutlet(outlet_selected);
            }else{
                i=1;
            }
        });

        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        $('.timepicker').timepicker();

        $(".form_datetime").datetimepicker({
            format: "d-M-yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            minuteStep:1
        });

        $("#fieldphoto").change(function(e) {
            var widthImg  = 300;
            var heightImg = 300;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                        //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageproduct').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA');
                        $('#fieldphoto').val("");

                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });

        $("#fieldphotoDetail").change(function(e) {
            var widthImg  = 720;
            var heightImg = 360;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width != widthImg || this.height != heightImg) {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageproductDetail').children('img').attr('src', 'https://www.placehold.it/720x360/EFEFEF/AAAAAA');
                        $('#fieldphotoDetail').val("");
                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });

        function addProduct() {
            var brands = <?php echo json_encode($brands)?>;
            var html = '';
            html += '<div id="product_'+i+'">';
            html += '<hr style="border-top: 2px dashed;">';
            html += '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-4">Brand <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product brands" name="data_product['+i+'][id_brand]" id="brand_'+i+'" data-placeholder="Select brand" required onchange="loadProduct(this.value, '+i+')">';
            html += '<option></option>';
            for(var j=0;j<brands.length;j++){
                html += '<option value='+brands[j].id_brand+'>'+brands[j].name_brand+'</option>';
            }
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-4">Product <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][id_product]" id="select_product_'+i+'" data-placeholder="Select product" required disabled onchange="loadProductVariant(this.value, '+i+')">';
            html += '<option></option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-4">Product Variant</label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][id_product_variant_group]" id="product_variant_'+i+'" data-placeholder="Select product variant" disabled onchange="loadPrice('+i+', null, this.value)">';
            html += '<option></option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-4 control-label">Global Price</label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Global Price" id="global_price_'+i+'" class="form-control" disabled>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-4 control-label">Quantity <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Quantity" class="form-control" name="data_product['+i+'][qty]" required>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-6">';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-5">Discount Type <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][discount_type]" data-placeholder="Select discount type" required onchange="changeDisableMaxDiscoint(this.value, '+i+')">';
            html += '<option></option>';
            html += '<option value="Percent">Percent</option>';
            html += '<option value="Nominal">Nominal</option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Discount Per Item<span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Diskon berlaku untuk 1 item" data-container="body"></i></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Discount" class="form-control" name="data_product['+i+'][discount]" id="discount_per_item_'+i+'" required>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Max Discount Per Item <span class="required" aria-required="true"> * </span>';
            html += '<i class="fa fa-question-circle tooltips" data-original-title="Maksimum diskon untuk setiap item" data-container="body"></i>';
            html += '</label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_'+i+'" name="data_product['+i+'][maximum_discount]" disabled>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Charged Central <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<div class="input-group">';
            html += '<input type="text" placeholder="Charged Central" class="form-control" name="data_product['+i+'][charged_central]" required>';
            html += '<span class="input-group-addon">%</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Charged Outlet <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<div class="input-group">';
            html += '<input type="text" placeholder="Charged Outlet" class="form-control" name="data_product['+i+'][charged_outlet]" required>';
            html += '<span class="input-group-addon">%</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div style="text-align: right"><a class="btn red" onclick="deleteProduct('+i+')">Delete Product <i class="fa fa-trash"></i></a></div>';
            html += '</div>';

            $("#list_product").append(html);
            $('.select2-multiple-product').select2({
                'placeholder':$(this).data('placeholder')
            });
            i++;
        }

        var tmpBrand = new Map();
        function deleteProduct(id) {
            var check = $("#available_outlet").select2("val");

            if(check !== 'null' && check !== null && check !== ""){
                if(confirm("Are you sure delete this product? \nIf you delete this product, field outlet available will be reset?")){
                    $("#product_"+id).remove();
                    tmpBrand.delete('brand_'+id);
                    loadOutlet();
                }
            }else{
                if(confirm("Are you sure delete this product?")) {
                    $("#product_"+id).remove();
                }
            }
        }

        $('.brands').on("select2:selecting", function(e) {
            var id = this.id;
            var list_count = id.split('_')[1];
            var check = $("#available_outlet").select2("val");
            var prev_id_brand = $("#brand_"+list_count).val();
            $("#global_price_"+id).val('');
            $("#product_variant_"+id).empty();

            if(check !== 'null' && check !== null && check !== ""){
                if(confirm("Are you sure change this brand? \nIf you change this brand, field outlet available will be reset?")){
                    $("#available_outlet").empty();
                }else{
                    e.preventDefault();
                }
            }
        });

        function loadOutlet(selected_outlet = []) {
            $("#available_outlet").empty();
            $("#available_outlet").append('<option></option>');
            if(selected_outlet.length > 0 && selected_outlet.indexOf('all') >= 0){
                $("#available_outlet").append('<option value="all" selected>All Outlet</option>');
            }else{
                $("#available_outlet").append('<option value="all">All Outlet</option>');
            }
            var token  = "{{ csrf_token() }}";
            var brands = Array.from(tmpBrand, ([name, value]) => ({ value }));

            $.ajax({
                type: "POST",
                url: "{{url('product-bundling/outlet-available')}}",
                data : {
                    "_token" : token,
                    "brands" : brands
                },
                success: function(result){
                    if(result.status == 'success'){
                        var data = result.result;
                        var length = result.result.length;
                        for(var i=0;i<length;i++){
                            if(selected_outlet.length > 0 && selected_outlet.indexOf(data[i].id_outlet.toString()) >= 0){
                                $("#available_outlet").append('<option value="'+data[i].id_outlet+'" selected>'+data[i].outlet_code+' - '+data[i].outlet_name+'</option>');
                            }else{
                                $("#available_outlet").append('<option value="'+data[i].id_outlet+'">'+data[i].outlet_code+' - '+data[i].outlet_name+'</option>');
                            }
                        }
                    }else{
                        toastr.warning("Failed get data outlet.");
                    }
                },
                error : function(result) {
                    toastr.warning("Failed get data outlet.");
                }
            });
        }

        function loadProduct(id_brand, list_count, id_product = null) {
            $("#select_product_"+list_count).prop('disabled', true);
            $("#global_price_"+list_count).val('');
            $("#select_product_"+list_count).empty();
            $("#select_product_"+list_count).append('<option></option>');
            var token  = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{url('product-bundling/product-brand')}}",
                data : {
                    "_token" : token,
                    "id_brand" : id_brand
                },
                success: function(result){
                    if(result.status == 'success'){
                        var data = result.result;
                        var length = result.result.length;
                        for(var i=0;i<length;i++){
                            if(data[i].id_product == id_product){
                                $("#select_product_"+list_count).append('<option value="'+data[i].id_product+'" selected>'+data[i].product_code+' - '+data[i].product_name+'</option>');
                            }else{
                                $("#select_product_"+list_count).append('<option value="'+data[i].id_product+'">'+data[i].product_code+' - '+data[i].product_name+'</option>');
                            }
                        }
                        $("#select_product_"+list_count).prop('disabled', false);
                    }else{
                        toastr.warning("Failed get data product.");
                    }
                    var key_name = "brand_"+list_count;
                    tmpBrand.set(key_name, id_brand);
                    if(!id_product){
                        loadOutlet();
                    }
                },
                error : function(result) {
                    toastr.warning("Failed get data product.");
                }
            });
        }

        function loadProductVariant(id_product, list_count, id_product_variant_group) {
            $("#global_price_"+list_count).val('');
            $("#product_variant_"+list_count).empty();
            $("#product_variant_"+list_count).append('<option></option>');
            $.ajax({
                type: "GET",
                url: "{{url('product-variant-group/ajax')}}/"+id_product,
                success: function(result){
                    var length = result.length;
                    if(length > 0){
                        $("#product_variant_"+list_count).prop('disabled', false);
                        for(var i=0;i<length;i++){
                            if(result[i].id_product_variant_group == id_product_variant_group){
                                $("#product_variant_"+list_count).append('<option value="'+result[i].id_product_variant_group+'" selected>'+result[i].product_variant_group_name+'</option>');
                            }else{
                                $("#product_variant_"+list_count).append('<option value="'+result[i].id_product_variant_group+'">'+result[i].product_variant_group_name+'</option>');
                            }
                        }
                    }else{
                        loadPrice(list_count, id_product, null);
                        $("#product_variant_"+list_count).prop('disabled', true);
                    }
                },
                error : function(result) {
                    $("#product_variant_"+list_count).prop('disabled', true);
                    toastr.warning("Failed get data product variant.");
                }
            });
        }
        
        function loadPrice(id_element, id_product, id_product_variant_group) {
            $("#global_price_"+id_element).val('');
            var token  = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{url('product-bundling/global-price')}}",
                data : {
                    "_token" : token,
                    "id_product" : id_product,
                    "id_product_variant_group" : id_product_variant_group
                },
                success: function(result){
                    if(result.status == 'success'){
                        $("#global_price_"+id_element).val(result.result.price);
                    }else{
                        toastr.warning("Failed get global price.");
                    }
                },
                error : function(result) {
                    toastr.warning("Failed get global price.");
                }
            });
        }
        
        function changeDisableMaxDiscoint(value, list_count) {
            $("#discount_per_item_"+list_count).val('');
            $("#maximum_discount_"+list_count).val('');
            if(value == 'Percent'){
                $("#maximum_discount_"+list_count).prop('disabled', false);
                $("#maximum_discount_"+list_count).prop('required', true);
            }else{
                $("#maximum_discount_"+list_count).prop('disabled', true);
                $("#maximum_discount_"+list_count).prop('required', false);
            }
        }
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
                <span class="caption-subject sbold uppercase font-blue">New Product Bundling</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('product-bundling/store')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling ID <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Bundling ID (unique)" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling ID" class="form-control" name="bundling_code" value="{{ old('bundling_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling name" class="form-control" name="bundling_name" value="{{ old('bundling_name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Bundling Periode <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Produk bandling akan muncul pada aplikasi berdasarkan periode yang dipilih" data-container="body"></i></label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="bundling_start" value="{{ old('bundling_start') }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai Product Bundling" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="bundling_end" value="{{ old('bundling_end') }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir Product Bundling" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Photo <span class="required" aria-required="true">* <br>(300*300) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                <img src="https://www.placehold.it/300x300/EFEFEF/AAAAAA" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo" required>
                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Photo Detail <span class="required" aria-required="true">* <br>(720 * 360)</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="height: 150px;">
                                    <img id="preview_image" src="https://www.placehold.it/720x360/EFEFEF/AAAAAA"/>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproductDetail" style="max-height: 2000px;max-width: 250px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphotoDetail" accept="image/*" name="photo_detail" required>
                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Description<span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <textarea name="bundling_description" id="text_pro" class="form-control">{{ old('bundling_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center"><h3>List Product</h3></div>
                    <hr>
                    <div id="list_product">
                        @if(empty(old('data_product')))
                            <div id="product_0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Brand <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 brands select2-multiple-product" name="data_product[0][id_brand]" id="brand_0" data-placeholder="Select brand" required onchange="loadProduct(this.value, 0)">
                                                        <option></option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand['id_brand']}}">{{$brand['name_brand']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Product <span class="required" aria-required="true"> * </span></label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[0][id_product]" id="select_product_0" data-placeholder="Select product" required disabled onchange="loadProductVariant(this.value, 0)">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Product Variant</label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[0][id_product_variant_group]" id="product_variant_0" data-placeholder="Select product variant" onchange="loadPrice(0, null, this.value)" disabled>
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Global Price
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Global Price" id="global_price_0" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Quantity <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Quantity" class="form-control" name="data_product[0][qty]" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-5">Discount Type <span class="required" aria-required="true"> * </span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[0][discount_type]" data-placeholder="Select discount type" required onchange="changeDisableMaxDiscoint(this.value, 0)">
                                                        <option></option>
                                                        <option value="Percent">Percent</option>
                                                        <option value="Nominal">Nominal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Discount Per Item <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Diskon berlaku untuk 1 item" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Discount" class="form-control" name="data_product[0][discount]" id="discount_per_item_0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Max Discount Per Item <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Maksimum diskon untuk setiap item, silahkan isi dengan angka 0 jika tidak ingin menggunakan maximum discount" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_0" name="data_product[0][maximum_discount]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Charged Central <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" placeholder="Charged Central" class="form-control" name="data_product[0][charged_central]" required>
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Charged Outlet <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" placeholder="Charged Outlet" class="form-control" name="data_product[0][charged_outlet]" required>
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div style="text-align: right">
                        <a class="btn green" onclick="addProduct()">Add Product <i class="fa fa-plus-circle"></i></a>
                    </div>
                    <br>
                    <div style="text-align: center"><h3>Outlet Available</h3></div>
                    <hr>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Outlet Available
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang available untuk product bundling yang akan dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" id="available_outlet" multiple required>
                            </select>
                        </div>
                    </div>
                </div>                
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
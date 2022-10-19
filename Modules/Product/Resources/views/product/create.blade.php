@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
            ],
            callbacks: {
                onImageUpload: function(files){
                    sendFile(files[0], $(this).attr('id'));
                },
                onMediaDelete: function(target){
                    var name = target[0].src;
                    token = "<?php echo csrf_token(); ?>";
                    $.ajax({
                        type: 'post',
                        data: 'filename='+name+'&_token='+token,
                        url: "{{url('summernote/picture/delete/product')}}",
                        success: function(data){
                            // console.log(data);
                        }
                    });
                }
            }
        });
    });


    $('.onlynumber').keypress(function (e) {
        var regex = new RegExp("^[0-9]");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

        var check_browser = navigator.userAgent.search("Firefox");

        if(check_browser == -1){
            if (regex.test(str) || e.which == 8) {
                return true;
            }
        }else{
            if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                return true;
            }
        }

        e.preventDefault();
        return false;
    });

    function sendFile(file, id){
        token = "<?php echo csrf_token(); ?>";
        var data = new FormData();
        data.append('image', file);
        data.append('_token', token);
        // document.getElementById('loadingDiv').style.display = "inline";
        $.ajax({
            url : "{{url('summernote/picture/upload/product')}}",
            data: data,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(url) {
                if (url['status'] == "success") {
                    $('#'+id).summernote('editor.saveRange');
                    $('#'+id).summernote('editor.restoreRange');
                    $('#'+id).summernote('editor.focus');
                    $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                }
                // document.getElementById('loadingDiv').style.display = "none";
            },
            error: function(data){
                // document.getElementById('loadingDiv').style.display = "none";
            }
        })
    }

    $('.price').each(function() {
        var input = $(this).val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $(this).val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "id" );
        });
    });

    $( ".price" ).on( "keyup", numberFormat);
    function numberFormat(event){
        var selection = window.getSelection().toString();
        if ( selection !== '' ) {
            return;
        }

        if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
            return;
        }
        var $this = $( this );
        var input = $this.val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $this.val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "id" );
        });
    }

    $( ".price" ).on( "blur", checkFormat);
    function checkFormat(event){
        var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
        if(!$.isNumeric(data)){
            $( this ).val("");
        }
    }

    $('#checkbox-variant').on('ifChanged', function(event) {
        if(this.checked) {
            $('#variants').show();
            $("input[name=base_price]").val('');
            $("input[name=base_price]").prop('disabled', true);
            $('input[name=base_price]').prop('required',false);

            $('input[name=stock]').val('');
            $('input[name=stock]').prop('disabled', true);
            $('input[name=stock]').prop('required',false);
            $('#stock').hide();

            $('#wholesaler').empty();
            $('#div_wholesaler').hide();
        }else{
            $('#variants').hide();
            $('#data_variant_price').val('');
            $('#variant_price').empty();
            $("input[name=base_price]").val(0);
            $("input[name=base_price]").prop('disabled', false);
            $('input[name=base_price]').prop('required',true);

            $('input[name=stock]').val('');
            $('input[name=stock]').prop('disabled', false);
            $('input[name=stock]').prop('required',true);
            $('#stock').show();
            $('#div_wholesaler').show();
        }
    });

    var array_color = [];
    var array_size = [];

    function addVariantColor(){
        $('#data_variant_price').val('');
        $('#variant_price').empty();
        var name = $('#variant_name_color').val();
        var check = false;
        for (var i=0;i<array_color.length;i++){
            if(name.toLowerCase() == array_color[i].toLowerCase()){
                check = true;
            }
        }

        if(!check){
            array_color.push(name);
            var id = name.replace(" ", "_");
            var html = '<div class="row" id="variant_color_'+id+'" style="margin-bottom: 0.5%">' +
                '<div class="col-md-4"><input type="text" class="form-control" name="variant_color[]" value="'+name+'" readonly></div>'+
                '<div class="col-md-4"><a class="btn btn-danger" onclick="deleteVariantColor(`'+name+'`)"><i class="fa fa-trash"></i></a></div>'+
                '</div>';

            $('#variant_color').append(html);
        }

        $('#variant_name_color').val('');
        $('#modalVariantColor').modal('hide');
    }

    function deleteVariantColor(name){
        $('#data_variant_price').val('');
        $('#variant_price').empty();
        var id = name.replace(" ", "_");
        for (var i=0;i<array_color.length;i++){
            if(name.toLowerCase() == array_color[i].toLowerCase()){
                array_color.splice(i, 1);
            }
        }
        $('#variant_color_'+id).empty();
    }

    function addVariantSize(){
        $('#data_variant_price').val('');
        $('#variant_price').empty();
        var name = $('#variant_name_size').val();
        var check = false;
        for (var i=0;i<array_size.length;i++){
            if(name.toLowerCase() == array_size[i].toLowerCase()){
                check = true;
            }
        }

        if(!check){
            array_size.push(name);
            var id = name.replace(" ", "_");
            var html = '<div class="row" id="variant_size_'+id+'" style="margin-bottom: 0.5%">' +
                '<div class="col-md-4"><input type="text" class="form-control" name="variant_size[]" value="'+name+'" readonly></div>'+
                '<div class="col-md-4"><a class="btn btn-danger" onclick="deleteVariantSize(`'+name+'`)"><i class="fa fa-trash"></i></a></div>'+
                '</div>';

            $('#variant_size').append(html);
        }

        $('#variant_name_size').val('');
        $('#modalVariantSize').modal('hide');
    }

    function deleteVariantSize(name){
        $('#data_variant_price').val('');
        $('#variant_price').empty();
        var id = name.replace(" ", "_");
        for (var i=0;i<array_size.length;i++){
            if(name.toLowerCase() == array_size[i].toLowerCase()){
                array_size.splice(i, 1);
            }
        }
        $('#variant_size_'+id).empty();
    }

    var array_variant_price = [];
    function showVariantPrice(){
        array_variant_price = [];
        $('#data_variant_price').val('');
        $.ajax({
            type : "POST",
            url : "{{ url('product/variant-combination') }}",
            data : {
                "_token" : "{{ csrf_token() }}",
                "array_color" : array_color,
                "array_size" : array_size
            },
            success : function(result) {
                if (result.status == "success") {
                    var data_price = result.result.variants_price;
                    array_variant_price = data_price;

                    var html = '';
                    for (var i =0;i<data_price.length;i++){
                        var price = '';
                        if($('#price_var_'+i).val()){
                            price = $('#price_var_'+i).val();
                        }
                        var stock = '';
                        if($('#stock_var_'+i).val()){
                            stock = $('#stock_var_'+i).val();
                        }

                        var visible = '';
                        var hidden = '';
                        if($('#visibility_var_'+i).val()){
                            if($('#visibility_var_'+i).val() == 'Visible'){
                                visible = 'selected';
                            }else if($('#visibility_var_'+i).val() == 'Hidden'){
                                hidden = 'selected';
                            }
                        }else{
                            visible = 'selected';
                        }

                        html += '<br><h3 style="text-align: center">'+data_price[i].name+'</h3><hr style="border-top: 2px dashed black;"><br>';
                        html += '<div class="row" style="margin-bottom: 1%">' +
                            '<div class="col-md-2">Price</div>'+
                            '<div class="col-md-4"><input type="text" class="form-control price" id="price_var_'+i+'" value="'+price+'" placeholder="Price"></div>'+
                            '</div>';
                        html += '<div class="row" style="margin-bottom: 1%">' +
                            '<div class="col-md-2">Stock</div>'+
                            '<div class="col-md-4"><input type="text" class="form-control onlynumber" value="'+stock+'" id="stock_var_'+i+'" placeholder="Stock"></div>'+
                            '</div>';
                        html += '<div class="row" style="margin-bottom: 1%">' +
                            '<div class="col-md-2">Visibility</div>'+
                            '<div class="col-md-4"><select class="form-control select2-multiple" id="visibility_var_'+i+'" data-placeholder="Select">' +
                            '<option value="Visible" '+visible+'>Visible</option>'+
                            '<option value="Hidden" '+hidden+'>Hidden</option>'+
                            '</select>'+
                            '</div>'+
                            '</div>';
                    }

                    $('#modal_content_variant_price').empty();
                    $('#modal_content_variant_price').append(html);
                    $('#modalVariantPrice').modal('show');
                }
                else if(result.status == "fail"){
                    $('#modal_content_variant_price').empty();
                    swal("Error!", result.messages[0], "error")
                }
                else {
                    $('#modal_content_variant_price').empty();
                    swal("Error!", "Something went wrong. Failed to delete candidate.", "error")
                }
            }
        });
    }

    function variantUpdatePrice(){
        $('#data_variant_price').val('');
        $('#variant_price').empty();

        var html = '';
        for (var i=0;i<array_variant_price.length;i++){
            array_variant_price[i].price = $('#price_var_'+i).val();
            array_variant_price[i].stock = $('#stock_var_'+i).val();
            array_variant_price[i].visibility = $('#visibility_var_'+i).val();
            html += '<br><h4 style="text-align: center">'+array_variant_price[i].name+'</h4><hr style="border-top: 2px dashed black;"><br>';
            html += '<div class="row" style="margin-bottom: 1%">' +
                '<div class="col-md-8">Price : '+$('#price_var_'+i).val()+'</div>'+
                '</div>';
            html += '<div class="row" style="margin-bottom: 1%">' +
                '<div class="col-md-8">Stock : '+$('#stock_var_'+i).val()+'</div>'+
                '</div>';
            html += '<div class="row" style="margin-bottom: 1%">' +
                '<div class="col-md-8">Visibility : '+$('#visibility_var_'+i).val()+'</div>'+
                '</div>';
            html += '<div class="row" style="margin-bottom: 1%">' +
                '<div class="col-md-8"><a onclick="addWholesalerVariant('+i+')" class="btn btn-sm yellow" style="margin-bottom: 2%">Add Wholesale Price</a></div>'+
                '</div>';
            html += '<div class="row" style="margin-bottom: 1%">' +
                '<div class="col-md-8" id="wholesaler_variant_'+i+'"></div>'+
                '</div>';
        }

        $('#variant_price').append(html);
        $('#data_variant_price').val(JSON.stringify( array_variant_price ) );
        $('#modalVariantPrice').modal('hide');
    }

    var j_variant = 0;
    function addWholesalerVariant(id){
        var html = '<div class="row" id="wholesaler_'+id+'_'+j_variant+'" style="margin-bottom: 0.5%">' +
            '<div class="col-md-4">Minimum<br><input type="text" class="form-control onlynumber" name="wholesaler_variant['+id+']['+j_variant+'][minimum]" required></div>'+
            '<div class="col-md-4">Price<br><input type="text" class="form-control onlynumber" name="wholesaler_variant['+id+']['+j_variant+'][unit_price]" required></div>'+
            '<div class="col-md-4"><br><a class="btn btn-danger" onclick="deleteWholesalerVariant('+id+','+j_variant+')"><i class="fa fa-trash"></i></a></div>'+
            '</div>';

        $('#wholesaler_variant_'+id).append(html);

        $('.onlynumber').keypress(function (e) {
            var regex = new RegExp("^[0-9]");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });
        j_variant++;
    }

    function deleteWholesalerVariant(id, id_2){
        $('#wholesaler_'+id+'_'+id_2).remove();
    }

    var j = 0;
    function addWholesaler(){
        var html = '<div class="row" id="wholesaler_'+j+'" style="margin-bottom: 0.5%">' +
            '<div class="col-md-4">Minimum<br><input type="text" class="form-control onlynumber" name="wholesaler['+j+'][minimum]"></div>'+
            '<div class="col-md-4">Price<br><input type="text" class="form-control onlynumber" name="wholesaler['+j+'][unit_price]"></div>'+
            '<div class="col-md-4"><br><a class="btn btn-danger" onclick="deleteWholesaler('+j+')"><i class="fa fa-trash"></i></a></div>'+
            '</div>';

        $('#wholesaler').append(html);

        $('.onlynumber').keypress(function (e) {
            var regex = new RegExp("^[0-9]");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });
        j++;
    }

    function deleteWholesaler(id){
        $('#wholesaler_'+id).remove();
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
                <span class="caption-subject sbold uppercase font-blue">New Product</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Outlet
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select name="id_outlet" class="form-control select2-multiple" data-placeholder="Select Outlet" required>
                                <option></option>
                                @foreach($outlets as $suw)
                                    <option value="{{ $suw['id_outlet'] }}">{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Main Image <span class="required" aria-required="true">* </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Utama" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                    <img src="" alt="">
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
                        <label for="multiple" class="control-label col-md-3">Category <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih Kategori Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <select id="multiple" class="form-control select2-multiple" name="id_product_category" data-placeholder="Select category" required>
                                    <option></option>
                                    @if (!empty($parent))
                                        @foreach($parent as $suw)
                                            @foreach ($suw['children']??[] as $child)
                                                <optgroup label="{{ $suw['product_category_name'] }} - {{ $child['product_category_name'] }}">
                                                    @foreach ($child['children']??[] as $subChild)
                                                        <option value="{{ $subChild['id_product_category'] }}">{{ $subChild['product_category_name'] }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="product_name" placeholder="Name" required>
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
                                        <input type="radio" id="radio_recipe1" name="need_recipe_status" class="md-radiobtn req-type" value="1" required>
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
                                        <input type="radio" id="radio_recipe2" name="need_recipe_status" class="md-radiobtn req-type" value="0" required checked>
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
                                        <input type="radio" id="radio1" name="product_visibility" class="md-radiobtn req-type" value="Visible" required checked>
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
                                        <input type="radio" id="radio2" name="product_visibility" class="md-radiobtn req-type" value="Hidden" required>
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
                        <label for="multiple" class="control-label col-md-3">Description
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <textarea name="product_description" id="pro_text" class="form-control" style="height: 100px"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Weight <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Berat Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control onlynumber" name="product_weight" placeholder="Weight" required>
                                <span class="input-group-addon">
										gram
									</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Length <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Panjang Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control onlynumber" name="product_length" placeholder="Length" required>
                                <span class="input-group-addon">
                                    cm
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Width <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Lebar Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control onlynumber" name="product_width" placeholder="Width" required>
                                <span class="input-group-addon">
                                    cm
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Height <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tinggi Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control onlynumber" name="product_height" placeholder="Height" required>
                                <span class="input-group-addon">
                                    cm
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="stock">
                        <label class="col-md-3 control-label">Stock <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Total jumlah produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control onlynumber" name="stock" placeholder="Stock" required>
                                <span class="input-group-addon">
                                    qty
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Base Price <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Base Price Product, jika memiliki variant maka harga base price akan diambil dari harga terendah variant" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    Rp
                                    </span>
                                    <input type="text" id="base_price" class="form-control price" name="base_price" placeholder="Base Price" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="div_wholesaler">
                        <label class="col-md-3 control-label">Wholesale Price
                            <i class="fa fa-question-circle tooltips" data-original-title="Set harga grosir" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <a onclick="addWholesaler()" class="btn btn-sm yellow" style="margin-bottom: 2%">Add Wholesale Price</a>
                            <div id="wholesaler">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Use Variant
                            <i class="fa fa-question-circle tooltips" data-original-title="Status penggunaan variant" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="icheck-list" style="margin-top: 1.5%">
                                <label><input type="checkbox" class="icheck" id="checkbox-variant" name="product_variant_status"> </label>
                            </div>
                        </div>
                    </div>

                    <div id="variants" style="display: none">
                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">Variant Color
                            </label>
                            <div class="col-md-8" id="variant_color" style="margin-top: 0.5%">
                                <a data-toggle="modal" href="#modalVariantColor" class="btn btn-sm green" style="margin-bottom: 1%">Add <i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">Variant Size
                            </label>
                            <div class="col-md-8" id="variant_size" style="margin-top: 0.5%">
                                <a data-toggle="modal" href="#modalVariantSize" class="btn btn-sm green" style="margin-bottom: 1%">Add <i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">Variant Price
                            </label>
                            <div class="col-md-8">
                                <a onclick="showVariantPrice()" class="btn btn-sm green" style="margin-bottom: 2%">Update Price & Stock</a>
                                <div id="variant_price">
                                </div>
                            </div>
                            <input type="hidden" id="data_variant_price" name="variants">
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

    <div class="modal fade" id="modalVariantColor" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">
                            Variant Color Name
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="variant_name_color" placeholder="Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <a class="btn green" onclick="addVariantColor()">Add</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVariantSize" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">
                            Variant Size Name
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="variant_name_size" placeholder="Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <a class="btn green" onclick="addVariantSize()">Add</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVariantPrice" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="modal_content_variant_price">

                </div>
                <div class="modal-footer" style="text-align: center">
                    <a class="btn green" onclick="variantUpdatePrice()">Update</a>
                </div>
            </div>
        </div>
    </div>
@endsection
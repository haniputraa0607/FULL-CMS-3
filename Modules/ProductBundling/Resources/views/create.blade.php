@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    
    <script type="text/javascript">
        $('#select_tag').change(function(){
			var value = $(this).val();
            console.log(value)
            if(value !== null){
                value.forEach(function(tag_selected,i){
                    if(tag_selected == '+'){
                        $('.bootstrap-select').removeClass('open')
                        $('#m_modal_5').modal('show');
                        value.splice (i, 1);
                    }
                })
                $('#select_tag').val(value)
                $('#select_tag').selectpicker('refresh')
            }
		})
    
        $('#close_modal').click(function(){
            var value = $('#select_tag').val();
            value.splice (0, 0);
            $('#select_tag').val(value)
            $('#select_tag').selectpicker('refresh')
        })

        $('.summernote').summernote({
            placeholder: 'Product Bundling Description',
            tabsize: 2,
            height: 120,
            toolbar: [
            ['style', ['style']],
            ['style', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['misc', ['fullscreen', 'codeview', 'help']]
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

        $(".file").change(function(e) {
            var widthImg  = 300;
            var heightImg = 300;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $(this).val("");
                        // $('#remove_square').click()
                        // image.src = _URL.createObjectURL();

                        $('#fieldphoto').val("");
                        $('#imageproduct').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
                        console.log($(this).val())
                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
    </script>

    <script>
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
    </script>

    <script>
        var oldProducts=[];
        function redrawProducts(list,selected,convertAll){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Products</option>";
            }
            list.forEach(function(product){
                html+="<option value=\""+product.id_product+"\">"+product.product_code+" - "+product.product_name+"</option>";
            });
            $('select[name="id_product[1]"]').html(html);
            $('select[name="id_product[1]"]').val(selected);
            if(convertAll && $('select[name="id_product[1]"]').val().length==list.length){
                $('select[name="id_product[1]"]').val(['all']);
            }
            oldProducts=list;
        }

        function redrawProductsAdd(list,selected,convertAll,rowId){
            var html="";
            console.log('its' + rowId)
            if(list.length){
                html+="<option value=\"all\">All Products</option>";
            }
            list.forEach(function(product){
                html+="<option value=\""+product.id_product+"\">"+product.product_code+" - "+product.product_name+"</option>";
            });
            $('select[name="id_product['+ rowId +']').html(html);
            $('select[name="id_product['+ rowId +']').val(selected);
            if(convertAll && $('select[name="id_product['+ rowId +']').val().length==list.length){
                $('select[name="id_product['+ rowId +']').val(['all']);
            }
            oldProducts=list;
        }

        $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

        $(document).ready(function() {
            $('select[name="id_brand"]').on('change',function(){
                console.log('test');
                var id_brand=$('select[name="id_brand"]').val();
                $.ajax({
                    url:"getAjax",
                    method: 'POST',
                    data: {
                        id_brand: $(this).val()
                    },
                    success: function(data){
                        if(data.status=='success'){
                            var value=$('select[name="id_product[]"]').val();
                            var convertAll=false;
                            if($('select[name="id_product[]"]').data('value')){
                                value=$('select[name="id_product[]"]').data('value');
                                $('select[name="id_product[]"]').data('value',false);
                                convertAll=true;
                            }
                            redrawProducts(data.result,value,convertAll);
                        }
                    }
                });
            });

            $('select[name="id_product[1]"]').on('change', function () {
                console.log('product_price');
                var id_product=$('select[name="id_product[1]"]').val();
                $.ajax({
                    url:"getAjax",
                    method: 'POST',
                    data: {
                        id_brand: $(this).val()
                    },
                    success: function(data){
                        if(data.status=='success'){
                            var value=$('select[name="id_product[]"]').val();
                            var convertAll=false;
                            if($('select[name="id_product[]"]').data('value')){
                                value=$('select[name="id_product[]"]').data('value');
                                $('select[name="id_product[]"]').data('value',false);
                                convertAll=true;
                            }
                            redrawProducts(data.result,value,convertAll);
                        }
                    }
                });
            });
        });
    </script>

    {{-- <script type="text/javascript">        
        var oldOutlet=[];
        function redrawOutlets(list,selected,convertAll){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if(convertAll&&$('select[name="id_outlet[]"]').val().length==list.length){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }
        $(document).ready(function() {
            $('select[name="id_brand"]').on('change',function(){
                var id_brand=$('select[name="id_brand"]').val();
                $.ajax({
                    url:"{{url('outlet/ajax_handler')}}",
                    method: 'GET',
                    data: {
                        select:['id_outlet','outlet_code','outlet_name'],
                        condition:{
                            rules:[
                                {
                                    subject:'id_brand',
                                    parameter:id_brand,
                                    operator:'=',
                                }
                            ],
                            operator:'and'
                        }
                    },
                    success: function(data){
                        if(data.status=='success'){
                            var value=$('select[name="id_outlet[]"]').val();
                            var convertAll=false;
                            if($('select[name="id_outlet[]"]').data('value')){
                                value=$('select[name="id_outlet[]"]').data('value');
                                $('select[name="id_outlet[]"]').data('value',false);
                                convertAll=true;
                            }
                            redrawProducts(data.result,value,convertAll);
                        }
                    }
                });
            });
            $('select[name="id_brand"]').change();
        });
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function(){      
            var postURL = "<?php echo url('addmore'); ?>";
            var i=1;

            $('#add-product').click(function(){  
                i++;
                $('#product-group').append(
                    '<div id="'+i+'">'+
                    '<hr>'+
                        '<div class="form-group">'+
                            '<div class="input-icon right">'+
                                '<label class="col-md-3 control-label">'+
                                'Brand'+
                                '<span class="required" aria-required="true"> * </span>'+
                                '<i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk deal ini" data-container="body"></i>'+
                                '</label>'+
                            '</div>'+
                            '<div class="col-md-8">'+
                                '<div class="input-icon right">'+
                                    '<select class="form-control select2-multiple id-brand" data-placeholder="Select Brand" name="id_brand" onchange="product.call(this)" required>'+
                                        '<option></option>'+
                                    '@if (!empty($brands))'+
                                        '@foreach($brands as $brand)'+
                                            '<option value="{{ $brand['id_brand'] }}" @if (old('id_brand')) @if($brand['id_brand'] == old('id_brand')) selected @endif @endif>{{ $brand['name_brand'] }}</option>'+
                                        '@endforeach'+
                                    '@endif'+
                                    '</select>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<div class="input-icon right">'+
                                '<label class="col-md-3 control-label">'+
                                'Product Available'+
                                '<span class="required" aria-required="true"> * </span>'+
                                '<i class="fa fa-question-circle tooltips" data-original-title="Masukkan product yang tersedia" data-container="body"></i>'+
                                '</label>'+
                            '</div>'+
                            '<div class="col-md-8">'+
                                '<select class="form-control select2-multiple" data-placeholder="Select Product" name="id_product['+ i +']" data-value="{{json_encode(old('id_outlet',[]))}}">'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<div class="input-icon right">'+
                                '<label class="col-md-3 control-label">'+
                                'Quantity'+
                                '<span class="required" aria-required="true"> * </span>'+
                                '<i class="fa fa-question-circle tooltips" data-original-title="Quantity untuk product yang dipilih" data-container="body"></i>'+
                                '</label>'+
                            '</div>'+
                            '<div class="col-md-2">'+
                                '<input type="number" class="form-control" name="user_limit" value="{{ old('user_limit') }}" placeholder="Qty" min="1">'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group" id="listVoucher" @if (old('voucher_code')) style="display: block;" @else style="display: none;" @endif>'+
                            '<label class="col-md-3 control-label"></label>'+
                            '<div class="col-md-8">'+
                                '<div class="col-md-3">'+
                                    '<label class="control-label">Values '+
                                        '<span class="required" aria-required="true"> * </span>'+ 
                                        '<small> (%) </small>'+
                                    '</label>'+
                                '</div>'+
                                '<div class="col-md-8">'+
                                    '<input type="number" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Masukkan nilai">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group" id="generateVoucher" @if (old('deals_total_voucher')) style="display: block;" @else style="display: none;" @endif>'+
                            '<label class="col-md-3 control-label"></label>'+
                            '<div class="col-md-8">'+
                                '<div class="col-md-3">'+
                                    '<label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>'+
                                '</div>'+
                                '<div class="col-md-8">'+
                                    '<input type="number" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Masukkan nilai">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<div class="input-icon right">'+
                                '<label class="col-md-3 control-label">'+
                                'Discount Type'+
                                '<span class="required" aria-required="true"> * </span>'+  
                                '<i class="fa fa-question-circle tooltips" data-original-title="Tipe discount yang dipilih (Fixed / Percentage)" data-container="body"></i>'+
                                '</label>'+
                            '</div>'+
                            '<div class="col-md-9">'+
                                '<div class="input-icon right">'+
                                    '<div class="col-md-3">'+
                                        '<div class="md-radio-inline">'+
                                            '<div class="md-radio">'+
                                                '<input type="radio" name="discount_type_'+ i +'" id="radio'+ i+1 +'" value="Auto generated" class="discountType" @if (old('deals_voucher_type') == "Auto generated") checked @endif>'+ 
                                                '<label for="radio'+ i+1 +'">'+
                                                '<span></span>'+
                                                '<span class="check"></span>'+
                                                '<span class="box"></span> Fixed </label>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<div class="md-radio-inline">'+
                                            '<div class="md-radio">'+
                                                '<input type="radio" name="discount_type_'+ i +'" id="radio'+ i+2 +'" value="List Vouchers" class="discountType" @if (old('deals_voucher_type') == "List Vouchers") checked @endif required>'+ 
                                                '<label for="radio'+ i+2 +'">'+
                                                '<span></span>'+
                                                '<span class="check"></span>'+
                                                '<span class="box"></span> Percentage </label>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+            
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group" id="listVoucher" @if (old('voucher_code')) style="display: block;" @else style="display: none;" @endif>'+
                            '<label class="col-md-3 control-label"></label>'+
                            '<div class="col-md-9">'+
                                '<div class="col-md-3">'+
                                    '<label class="control-label">Values'+ 
                                        '<span class="required" aria-required="true"> * </span>'+ 
                                        '<small> (%) </small>'+
                                    '</label>'+
                                '</div>'+
                                '<div class="col-md-9">'+
                                    '<input type="number" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Masukkan nilai">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group" id="generateVoucher" @if (old('deals_total_voucher')) style="display: block;" @else style="display: none;" @endif>'+
                            '<label class="col-md-3 control-label"></label>'+
                            '<div class="col-md-9">'+
                                '<div class="col-md-3">'+
                                    '<label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>'+
                                '</div>'+
                                '<div class="col-md-9">'+
                                    '<input type="number" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Masukkan nilai">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="col-md-3 control-label">Product Price<span class="required" aria-required="true"> * </span>'+
                                '<i class="fa fa-question-circle tooltips" data-original-title="Total Price" data-container="body"></i>'+
                            '</label>'+
                            '<div class="col-md-4">'+
                                '<div class="input-icon right">'+
                                    '<input type="text" placeholder="Price" class="form-control" name="price" value="{{ old('bundling_name') }}" required readonly>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Remove</button>'+    
                        '<hr>'+
                    '</div>'
                    );
                getScripts([
                    "http://janjijiwa-cust-view.test/assets/global/plugins/select2/js/select2.full.min.js",
                    "http://janjijiwa-cust-view.test/assets/pages/scripts/components-select2.min.js"
                ], function () {
                    console.log('script reloaded successfully!');
                });  
                discount();
            });  

            $(document).on('click', '.btn_remove', function(){
                if (confirm('Are you sure to delete this product?')) {
                    var button_id = $(this).attr("id");
                    var rowId =$(this).parent().parent().parent().parent().prop('id');
                    console.log(button_id);
                    $('#'+button_id+'').remove(); 
                }  
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit').click(function(){            
                $.ajax({  
                        url:postURL,  
                        method:"POST",  
                        data:$('#add_name').serialize(),
                        type:'json',
                        success:function(data)  
                        {
                            if(data.error){
                                printErrorMsg(data.error);
                            }else{
                                i=1;
                                $('.dynamic-added').remove();
                                $('#add_name')[0].reset();
                                $(".print-success-msg").find("ul").html('');
                                $(".print-success-msg").css('display','block');
                                $(".print-error-msg").css('display','none');
                                $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                            }
                        }  
                });  
            });  

            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $(".print-success-msg").css('display','none');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                });
            }
        });
    </script>

    <script>
        function getScripts(scripts, callback) {
            var progress = 0;
            scripts.forEach(function(script) { 
                $.getScript(script, function () {
                    if (++progress == scripts.length) callback();
                }); 
            });
        }

        function product(){
            var rowId =$(this).parent().parent().parent().parent().prop('id');
            //var rowId = $(this).closest("div[data-id]").attr('data-id');
            // var id_brand=$('select[name="id_brand"]').val();
            console.log(rowId);
            $.ajax({
                url:"getAjax",
                method: 'POST',
                data: {
                    id_brand: $(this).val()
                },
                success: function(data){                    
                    if(data.status=='success'){
                        var value=$('select[name="id_product['+ rowId +']"]').val();
                        var convertAll=false;
                        if($('select[name="id_product['+ rowId +']"]').data('value')){
                            value=$('select[name="id_product['+ rowId +']"]').data('value');
                            $('select[name="id_product['+ rowId +']"]').data('value',false);
                            convertAll=true;
                        }
                        redrawProductsAdd(data.result,value,convertAll,rowId);
                    }
                }
            });
        }

        function discount(){
            $('.discountType').click(function() {
                var nilai = $(this).val();

                if (nilai == "List Vouchers") {
                    $('#listVoucher').show();
                    $('.listVoucher').prop('required', true);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else if(nilai == "Unlimited") {
                    $('.generateVoucher').val('');
                    $('.listVoucher').val('');
                    $('.listVoucher').removeAttr('required');

                    $('#listVoucher').hide();
                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else {
                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                }
            });
        }
        
        discount();
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
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
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
                        <label class="col-md-3 control-label">
                            Photo <span class="required" aria-required="true">* <br>(200*200) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                <img src="https://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image" alt="">
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
                        <label for="multiple" class="control-label col-md-3">Description
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <textarea name="product_description" id="text_pro" class="form-control summernote">{{ old('product_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Bundling Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_start" value="{{ old('deals_start') }}" required>
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
                                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ old('deals_end') }}" required>
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
                    {{-- @include('productbundling::filter-bundling') --}}
                    <div id="product-group">
                        <div id="1">
                            <hr>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Brand
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk deal ini" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple id-brand1" data-placeholder="Select Brand" name="id_brand" required>
                                            <option></option>
                                        @if (!empty($brands))
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand['id_brand'] }}" @if (old('id_brand')) @if($brand['id_brand'] == old('id_brand')) selected @endif @endif>{{ $brand['name_brand'] }}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Product
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan product yang tersedia" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2-multiple" data-placeholder="Select Product" name="id_product[1]" data-value="{{json_encode(old('id_product',[]))}}">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Quantity
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Quantity untuk product yang dipilih" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="user_limit" value="{{ old('user_limit') }}" placeholder="Qty" min="1">
                                </div>
                            </div>
                            @include('productbundling::discount')
                            <div class="form-group">
                                <label class="col-md-3 control-label">Product Price<span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Total Price" data-container="body"></i>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Price" class="form-control" name="price" value="{{ old('bundling_name') }}" required readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <button type="button" id="add-product" class="btn blue">Add Product</button>
                    <hr>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Outlet Available
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Price<span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Total Price" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Price" class="form-control" name="price" value="{{ old('bundling_name') }}" required readonly>
                            </div>
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
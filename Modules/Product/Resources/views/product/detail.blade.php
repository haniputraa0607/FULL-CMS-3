<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{Cdn::asset('kk-ass/public/assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
    
@section('page-script')
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            $(".price").each(function() {
                var input = $(this).val();
                var input = input.replace(/[^[^0-9]\s\_\-]+/g, "");
                input = input ? parseFloat( input ) : 0;
                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "en", {minimumFractionDigits: 2} );
                } );
            });

            $('.summernote').summernote({
                placeholder: 'Product Description',
                tabsize: 2,
                height: 120,
                fontNames: ['Open Sans'],
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
                    },
                    error: function(data){
                    }
                })
            }

            // untuk show atau hide informasi photo
            if ($('.deteksi').data('dis') != 1) {
                $('.deteksi-trigger').hide();
            }
            else {
                $('.deteksi-trigger').show();
            }

            let token = "{{ csrf_token() }}";

            // sortable
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();

            // hapus gambar
            $('.hapus-gambar').click(function() {
                let id     = $(this).data('id');
                let parent = $(this).parent().parent().parent().parent();

                $.ajax({
                    type : "POST",
                    url : "{{ url('product/photo/delete') }}",
                    data : "_token="+token+"&id_product_photo="+id,
                    success : function(result) {
                        if (result == "success") {
                            parent.remove();
                            toastr.info("Photo has been deleted.");
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to delete photo.");
                        }
                    }
                });
            });

            $('.disc').click(function() {
                let type = $(this).data('type');
             
                if (type == "percentage") {
                    $('.'+type+'-div').show();
                    $('.'+type).prop('required', true);
                    $('.nominal-div').hide();
                    $('.nominal').removeAttr('required');
                    $('.nominal').val('');
                }
                else {
                    $('.'+type+'-div').show();
                    $('.'+type).prop('required', true);
                    $('.percentage-div').hide();
                    $('.percentage').removeAttr('required');   
                    $('.percentage').val('');
                }
            });
        });

        $( "#formWithPrice2" ).submit(function() {
			$( "#submit" ).attr("disabled", true);
			$( "#submit" ).addClass("m-loader m-loader--light m-loader--right");
			$( ".price" ).each(function() {
				var number = $( this ).val().replace(/[($)\s\,_\-]+/g, '');
				$(this).val(number);
			});

		});

		$( ".price" ).on( "keyup", numberFormat);
		$( ".price" ).on( "blur", checkFormat);

		function checkFormat(event){
			var data = $( this ).val().replace(/[($)\s\,_\-]+/g, '');
			if(!$.isNumeric(data)){
				$( this ).val("");
			}
		}

		function numberFormat(event){
			// When user select text in the document, also abort.
			var selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}
			// When the arrow keys are pressed, abort.
			if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
				return;
			}
			var $this = $( this );
			// Get the value.
			var input = $this.val();
			console.log(input)
			var input = input.replace(",", "");
			var input = input.replace(/[^[^0-9]\s\_\-]+/g, "");
			input = input ? parseFloat( input ) : 0;
			$this.val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString( "en" , {minimumFractionDigits: 2});
			} );
		}
    </script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete-disc', function() {
            let token  = "{{ csrf_token() }}";
            let column = $(this).parents('tr');
            let id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('product/discount/delete') }}",
                data : "_token="+token+"&id_product_discount="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Discount has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete discount.");
                    }
                }
            });
        });

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
                    //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageproduct').children('img').attr('src', 'http://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
                        $('#fieldphoto').val("");

                    }
                };
            
                image.src = _URL.createObjectURL(file);
            }

        });
        $('#select_tag').change(function(){
			var value = $(this).val();
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

		$('#new_tag').click(function(){
			var tag_name = $('#tag_name').val();
			var token  = "{{ csrf_token() }}";
            var tag_selected = $('#select_tag').val()
			$.ajax({
                type : "POST",
                url : "{{ url('product/tag/create') }}",
                data : "_token="+token+"&tag_name="+tag_name+"&ajax=1",
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("New tag has been created.");
						$('#option_new_tag').after(
							'<option value="'+result.result.id_tag+'">'+result.result.tag_name+'</option>'
						);
						$('#select_tag').selectpicker('refresh');
                        if(tag_selected !== null){
                            tag_selected.splice (0, 0, result.result.id_tag);
                            $('#select_tag').val(tag_selected)
                        }else{
                            $('#select_tag').val([result.result.id_tag])
                        }
                        $('#select_tag').selectpicker('refresh')
                    }
                    else if(result.status == "fail"){
                        toastr.error(result.messages[0]);
                    }else{
                        toastr.warning('Failed to create tag.');
                    }
                    $('#m_modal_5').modal('hide');
                }
            });
		})
    $('#close_modal').click(function(){
        var value = $('#select_tag').val();
        value.splice (0, 0);
        $('#select_tag').val(value)
        $('#select_tag').selectpicker('refresh')
	})
    </script>

<script type="text/javascript">
    $(document).on('click', '.same', function() {
      var price = $(this).parent().parent().parent().find('.product-price').val();
      var priceBase = $(this).parent().parent().parent().find('.product-price-base').val();
      var priceTax = $(this).parent().parent().parent().find('.product-price-tax').val();
      var visibility = $(this).parent().parent().parent().find('.product-visibility').val();
      var stock = $(this).parent().parent().parent().find('.product-stock').val();

      if (price == '') {
        alert('Price field cannot be empty');
        $(this).parent().parent().parent().find('.product').focus();
        return false;
      }

      if (priceBase == '') {
        alert('Price Base field cannot be empty');
        $(this).parent().parent().parent().find('.product-price-base').focus();
        return false;
      }

      if (priceTax == '') {
        alert('Price Tax field cannot be empty');
        $(this).parent().parent().parent().find('.product-price-tax').focus();
        return false;
      }

      if (visibility == '') {
        alert('Visibility field cannot be empty');
        $(this).parent().parent().parent().find('.product-price-tax').focus();
        return false;
      }

      if (stock == '') {
        alert('Stock field cannot be empty');
        $(this).parent().parent().parent().find('.product-price-tax').focus();
        return false;
      }
      
      if ($(this).is(':checked')) {
        var check = $('input[name="sameall[]"]:checked').length;
        var count = $('.same').prop('checked', false);
        $(this).prop('checked', true);

        if (check == 1) {
            var all_price = $('.product-price');
            var array_price = [];
            for (i = 0; i < all_price.length; i++) { 
                array_price.push(all_price[i]['defaultValue']);
            }
            sessionStorage.setItem("product_price", array_price);

            var all_price_base = $('.product-price-base');
            var array_price_base = [];
            for (i = 0; i < all_price_base.length; i++) { 
                array_price_base.push(all_price_base[i]['defaultValue']);
            }
            sessionStorage.setItem("product_price_base", array_price_base);

            var all_price_tax = $('.product-price-tax');
            var array_price_tax = [];
            for (i = 0; i < all_price_tax.length; i++) { 
                array_price_tax.push(all_price_tax[i]['defaultValue']);
            }
            sessionStorage.setItem("product_price_tax", array_price_tax);

            var all_visibility = $('.product-visibility-value');
            var array_visibility = [];
            for (i = 0; i < all_visibility.length; i++) { 
                array_visibility.push(all_visibility[i]['defaultValue']);
            }
            sessionStorage.setItem("product_visibility", array_visibility);

            var all_stock = $('.product-stock-value');
            var array_stock = [];
            for (i = 0; i < all_price.length; i++) { 
                array_stock.push(all_stock[i]['defaultValue']);
            }
            sessionStorage.setItem("product_stock", array_stock);

        }

        $('.product-price').val(price);
        $('.product-price-base').val(priceBase);
        $('.product-price-tax').val(priceTax);
        $('.product-visibility').val(visibility);
        $('.product-stock').val(stock);
        
      } else {

          var item_price = sessionStorage.getItem("product_price");
          var item_price_base = sessionStorage.getItem("product_price_base");
          var item_price_tax = sessionStorage.getItem("product_price_tax");
          var item_visibility = sessionStorage.getItem("product_visibility");
          var item_stock = sessionStorage.getItem("product_stock");

          var item_price = item_price.split(",");
          var item_price_base = item_price_base.split(",");
          var item_price_tax = item_price_tax.split(",");
          var item_visibility = item_visibility.split(",");
          var item_stock = item_stock.split(",");

          $('.product-price').each(function(i, obj) {
              $(this).val(item_price[i]);
          });
          $('.product-price-base').each(function(i, obj) {
              $(this).val(item_price_base[i]);
          });
          $('.product-price-tax').each(function(i, obj) {
              $(this).val(item_price_tax[i]);
          });
          $('.product-visibility').each(function(i, obj) {
              $(this).val(item_visibility[i]);
          });
          $('.product-stock').each(function(i, obj) {
              $(this).val(item_stock[i]);
          });
          console.log(item_visibility)

          $(this).parent().parent().parent().find('.product-price').val(price);
          $(this).parent().parent().parent().find('.product-price-base').val(priceBase);
          $(this).parent().parent().parent().find('.product-price-tax').val(priceTax);
          $(this).parent().parent().parent().find('.product-visibility').val(visibility);
          $(this).parent().parent().parent().find('.product-stock').val(stock);
      }
    });
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

    @php
        // print_r($product);die();
    @endphp

    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject bold uppercase font-blue">{{ $product[0]['product_name'] }}</span>
            </div>
            <ul class="nav nav-tabs">
                
                <li class="active">
                    <a href="#info" data-toggle="tab"> Info </a>
                </li>
                <!-- @if(MyHelper::hasAccess([53], $grantedFeature))
                    <li>
                        <a href="#photo" data-toggle="tab"> Photo </a>
                    </li>
                @endif -->
                <li>
                    <a href="#price" data-toggle="tab"> Outlet Setting </a>
                </li>
				<!-- <li>
                    <a href="#discount" data-toggle="tab"> Discount </a>
                </li> -->
            </ul>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @include('product::product.info')
                </div>
                <div class="tab-pane" id="photo">
                    @include('product::product.photo')
                </div>
				<div class="tab-pane" id="price">
                    @include('product::product.priceDetail')
                </div>
                <div class="tab-pane" id="discount">
                    @include('product::product.discount')
                </div>
            </div>
        </div>
    </div>
        
    
@endsection
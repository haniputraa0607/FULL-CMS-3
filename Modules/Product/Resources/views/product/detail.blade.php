<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ url('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
    
@section('page-script')
    <script src="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ url('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            $(".price").each(function() {
              var input = $(this).val();
              var input = input.replace(/[\D\s\._\-]+/g, "");
              input = input ? parseInt( input, 10 ) : 0;

              $(this).val( function() {
                  return ( input === 0 ) ? "" : input.toLocaleString( "id" );
              } );
            });
            
            $('.summernote').summernote({
                placeholder: 'Product Description',
                tabsize: 2,
                height: 120,
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
                       $('#formimage').submit()
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
                @if(MyHelper::hasAccess([53], $grantedFeature))
                    <li>
                        <a href="#photo" data-toggle="tab"> Photo </a>
                    </li>
                @endif
                <li>
                    <a href="#price" data-toggle="tab"> Outlet Setting </a>
                </li>
				<li>
                    <a href="#discount" data-toggle="tab"> Discount </a>
                </li>
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
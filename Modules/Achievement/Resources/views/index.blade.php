@extends('layouts.main')
@include('infinitescroll')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@yield('is-style')
    <style>
        .btn-group>.dropdown-menu{
            left: -100px;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@yield('is-script')
<script>
    template = {
        differentprice: function(item){
            return `
            <tr class="page${item.page}">
                <td class="text-center">${item.increment}</td>
                <td>${item.category_name}</td>
                <td>${item.name}</td>
                <td>${item.publish_start}</td>
                <td>${item.publish_end}</td>
                <td>${item.date_start}</td>
                <td>${item.date_end}</td>
                <td>
                    <div class="btn-group btn-group-solid pull-right">
                        <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div id="loadingBtn" hidden>
                                <i class="fa fa-spinner fa-spin"></i> Loading
                            </div>
                            <div id="moreBtn">
                                <i class="fa fa-ellipsis-horizontal"></i> More
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu">
                            <li style="margin: 0px;">
                                <a href="#editBadge" data-toggle="modal" onclick="editBadge(${item})"> Edit </a>
                            </li>
                            <li style="margin: 0px;">
                                <a href="{{url('achievement/detail/${item.id_achievement_group}')}}/"> Detail </a>
                            </li>
                            <li style="margin: 0px;">
                                <a href="javascript:;" onclick="removeAchievement(this, ${item.id_achievement_group})"> Remove </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            `;
        }
    };
    function removeAchievement(params, data) {
        var btn = $(params).parent().parent().parent().before().children()
        btn.find('#loadingBtn').show()
        btn.find('#moreBtn').hide()
        $.post( "{{ url('achievement/remove') }}", { id_achievement_group: data, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            console.log(data)
            if (data.status == 'success') {
                var removeDiv = $(params).parents()[4]
                removeDiv.remove()
            }
            btn.find('#loadingBtn').hide()
            btn.find('#moreBtn').show()
        });
    }
    function updater(table,response){
    }
    $(document).ready(function(){
        $('.is-container').on('change','.checkbox-different',function(){
            var status = $(this).is(':checked')?1:0;
            if($(this).data('auto')){
                $(this).data('auto',0);
            }else{
                const selector = $(this);
                $.post({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    url: "{{url('outlet/different-price/update')}}",
                    data: {
                        ajax: 1,
                        id_outlet: $(this).data('id'),
                        status: status
                    },
                    success: function(response){
                        selector.data('auto',1);
                        if(response.status == 'success'){
                            toastr.info("Update success");
                            if(response.result == '1'){
                                selector.prop('checked',true);
                            }else{
                                selector.prop('checked',false);
                            }
                        }else{
                            toastr.warning("Update fail");
                            if(status == 1){
                                selector.prop('checked',false);
                            }else{
                                selector.prop('checked',true);
                            }
                        }
                        selector.change();
                    },
                    error: function(data){
                        toastr.warning("Update fail");
                        selector.data('auto',1);
                        if(status == 1){
                            selector.prop('checked',false);
                        }else{
                            selector.prop('checked',true);
                        }
                        selector.change();
                    }
                });
            }
        });
    });
</script>
@endsection

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('achievement.name') !!}
    </p>
@endsection

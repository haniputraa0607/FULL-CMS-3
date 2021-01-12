<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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
    </div>
    <br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Product Bundling List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x:auto;">
                <table class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 100px"> Bundling ID </th>
                            <th style="width: 100px"> Name </th>
                            <th style="width: 100px"> Price Before Discount </th>
                            <th style="width: 100px"> Price After Discount </th>
                            <th style="width: 100px"> Brands </th>
                            <th style="width: 100px"> Product List </th>
                            <th style="width: 100px"> Bundling Start </th>
                            <th style="width: 100px"> Bundling End </th>
                            @if(MyHelper::hasAccess([291,292], $grantedFeature))
                                <th style="width: 100px"> Action </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @if (!empty($data))
                            @foreach($data as $value)
                                <tr>
                                    <td>{{ $value['bundling_code'] }}</td>
                                    <td>{{ $value['bundling_name'] }}</td>
                                    <td>{{ number_format($value['bundling_price_before_discount']) }}</td>
                                    <td>{{ number_format($value['bundling_price_after_discount']) }}</td>
                                    <td>
                                        <ul>
                                            @foreach($value['brands'] as $brands)
                                                <li>{{$brands['name_brand']}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul style="padding-left: 20px;">
                                            @foreach ($value['bundling_product'] as $item)
                                                <li>{{$item['product_name']}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ date('d M Y H:i', strtotime($value['start_date'])) }}</td>
                                    <td>{{ date('d M Y H:i', strtotime($value['end_date'])) }}</td>
                                    <td>
                                        @if(MyHelper::hasAccess([292], $grantedFeature))
                                            <a class="btn btn-sm green" href="{{url('product-bundling/detail', $value['id_bundling'])}}"><i class="fa fa-pencil"></i></a>
                                        @endif
                                        @if(MyHelper::hasAccess([291], $grantedFeature))
                                            <a class="btn btn-sm red" href=""><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="text-align: center"><td colspan="4">No Data Available</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection
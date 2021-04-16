<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
    $grantedFeature     = session('granted_features');
    date_default_timezone_set('Asia/Jakarta');
 ?>
                     <div class="row">
                        <div class="col-md-5">
                            <div class="portlet profile-info portlet light bordered">
                                <div class="portlet-title" style="display: flex;"> 
                                    <img src="{{$data['quest']['image']}}" style="width: 40px;height: 40px;" class="img-responsive" alt="">
                                    <span class="caption font-blue sbold uppercase">
                                        &nbsp;&nbsp;{{$data['quest']['name']}}
                                    </span>
                                </div>
                                <div class="portlet sale-summary">
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="sale-info"> Status 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                @if ($data['quest']['date_start'] < date('Y-m-d H:i:s') && $data['quest']['is_complete'])
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                                                @elseif (!is_null($data['quest']['date_end']) && $data['quest']['date_end'] > date('Y-m-d H:i:s') && $data['quest']['is_complete'])
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
                                                @else
                                                    <span class="sale-num sbold badge badge-pill secondary" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">Not Started</span>
                                                @endif
                                            </li>
                                            <li>
                                                <span class="sale-info"> Published at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['quest']['publish_start']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Publish end at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$data['quest']['publish_end'] ? date('d F Y H:i', strtotime($data['quest']['publish_end'])) : '-'}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Start at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['quest']['date_start']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> End at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$data['quest']['date_end'] ? date('d F Y H:i', strtotime($data['quest']['date_end'])) : '-'}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Created at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['quest']['created_at']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Short Description
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="{{$data['quest']['short_description'] ? '' : 'text-muted'}}">{{$data['quest']['short_description'] ?: 'No short description'}}</span>
                                            </li>
                                            <li>
                                                <span class="sale-info">Description
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                            </li>
                                            <li>
                                                {!!$data['quest']['description'] ?: '<span class="text-muted">No description</span>'!!}
                                            </li>
                                        </ul>
                                        @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
                                        <div class="text-center">
                                            <a data-toggle="modal" href="#modalEditQuest" class="btn btn-primary blue"><i class="fa fa-pencil"></i> Edit Quest</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="portlet profile-info portlet light bordered">
                                <div class="portlet-title" style="display: flex;"> 
                                    <span class="caption font-blue sbold uppercase">
                                        Quest Benefit
                                    </span>
                                </div>
                                <div class="portlet sale-summary">
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            @if($data['quest']['quest_benefit']['benefit_type'] == 'voucher')
                                            <li>
                                                <span class="sale-info"> Benefit Type
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    Voucher
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Voucher Qty
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{number_format($data['quest']['quest_benefit']['value'], 0, '.', ',')}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Deals
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$data['quest']['quest_benefit']['deals']['deals_title']}}
                                                </span>
                                            </li>
                                            @else
                                            <li>
                                                <span class="sale-info"> Benefit Type
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{env('POINT_NAME', 'Point')}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Point Nominal
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{\App\Lib\MyHelper::thousand_number_format($data['quest']['quest_benefit']['value'], '_CURRENCY')}}
                                                </span>
                                            </li>
                                            @endif
                                        </ul>
                                        @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
                                        <div class="text-center">
                                            <a data-toggle="modal" href="#modalEditBenefit" class="btn btn-primary blue"><i class="fa fa-pencil"></i> Edit Benefit</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 profile-info">
                            <div class="profile-info portlet light bordered">
                                <div class="portlet-title"> 
                                    <span class="caption font-blue sbold uppercase">{{$data['quest']['name']}} Badge </span>
                                    @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
                                    <a class="btn blue" style="float: right;" data-toggle="modal" href="#addBadge">Add Bagde</a>
                                    @endif
                                </div>
                                <div class="portlet-body row">
                                    @foreach ($data['quest']['quest_detail'] as $item)
                                    <div class="col-md-12 profile-info">
                                        <div class="profile-info portlet light bordered">
                                            <div class="portlet-title"> 
                                                <div class="col-md-6" style="display: flex;padding-left: 0px;">
                                                    <span class="caption font-blue sbold uppercase" style="padding: 8px 0px;font-size: 16px;">
                                                        {{$item['name']}}
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
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
                                                                <a href="#editBadge" data-toggle="modal" onclick="editBadge({{json_encode($item)}})"> Edit </a>
                                                            </li>
                                                            <li style="margin: 0px;">
                                                                <a href="javascript:;" onclick="removeBadge(this, {{$item['id_quest_detail']}})"> Remove </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row" style="padding: 5px;position: relative;">
                                                    <div class="col-md-12">
                                                        @if (!is_null($item['id_product_category']) || !is_null($item['different_category_product']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Product Category Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_product_category']))
                                                                    <div class="col-md-5 name">Product Category</div>
                                                                    <div class="col-md-7 value">: {{$item['product_category']['product_category_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['different_category_product']))
                                                                    <div class="col-md-5 name">Product Category Different ?</div>
                                                                    @if ($item['different_category_product'] == 0)
                                                                        <div class="col-md-7 value">: No</div>
                                                                    @else
                                                                        <div class="col-md-7 value">: Yes</div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_product']) || !is_null($item['product_total']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Product Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_product']))
                                                                    <div class="col-md-5 name">Product</div>
                                                                    <div class="col-md-7 value">: {{$item['product']['product_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['product_total']))
                                                                    <div class="col-md-5 name">Product Total</div>
                                                                    <div class="col-md-7 value">: {{$item['product_total']}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_outlet']) || !is_null($item['different_outlet']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Outlet Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_outlet']))
                                                                    <div class="col-md-5 name">Outlet</div>
                                                                    <div class="col-md-7 value">: {{$item['outlet']['outlet_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['different_outlet']))
                                                                    <div class="col-md-5 name">Outlet Different ?</div>
                                                                    @if ($item['different_outlet'] == 0)
                                                                        <div class="col-md-7 value">: No</div>
                                                                    @else
                                                                        <div class="col-md-7 value">: Yes</div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_province']) || !is_null($item['different_province']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Province Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_province']))
                                                                    <div class="col-md-5 name">Province</div>
                                                                    <div class="col-md-7 value">: {{$item['province']['province_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['different_province']))
                                                                    <div class="col-md-5 name">Province Different ?</div>
                                                                    @if ($item['different_province'] == 0)
                                                                        <div class="col-md-7 value">: No</div>
                                                                    @else
                                                                        <div class="col-md-7 value">: Yes</div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['trx_nominal']) || !is_null($item['trx_total']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Transaction Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['trx_nominal']))
                                                                    <div class="col-md-5 name">Transaction Nominal</div>
                                                                    <div class="col-md-7 value">: Minimum {{number_format($item['trx_nominal'])}}</div>
                                                                @endif
                                                                @if (!is_null($item['trx_total']))
                                                                    <div class="col-md-5 name">Transaction Total</div>
                                                                    <div class="col-md-7 value">: Minimum {{number_format($item['trx_total'])}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
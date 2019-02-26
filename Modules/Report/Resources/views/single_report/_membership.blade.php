<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption ">
            <span class="caption-subject sbold uppercase font-blue">Customer Membership</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">
            <div class="bg-grey-steel clearfix" style="padding-top: 15px; padding-bottom: 15px;">
                <div class="col-md-6">
                    <select class="form-control select2" id="trx_outlet" name="id_outlet">
                        <option value="0">All Memberships</option>
                        @foreach($memberships as $membership)
                            <option value="{{ $membership['id_membership'] }}">{{ $membership['membership_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        	{{-- Chart --}}
            <div style="margin-top: 30px;">
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_mem_1" data-toggle="tab">Total</a>
                        </li>
                        <li>
                            <a href="#tab_mem_2" data-toggle="tab">Gender</a>
                        </li>
                        <li>
                            <a href="#tab_mem_3" data-toggle="tab">Age</a>
                        </li>
                        <li>
                            <a href="#tab_mem_4" data-toggle="tab">Device</a>
                        </li>
                        <li>
                            <a href="#tab_mem_2" data-toggle="tab">Provider</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_mem_1">
                            <div id="mem_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_mem_2">
                            <div id="mem_gender_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_mem_3">
                            <div id="mem_age_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_mem_4">
                            <div id="mem_device_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_mem_5">
                            <div id="mem_provider_chart" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px">
                <b>Date Range: {{ $date_range }}</b>
            </div>

            {{-- Card --}}
            <div class="row cards" style="margin-top: 30px">
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-male"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['memberships']['mem_total_male'] }}</span> </div>
                                <div class="desc"> 
                                Total Male Customer
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-female"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['memberships']['mem_total_female'] }}</span> </div>
                                <div class="desc"> 
                                Total Female Customer
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-android"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['memberships']['mem_total_android'] }}</span> </div>
                                <div class="desc"> 
                                Total Android
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-ios"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['memberships']['mem_total_ios'] }}</span> </div>
                                <div class="desc"> 
                                Total iOS
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-wrapper" style="margin-top: 30px">
                <table class="table table-striped table-bordered table-hover table-checkable order-column">
                    <thead>
                        <tr>
                            <th> No </th>
                            <th> Date </th>
                            <th> Membership </th>
                            <th> Total </th>
                            <th> Male Customer </th>
                            <th> Female Customer </th>
                            <th> Android </th>
                            <th> iOS </th>
                            <th> Telkomsel </th>
                            <th> XL </th>
                            <th> Indosat </th>
                            <th> Tri </th>
                            <th> Axis </th>
                            <th> Smart </th>
                            <th> Teens </th>
                            <th> Young Adult </th>
                            <th> Adult </th>
                            <th> Old </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['memberships']['data'] as $key => $mem)
                        <tr class="odd gradeX">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $mem['date'] }}</td>
                            <td>{{ $mem['membership']['membership_name'] }}</td>
                            <td>{{ $mem['cust_total'] }}</td>
                            <td>{{ $mem['cust_male'] }}</td>
                            <td>{{ $mem['cust_female'] }}</td>
                            <td>{{ $mem['cust_android'] }}</td>
                            <td>{{ $mem['cust_ios'] }}</td>
                            <td>{{ $mem['cust_telkomsel'] }}</td>
                            <td>{{ $mem['cust_xl'] }}</td>
                            <td>{{ $mem['cust_indosat'] }}</td>
                            <td>{{ $mem['cust_tri'] }}</td>
                            <td>{{ $mem['cust_axis'] }}</td>
                            <td>{{ $mem['cust_smart'] }}</td>
                            <td>{{ $mem['cust_teens'] }}</td>
                            <td>{{ $mem['cust_young_adult'] }}</td>
                            <td>{{ $mem['cust_adult'] }}</td>
                            <td>{{ $mem['cust_old'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
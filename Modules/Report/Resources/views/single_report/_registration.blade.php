<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption ">
            <span class="caption-subject sbold uppercase font-blue">Customer Registration</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">
        	{{-- Chart --}}
            <div>
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_reg_1" data-toggle="tab">Gender</a>
                        </li>
                        <li>
                            <a href="#tab_reg_2" data-toggle="tab">Age</a>
                        </li>
                        <li>
                            <a href="#tab_reg_3" data-toggle="tab">Device</a>
                        </li>
                        <li>
                            <a href="#tab_reg_4" data-toggle="tab">Provider</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_reg_1">
                            <div id="reg_gender_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_reg_2">
                            <div id="reg_age_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_reg_3">
                            <div id="reg_device_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_reg_4">
                            <div id="reg_provider_chart" style="height:300px;"></div>
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
                                <span data-counter="counterup" data-value="0">{{ $report['registrations']['reg_total_male'] }}</span> </div>
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
                                <span data-counter="counterup" data-value="0">{{ $report['registrations']['reg_total_female'] }}</span> </div>
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
                                <span data-counter="counterup" data-value="0">{{ $report['registrations']['reg_total_android'] }}</span> </div>
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
                                <span data-counter="counterup" data-value="0">{{ $report['registrations']['reg_total_ios'] }}</span> </div>
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
                            <th> Reg Date </th>
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
                        @foreach($report['registrations']['data'] as $key => $reg)
                        <tr class="odd gradeX">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $reg['date'] }}</td>
                            <td>{{ $reg['cust_male'] }}</td>
                            <td>{{ $reg['cust_female'] }}</td>
                            <td>{{ $reg['cust_android'] }}</td>
                            <td>{{ $reg['cust_ios'] }}</td>
                            <td>{{ $reg['cust_telkomsel'] }}</td>
                            <td>{{ $reg['cust_xl'] }}</td>
                            <td>{{ $reg['cust_indosat'] }}</td>
                            <td>{{ $reg['cust_tri'] }}</td>
                            <td>{{ $reg['cust_axis'] }}</td>
                            <td>{{ $reg['cust_smart'] }}</td>
                            <td>{{ $reg['cust_teens'] }}</td>
                            <td>{{ $reg['cust_young_adult'] }}</td>
                            <td>{{ $reg['cust_adult'] }}</td>
                            <td>{{ $reg['cust_old'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($outlet as $key => $val)
    <div class="form-body">
        <h4>Info</h4>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Code
                <i class="fa fa-question-circle tooltips" data-original-title="Kode outlet bersifat unik" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_code" value="{{ $val['outlet_code'] }}" required placeholder="Outlet Code">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Name
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['outlet_name'] }}" required placeholder="Outlet Name">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Province
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="province" class="form-control select2-multiple" data-placeholder="Select Province" required>
                    <optgroup label="Province List">
                        <option value="">Select Province</option>
                        @if (!empty($province))
                            @foreach($province as $suw)
                                <option value="{{ $suw['id_province'] }}" @if ($suw['id_province'] == $val['city']['id_province']) selected @endif ) >{{ $suw['province_name'] }}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                City
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="city" class="form-control select2-multiple" data-placeholder="Select City" disabled required>
                    <optgroup label="Province List">
                        <option value="{{ $val['city']['city_name'] }}">{{ $val['city']['city_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Address
                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <textarea name="outlet_address" class="form-control" placeholder="Outlet Address">{{ $val['outlet_address'] }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Phone
                <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_phone" value="{{ $val['outlet_phone'] }}" placeholder="Outlet Phone">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Open Hour
                <i class="fa fa-question-circle tooltips" data-original-title="Jam buka outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="time" class="form-control" name="outlet_open_hours" value="@if(!empty($val['outlet_open_hours'])){{ date('H:i', strtotime($val['outlet_open_hours'])) }}@endif">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-clock-o"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-md-9">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Close Hour
                <i class="fa fa-question-circle tooltips" data-original-title="Jam tutup outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="time" class="form-control" name="outlet_close_hours" value="@if(!empty($val['outlet_close_hours'])){{ date('H:i', strtotime($val['outlet_close_hours'])) }}@endif">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-clock-o"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-md-9">
            </div>
        </div>

        <hr>
        <h4>Maps</h4>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3"></label>
            <div class="col-md-9">
                <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                <div id="map-canvas" style="width:900;height:380px;"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Latitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_latitude" value="{{ $val['outlet_latitude'] }}" id="lat" readonly>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Longitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_longitude" value="{{ $val['outlet_longitude'] }}" id="lng" readonly>
            </div>
        </div>

    </div>
    <div class="form-actions">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                @if(MyHelper::hasAccess([27], $grantedFeature))
                    <button type="submit" class="btn green">Submit</button>
                @endif
                <input type="hidden" name="id_city" id="id_city" value="{{ $val['city']['id_city'] }}">
                <input type="hidden" name="id_outlet" value="{{ $val['id_outlet'] }}">
                <!-- <button type="button" class="btn default">Cancel</button> -->
            </div>
        </div>
    </div>
    @endforeach
</form>
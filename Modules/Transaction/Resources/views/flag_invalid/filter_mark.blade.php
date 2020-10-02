<script>
    function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }
</script>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-blue ">
            <i class="icon-settings font-blue "></i>
            <span class="caption-subject bold uppercase">Filter</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">
            <div class="form-group">
                <div class="col-md-9" style="margin-left:2%;">
                    <div class="mt-radio-inline">
                        <label class="mt-radio">
                            <input type="radio" name="filter_type" id="optionFilterType1" value="receipt_number" @if((isset($filterType) && $filterType == 'receipt_number') || !isset($filter_type)) checked @endif> Receipt Number
                            <span></span>
                        </label>
                        <label class="mt-radio">
                            <input type="radio" name="filter_type" id="optionFilterType2" value="order_id" @if(isset($filterType) && $filterType == 'order_id') checked @endif> Order ID
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group mt-repeater">
                <div data-repeater-list="conditions">
                    @if (!empty($conditions))
                        @foreach ($conditions as $key => $con)
                            @if(isset($con['parameter']))
                                <div data-repeater-item class="mt-repeater-item mt-overflow">
                                    <div class="mt-repeater-cell">
                                        <div class="col-md-12">
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" placeholder="Parameter" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div data-repeater-item class="mt-repeater-item mt-overflow">
                                    <div class="mt-repeater-cell">
                                        <div class="col-md-12">
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" placeholder="Parameter" class="form-control" name="parameter" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div data-repeater-item class="mt-repeater-item mt-overflow">
                            <div class="mt-repeater-cell">
                                <div class="col-md-12">
                                    <div class="col-md-1">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" placeholder="Parameter" class="form-control" name="parameter" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-action" style="margin-top:15px;margin-left:3.6%;">
                    {{ csrf_field() }}
                    <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
                        <i class="fa fa-plus"></i> Add Parameter </a>
                    <a class="btn green" href="{{url()->current()}}">Reset</a>
                    <button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>
</div>
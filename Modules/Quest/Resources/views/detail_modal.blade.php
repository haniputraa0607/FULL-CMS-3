<div class="modal fade bs-modal-lg" id="addBadge" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 800px;">
        <form role="form" action="{{ url('quest/create') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add New Quest Rule</h4>
            </div>
            <div class="modal-body box-repeat" style="padding: 20ox;display: table;width: 100%;">
                <div class="box">
                    <div class="col-md-2 text-right" style="text-align: -webkit-right;">
                        <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Name
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="detail[0][name]" placeholder="Detail Quest" required maxlength="20">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Short Description
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Short Description" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="detail[0][short_description]" placeholder="Short Description" required maxlength="20">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Quest Category Product Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Category Product" name="detail[0][id_product_category]">
                                            <option></option>
                                            @foreach ($category as $item)
                                                <option value="{{$item['id_product_category']}}">{{$item['product_category_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[0][different_category_product]">
                                                <option></option>    
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Rule for different category product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Quest Product Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[0][id_product]">
                                            <option></option>
                                            @foreach ($product as $item)
                                                <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="detail[0][product_total]" placeholder="Total Product">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Quest Transaction Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control digit_mask" name="detail[0][trx_nominal]" placeholder="Transaction Nominal">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control digit_mask" name="detail[0][trx_total]" placeholder="Transaction Total">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Quest Outlet Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[0][id_outlet]">
                                            <option></option>
                                            @foreach ($outlet as $item)
                                                <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[0][different_outlet]">
                                                <option></option>    
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Rule for different outlet" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Quest Province Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a province. leave blank, if the quest is not based on the province" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Province" name="detail[0][id_province]">
                                            <option></option>
                                            @foreach ($province as $item)
                                                <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[0][different_province]">
                                                <option></option>    
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Rule for different province" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="btn-rmv form-action col-md-12 text-right">
                    <a href="javascript:;" class="btn btn-success addBox">
                        <i class="fa fa-plus"></i> Add New Input
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                {{ csrf_field() }}
                <input type="text" hidden name="id_quest" value="{{$data['quest']['id_quest']}}">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade bs-modal-lg" id="editBadge" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 700px;">
        <form role="form" action="{{ url('quest/update/detail') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Quest Rule</h4>
            </div>
            <div class="modal-body" style="padding: 20ox;display: table;width: 100%;">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" placeholder="Detail Quest" required maxlength="20">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Short Description
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Short Description" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="short_description" placeholder="Short Description" required maxlength="20">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Quest Category Product Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Category Product" name="id_product_category">
                                    <option></option>
                                    @foreach ($category as $item)
                                        <option value="{{$item['id_product_category']}}">{{$item['product_category_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <select class="form-control select2-multiple" data-placeholder="Different Rule" name="different_category_product">
                                        <option></option>    
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rule for different category product" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Quest Product Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Product" name="id_product">
                                    <option></option>
                                    @foreach ($product as $item)
                                        <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="product_total" placeholder="Total Product">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Quest Transaction Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask" name="trx_nominal" placeholder="Transaction Nominal">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask" name="trx_total" placeholder="Transaction Total">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Quest Outlet Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Product" name="id_outlet">
                                    <option></option>]
                                    @foreach ($outlet as $item)
                                        <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <select class="form-control select2-multiple" data-placeholder="Different Rule" name="different_outlet">
                                        <option></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rule for different outlet" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Quest Province Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Select a province. leave blank, if the quest is not based on the province" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Province" name="id_province">
                                    <option></option>
                                    @foreach ($province as $item)
                                        <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <select class="form-control select2-multiple" data-placeholder="Different Rule" name="different_province">
                                        <option></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rule for different province" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden name='id_quest_detail'>
                {{ csrf_field() }}
                <input type="text" name="id_quest_detail" hidden>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
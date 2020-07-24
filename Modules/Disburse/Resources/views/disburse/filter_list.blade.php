<script>
    function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }
    function changeSubject(val){
        var subject = val;
        var temp1 = subject.replace("conditions[", "");
        var index = temp1.replace("][subject]", "");
        var subject_value = document.getElementsByName(val)[0].value;

        if(subject_value == 'bank_name'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            <?php
                foreach($banks as $row){
                ?>
                operator_value.options[operator_value.options.length] = new Option('<?php echo $row['bank_name']; ?>', '<?php echo $row['id_bank_name']; ?>');
            <?php
                }
                ?>
            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        }else if(subject_value == 'status'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('Success', 'Success');
            operator_value.options[operator_value.options.length] = new Option('Queued', 'Queued');
            operator_value.options[operator_value.options.length] = new Option('Processed', 'Processed');
            operator_value.options[operator_value.options.length] = new Option('Fail', 'Fail');
            operator_value.options[operator_value.options.length] = new Option('Rejected', 'Rejected');
            operator_value.options[operator_value.options.length] = new Option('Approved', 'Approved');
            operator_value.options[operator_value.options.length] = new Option('Retry From Failed', 'Retry From Failed');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        }else{
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');
            operator_value.options[operator_value.options.length] = new Option('like', 'like');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'text';
        }
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
                <label class="col-md-2 control-label">Date Start :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_start" value="{{ $date_start }}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <label class="col-md-2 control-label">Date End :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_end" value="{{ $date_end }}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div><hr>

        <div class="form-body">
            <div class="form-group mt-repeater">
                <div data-repeater-list="conditions">
                    @if (!empty($conditions))
                        @foreach ($conditions as $key => $con)
                            @if(isset($con['subject']))
                                <div data-repeater-item class="mt-repeater-item mt-overflow">
                                    <div class="mt-repeater-cell">
                                        <div class="col-md-12">
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                                    <option value="outlet_code" @if ($con['subject'] == 'outlet_code') selected @endif>Outlet Code</option>
                                                    <option value="outlet_name" @if ($con['subject'] == 'outlet_name') selected @endif>Outlet Name</option>
                                                    <option value="bank_name" @if ($con['subject'] == 'bank_name') selected @endif>Bank</option>
                                                    <option value="account_number" @if ($con['subject'] == 'account_number') selected @endif>Account Number</option>
                                                    <option value="recipient_name" @if ($con['subject'] == 'recipient_name') selected @endif>Recipient Name</option>
                                                    @if($status == 'all')
                                                    <option value="status" @if ($con['subject'] == 'status') selected @endif>Status</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                    @if($con['subject'] == 'bank_name')
                                                        @foreach($banks as $val)
                                                            <option value="{{$val['id_bank_name']}}" @if ($con['operator'] == $val['id_bank_name']) selected @endif>{{$val['bank_name']}}</option>
                                                        @endforeach
                                                    @elseif($con['subject'] == 'status')
                                                        <option value="Success" @if ($con['operator']  == 'Success') selected @endif>Success</option>
                                                        <option value="Queued" @if ($con['operator']  == 'Queued') selected @endif>Queued</option>
                                                        <option value="Processed" @if ($con['operator']  == 'Processed') selected @endif>Processed</option>
                                                        <option value="Fail" @if ($con['operator']  == 'Fail') selected @endif>Fail</option>
                                                        <option value="Rejected" @if ($con['operator']  == 'Rejected') selected @endif>Rejected</option>
                                                        <option value="Approved" @if ($con['operator']  == 'Approved') selected @endif>Approved</option>
                                                        <option value="Approved" @if ($con['operator']  == 'Retry From Failed') selected @endif>Retry From Failed</option>
                                                    @else
                                                        <option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
                                                        <option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
                                                    @endif
                                                </select>
                                            </div>

                                            @if ($con['subject'] == 'bank_name' || $con['subject'] == 'status')
                                                <div class="col-md-3">
                                                    <input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                                </div>
                                            @else
                                                <div class="col-md-3">
                                                    <input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                                </div>
                                            @endif
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
                                            <div class="col-md-4">
                                                <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                                    <option value="" selected disabled>Search Subject</option>
                                                    <option value="outlet_code">Outlet Code</option>
                                                    <option value="outlet_name">Outlet Name</option>
                                                    <option value="bank_name">Bank</option>
                                                    <option value="account_number">Account Number</option>
                                                    <option value="recipient_name">Recipient Name</option>
                                                    @if($status == 'all')<option value="status">Status</option>@endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                    <option value="=" selected>=</option>
                                                    <option value="like">Like</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
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
                                    <div class="col-md-4">
                                        <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                            <option value="" selected disabled>Search Subject</option>
                                            <option value="outlet_code">Outlet Code</option>
                                            <option value="outlet_name">Outlet Name</option>
                                            <option value="bank_name">Bank</option>
                                            <option value="account_number">Account Number</option>
                                            <option value="recipient_name">Recipient Name</option>
                                            @if($status == 'all')<option value="status">Status</option>@endif
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                            <option value="=" selected>=</option>
                                            <option value="like">Like</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-action col-md-12">
                    <div class="col-md-12">
                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
                            <i class="fa fa-plus"></i> Add New Condition</a>
                    </div>
                </div>

                <div class="form-action col-md-12" style="margin-top:15px">
                    <div class="col-md-5">
                        <select name="rule" class="form-control input-sm " placeholder="Search Rule" required>
                            <option value="and" @if (isset($rule) && $rule == 'and') selected @endif>Valid when all conditions are met</option>
                            <option value="or" @if (isset($rule) && $rule == 'or') selected @endif>Valid when minimum one condition is met</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        {{ csrf_field() }}
                        <button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
                        <a class="btn green" href="{{url()->current()}}">Reset</a>
                        @if(!empty($disburse) && $status == 'success')
                            <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}?export=1">Export</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
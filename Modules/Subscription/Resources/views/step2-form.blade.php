<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
@section('step2')
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Subscription Price
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran subscription (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-left: 0px">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <select class="form-control" name="prices_by" required>
                                        <option value="" disabled @if (old('prices_by') == "" || (empty($subscription['is_free']) || empty($subscription['subscription_price_point']) || empty($subscription['subscription_price_cash']) ) ) selected @endif>Select Price</option>
                                        <option value="free" @if (old('prices_by') == "free" || !empty($subscription['is_free']) ) selected @endif>Free</option>
                                        @if(MyHelper::hasAccess([19], $configs))
                                        <option value="point" @if (old('prices_by') == "point" || !empty($subscription['subscription_price_point']) ) selected @endif>Point</option>
                                        @endif
                                        <option value="money" @if (old('prices_by') == "money" || !empty($subscription['subscription_price_cash']) ) selected @endif>Money</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="" id="prices" @if (old('prices_by')!='free' || !empty($subscription['subscription_price_cash']) || !empty($subscription['subscription_price_point']) ) style="display: block;" @elseif ((empty($subscription['subscription_price_cash']) && empty($subscription['subscription_price_point'])) ) style="display: none;" @else style="display: none;" @endif>
                                        <div class="">
                                            <div class=" payment" id="point"  @if (old('prices_by') != "money" || !empty($subscription['subscription_price_point'])) style="display: block;" @else style="display: none;" @endif>
                                                <div class="input-group">
                                                    <input type="text" class="form-control point moneyOpp freeOpp digit_mask" name="subscription_price_point" value="{{ old('subscription_price_point')??$subscription['subscription_price_point']??'' }}" placeholder="Input point nominal" autocomplete="off">
                                                    <div class="input-group-addon">Point</div>
                                                </div>
                                            </div>
                                            <div class="payment" id="money" @if (old('prices_by') != "point" && !empty($subscription['subscription_price_cash'])) style="display: block;" @else style="display: none;" @endif>
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="text" class="form-control money pointOpp freeOpp price" name="subscription_price_cash" value="{{ old('subscription_price_cash')??$subscription['subscription_price_cash']??'' }}" placeholder="Input money nominal" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Outlet Available
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan subscription tersebut" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}" required>
                                <optgroup label="Available Outlet">
                                    @if (!empty($outlets))
                                        @if ( old('id_outlet') )
                                            @if ( in_array('all', old('id_outlet')) )
                                                <option value="all" selected>All</option>
                                                @php
                                                    $gabungan = "";
                                                @endphp
                                                @foreach($outlets as $row)
                                                    @php
                                                        $gabungan = $gabungan."|".$row['id_outlet'];
                                                    @endphp
                                                    <option value="{{ $row['id_outlet'] }}">{{ $row['outlet_code'] }} - {{ $row['outlet_name'] }}</option>
                                                @endforeach
                                                <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                            @else
                                                <option value="all">All</option>
                                                @php
                                                    $outletPilihan = old('id_outlet');
                                                    $gabungan = "";
                                                @endphp
                                                @foreach($outlets as $row)
                                                    @php
                                                        $gabungan = $gabungan."|".$row['id_outlet'];
                                                    @endphp
                                                    <option value="{{ $row['id_outlet'] }}" @if (in_array($row['id_outlet'], $outletPilihan)) selected  @endif>{{ $row['outlet_code'] }} - {{ $row['outlet_name'] }}</option>
                                                @endforeach
                                                <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                            @endif
                                        @elseif (isset($subscription['is_all_outlet']) )
                                            <option value="all" selected>All</option>
                                            @php
                                                $gabungan = "";
                                            @endphp
                                            @foreach($outlets as $row)
                                                @php
                                                    $gabungan = $gabungan."|".$row['id_outlet'];
                                                @endphp
                                                <option value="{{ $row['id_outlet'] }}">{{ $row['outlet_code'] }} - {{ $row['outlet_name'] }}</option>
                                            @endforeach
                                            <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                        @else
                                            <option value="all">All</option>
                                            @php
                                                if( old('id_outlet') )
                                                {
                                                    $outletPilihan = old('id_outlet');
                                                }
                                                else
                                                {
                                                    $outletPilihan = array_pluck($subscription['outlets'], 'id_outlet');
                                                }
                                                $gabungan = "";
                                            @endphp
                                            @foreach($outlets as $row)
                                                @php
                                                    $gabungan = $gabungan."|".$row['id_outlet'];
                                                @endphp
                                                <option value="{{ $row['id_outlet'] }}" @if (in_array($row['id_outlet'], $outletPilihan)) selected  @endif>{{ $row['outlet_code'] }} - {{ $row['outlet_name'] }}</option>
                                            @endforeach
                                            <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                        @endif
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Subscription Total
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal pengguna yang dapat membeli subscription" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-left: 0px">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <select class="form-control" name="subscription_total_type" required>
                                        <option value="" disabled @if (old('subscription_total_type') == "" || empty($subscription['subscription_total'])) selected @endif>Select Total</option>
                                        <option value="limited" @if (old('subscription_total_type') == "limited" || !empty($subscription['subscription_total']) ) selected @endif>Limited</option>
                                        <option value="unlimited" @if (old('subscription_total_type') == "unlimited" || ( isset($subscription['subscription_total']) && $subscription['subscription_total'] == 0 && old('subscription_total_type') != "limited") ) selected @endif>Unlimited</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="" id="subscription-total-form" @if( old('subscription_total_type') != 'unlimited' && !empty($subscription['subscription_total']) ) style="display: block;" @else style="display: none;" @endif>
                                        <div class="" id="subscription-total-value">
                                            <div class="input-group">
                                                <input type="text" class="form-control digit_mask" name="subscription_total" value="{{ old('subscription_total')??$subscription['subscription_total']??'' }}" placeholder="Input subscription total" autocomplete="off">
                                                <div class="input-group-addon">Subscription</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            User Limit
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Batasan berapa kali pengguna dapat membeli lagi subscription yang sama, input 0 untuk unlimited" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="digit_mask form-control" name="user_limit" value="{{ old('user_limit')??$subscription['user_limit']??'' }}" placeholder="User limit" min="0" autocomplete="off">
                                    <div class="input-group-addon">User</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Start Date
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan, kosongkan bila voucher tidak memiliki minimal tanggal penggunaan" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="subscription_voucher_start" value="{{ ($start_date=old('subscription_voucher_start',$subscription['subscription_voucher_start']??0))?date('d-M-Y H:i',strtotime($start_date)):'' }}" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Expiry
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi subscription atau tanggal expirednya" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-left: 0px">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <select class="form-control" name="duration" required>
                                        <option value="" disabled @if (old('duration') == "" || (empty($subscription['subscription_voucher_expired']) && empty($subscription['subscription_voucher_duration']) ) ) selected @endif>Select Expiry</option>
                                        <option value="dates" @if (old('duration') == "dates" || !empty($subscription['subscription_voucher_expired']) && old('duration') != "duration") selected @endif>By Date</option>
                                        <option value="duration" @if (old('duration') == "duration" || !empty($subscription['subscription_voucher_duration']) && old('duration') != "dates") selected @endif>Duration</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="" id="times" @if ( empty($subscription['subscription_voucher_expired']) && empty($subscription['subscription_voucher_duration']) && old('duration')!='dates' && old('duration')!='duration') style="display: none;" @endif>
                                        <div class="">
                                            <div class="voucherTime" id="dates"  @if (!empty($subscription['subscription_voucher_expired']) && old('duration')=='duration') style="display: block;" @else style="display: none;" @endif>
                                                <div class="input-group">
                                                    <input type="text" class="form_datetime form-control dates durationOpp" name="subscription_voucher_expired" value="{{ old('subscription_voucher_expired') ? old('subscription_voucher_expired') : ((!empty($subscription['subscription_voucher_expired'])??false) ? date('d-M-Y H:i', strtotime($subscription['subscription_voucher_expired'])) : '') }}" autocomplete="off">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="voucherTime" id="duration" @if (!empty($subscription['subscription_voucher_duration']) && old('duration')=='dates' ) style="display: block;" @else style="display: none;" @endif>
                                                <div class="input-group">
                                                    <input type="text" class="form-control duration datesOpp digit_mask_min_1" name="subscription_voucher_duration" value="{{ old('subscription_voucher_duration')??$subscription['subscription_voucher_duration']??'' }}" autocomplete="off">
                                                    <span class="input-group-addon">
                                                        day after claimed
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Total
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal voucher yang dapat digunakan setelah membeli subscription. Minimal 1 voucher" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask_min_1" name="subscription_voucher_total" value="{{ old('subscription_voucher_total')??$subscription['subscription_voucher_total']??'' }}" placeholder="Subscription Voucher Total" autocomplete="off">
                                    <div class="input-group-addon">Voucher</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Discount Type
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe potongan harga dari voucher subscription (persen atau nominal)" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-left: 0px">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <select class="form-control" name="voucher_type" required>
                                        <option value="" disabled @if (old('voucher_type') == "" || (empty($subscription['subscription_voucher_percent']) && empty($subscription['subscription_voucher_nominal']) ) ) selected @endif>Select Type</option>
                                        <option value="percent" @if (old('voucher_type') == "percent" || !empty($subscription['subscription_voucher_percent']) ) selected @endif>Percent</option>
                                        <option value="cash" @if (old('voucher_type') == "cash" || !empty($subscription['subscription_voucher_nominal']) ) selected @endif>Nominal</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="" id="voucher-value" @if( empty($subscription['subscription_voucher_percent']) && empty($subscription['subscription_voucher_nominal']) && old('voucher_type') != 'percent' && old('voucher_type') != 'cash' ) style="display: none;" @endif>
                                        <div class="">
                                            <div class="col-md-4" id="voucher-percent" @if( !empty($subscription['subscription_voucher_percent']) && old('voucher_type') != 'cash')  style="display: block; padding-left: 0px" @else style="display: none; padding-left: 0px;" @endif style="padding-left: 0px;" >
                                                <div class="input-group">
                                                    <input type="text" class="form-control percent_mask " name="subscription_voucher_percent" value="{{ old('subscription_voucher_percent')??$subscription['subscription_voucher_percent']??'' }}" placeholder="Input Percent value" autocomplete="off">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                            </div>
                                            <div class="" id="voucher-cash" @if( !empty($subscription['subscription_voucher_nominal']) && old('voucher_type') != 'percent')  style="display: block;" @else style="display: none;" @endif>
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="text" class="form-control digit_mask" name="subscription_voucher_nominal" value="{{ old('subscription_voucher_nominal')??$subscription['subscription_voucher_nominal']??'' }}" placeholder="Input Cash nominal" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group" id="discount-max" @if( !empty($subscription['subscription_voucher_percent']) && old('voucher_type') != 'cash' ) style="display: block;" @else style="display: none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Discount Max
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah potongan maksimal yang bisa didapatkan. Jika jumlah potongan melebihi jumlah potongan maksimal, maka jumlah potongan yang didapatkan akan mengacu pada jumlah potongan maksimal." data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-left: 0px">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <select class="form-control" name="percent_max" required>
                                        <option value="true" @if (old('percent_max') == "true" || !empty($subscription['subscription_voucher_percent_max']) ) selected @endif>Yes</option>
                                        <option value="false" @if (old('percent_max') == "false" || empty($subscription['subscription_voucher_percent_max']) ) selected @endif>No</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="" id="discount-max-form" @if( !empty($subscription['subscription_voucher_percent_max']) && old('percent_max') !='true' )  style="display: block;" @else style="display: none;" @endif>
                                        <div class="">
                                            <div class="" id="discount-max-value">
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="text" class="form-control digit_mask" name="subscription_voucher_percent_max" value="{{ old('subscription_voucher_percent_max')??$subscription['subscription_voucher_percent_max']??'' }}" placeholder="Input discount max nominal" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Minimal Transaction
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah transaksi paling sedikit untuk bisa mendapatkan potongan dari subscription. kosongkan jika tidak ada minimal transaksi" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <div class="input-group-addon">IDR</div>
                                    <input type="text" class="form-control digit_mask" name="subscription_minimal_transaction" value="{{ old('subscription_minimal_transaction')??$subscription['subscription_minimal_transaction']??'' }}" placeholder="minimal transaction" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Daily Usage Limit
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah penggunaan voucher maksimal dalam satu hari, kosongkan jika tidak ada batas penggunaan" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask" name="daily_usage_limit" value="{{ old('daily_usage_limit')??$subscription['daily_usage_limit']??'' }}" placeholder="Daily Usage Limit" autocomplete="off">
                                    <div class="input-group-addon">Usage</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            New Purchase Limit
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Batas kapan pengguna dapat membeli lagi subscription yang sama" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-left: 0px">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <select class="form-control" name="purchase_limit" required>
                                        <option value="" disabled @if (old('purchase_limit') == "" || empty($subscription['new_purchase_after'])) selected @endif>Select Type</option>
                                        <option value="limit" @if (old('purchase_limit') == "limit" || (!empty($subscription['new_purchase_after']) && $subscription['new_purchase_after'] != 'No Limit') ) selected @endif>Limit</option>
                                        <option value="no_limit" @if (old('purchase_limit') == "no_limit" || (!empty($subscription['new_purchase_after']) && $subscription['new_purchase_after'] == 'No Limit') ) selected @endif>No Limit</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="new-purchase-after" @if( !empty($subscription['new_purchase_after']) && $subscription['new_purchase_after'] != 'No Limit' && old('purchase_limit') != 'limit' )  style="display: block;" @else style="display: none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            New Purchase After
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Pembelian baru dapat dilakukan lagi setelah subscription yang dibeli expired atau subscription voucher yang dibeli sudah habis" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-left: 0px">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <select class="form-control" name="new_purchase_after" @if( ($subscription['new_purchase_after']??'No Limit') != 'No Limit') required @endif>
                                        <option value="" disabled @if (old('new_purchase_after') == "" || empty($subscription['new_purchase_after'])) selected @endif>Select Type</option>
                                        <option value="Empty" @if (old('new_purchase_after') == "Empty" || (($subscription['new_purchase_after']??'') == 'Empty') ) selected @endif>Empty</option>
                                        <option value="expired" @if (old('new_purchase_after') == "expired" || (($subscription['new_purchase_after']??'') == 'Expired') ) selected @endif>Expired</option>
                                        <option value="Empty Expired" @if (old('new_purchase_after') == "Empty Expired" || (($subscription['new_purchase_after']??'') == 'Empty Expired') ) selected @endif>Empty/Expired</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
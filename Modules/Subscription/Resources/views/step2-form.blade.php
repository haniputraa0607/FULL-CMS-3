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
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="prices_by" id="radio6" value="free" class="prices md-radiobtn" required @if (old('prices_by') == "free" || (empty($subscription['subscription_price_cash']) || empty($subscription['subscription_price_point'])) ) checked @endif>
                                            <label for="radio6">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Free </label>
                                        </div>
                                    </div>
                                </div>
                                @if(MyHelper::hasAccess([19], $configs))
                                <div class="col-md-3">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" name="prices_by" id="radio7" value="point" class="prices md-radiobtn" required @if (old('prices_by') == "point" || !empty($subscription['subscription_price_point']) ) checked @endif>
                                                <label for="radio7">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Point </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="prices_by" id="radio8" value="money" class="prices md-radiobtn" required @if (old('prices_by') == "money" || !empty($subscription['subscription_price_cash']) ) checked @endif>
                                            <label for="radio8">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Money </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="prices" @if ((empty($subscription['subscription_price_cash']) && empty($subscription['subscription_price_point'])) ) style="display: none;" @elseif (old('prices_by')!='free' || !empty($subscription['subscription_price_cash']) || !empty($subscription['subscription_price_point']) ) style="display: block;" @else style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Nominal <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 payment" id="point"  @if (old('prices_by') == "point" || !empty($subscription['subscription_price_point'])) style="display: block;" @else style="display: none;" @endif>
                                <input type="text" class="form-control point moneyOpp freeOpp" name="subscription_price_point" value="{{ $subscription['subscription_price_point']??old('subscription_price_point') }}" placeholder="Input point nominal">
                            </div>
                            <div class="col-md-9 payment" id="money" @if (old('prices_by') == "money" || !empty($subscription['subscription_price_cash'])) style="display: block;" @else style="display: none;" @endif>
                                <input type="text" class="form-control money pointOpp freeOpp price" name="subscription_price_cash" value="{{ $subscription['subscription_price_cash']??old('subscription_price_cash') }}" placeholder="Input money nominal">
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
                        <div class="col-md-9" style="padding-right: 30px">
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}">
                                <optgroup label="Available Outlet">
                                    @if (!empty($outlets))
                                        <option></option>
                                        @if ( isset($subscription['is_all_outlet']) )
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
                                                $outletPilihan = array_pluck($subscription['outlets'], 'id_outlet');
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
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="subscription_total_type" id="radio13" value="limited" class="md-radiobtn" required @if (old('subscription_total_type') == "limited" || !empty($subscription['subscription_total']) ) checked @endif>
                                            <label for="radio13">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Limited </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="subscription_total_type" id="radio14" value="unlimited" class="md-radiobtn" required @if (old('subscription_total_type') == "unlimited" || empty($subscription['subscription_total'])) checked @endif>
                                            <label for="radio14">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Unlimited </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="subscription-total-form" @if( empty($subscription['subscription_total']) ) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Value <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="subscription-total-value">
                                <input type="text" class="form-control" name="subscription_total" value="{{ $subscription['subscription_total']??old('subscription_total') }}" placeholder="Input subscription total">
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
                                <input type="number" class="form-control" name="user_limit" value="{{ $subscription['user_limit']??old('user_limit') }}" placeholder="User limit" min="0">
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
                                    <input type="text" class="form_datetime form-control" name="subscription_voucher_start" value="{{ ($start_date=old('subscription_voucher_start',$subscription['subscription_voucher_start']??0))?date('d-M-Y H:i',strtotime($start_date)):'' }}" >
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
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="duration" id="radio17" value="dates" class="expiry md-radiobtn" required @if (!empty($subscription['subscription_voucher_expired'])) checked @endif>
                                            <label for="radio17">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> By Date </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="duration" id="radio18" value="duration" class="expiry md-radiobtn" required @if (!empty($subscription['subscription_voucher_duration'])) checked @endif>
                                            <label for="radio18">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Duration </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="times" @if (empty($subscription['subscription_voucher_expired']) && empty($subscription['subscription_voucher_duration'])) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 voucherTime" id="dates"  @if (empty($subscription['subscription_voucher_expired'])) style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control dates durationOpp" name="subscription_voucher_expired" value="{{ !empty($subscription['subscription_voucher_expired'])??0 ? date('d-M-Y H:i', strtotime($subscription['subscription_voucher_expired'])) : old('subscription_voucher_expired') }}" >
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 voucherTime" id="duration" @if (empty($subscription['subscription_voucher_duration'])) style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control duration datesOpp" name="subscription_voucher_duration" value="{{ $subscription['subscription_voucher_duration']??'' }}">
                                    <span class="input-group-addon">
                                        day after claimed
                                    </span>
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
                                <input type="number" class="form-control" name="subscription_voucher_total" value="{{ $subscription['subscription_voucher_total']??old('subscription_voucher_total') }}" placeholder="Subscription Voucher Total" min="1">
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
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="voucher_type" id="radio9" value="percent" class="md-radiobtn" required @if (old('voucher_type') == "percent" || !empty($subscription['subscription_voucher_percent'])) checked @endif>
                                            <label for="radio9">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Percent </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="voucher_type" id="radio10" value="cash" class="md-radiobtn" required @if (old('voucher_type') == "cash" || !empty($subscription['subscription_voucher_nominal'])) checked @endif>
                                            <label for="radio10">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Cash </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="voucher-value" @if( empty($subscription['subscription_voucher_percent']) && empty($subscription['subscription_voucher_nominal']) ) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Value <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="voucher-percent" @if( empty($subscription['subscription_voucher_percent']) ) style="display: none;" @endif>
                                <input type="text" class="form-control " name="subscription_voucher_percent" value="{{ $subscription['subscription_voucher_percent']??old('subscription_voucher_percent') }}" placeholder="Input Percent value">
                            </div>
                            <div class="col-md-9" id="voucher-cash" @if( empty($subscription['subscription_voucher_nominal']) ) style="display: none;" @endif>
                                <input type="text" class="form-control " name="subscription_voucher_nominal" value="{{ $subscription['subscription_voucher_nominal']??old('subscription_voucher_nominal') }}" placeholder="Input Cash nominal">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="discount-max" @if( empty($subscription['subscription_voucher_percent']) ) style="display: none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Discount Max
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah potongan maksimal yang bisa didapatkan. Jika jumlah potongan melebihi jumlah potongan maksimal, maka jumlah potongan yang didapatkan akan mengacu pada jumlah potongan maksimal." data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="percent_max" id="radio11" value="true" class="md-radiobtn" required @if (old('percent_max') == "true" || !empty($subscription['subscription_voucher_percent_max']) ) checked @endif>
                                            <label for="radio11">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Yes </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="percent_max" id="radio12" value="false" class="md-radiobtn" required @if (old('percent_max') == "false" || empty($subscription['subscription_voucher_percent_max']) ) checked @endif>
                                            <label for="radio12">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> No </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="discount-max-form" @if( empty($subscription['subscription_voucher_percent_max']) ) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Nominal <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="discount-max-value">
                                <input type="text" class="form-control" name="subscription_voucher_percent_max" value="{{ $subscription['subscription_voucher_percent_max']??old('subscription_voucher_percent_max') }}" placeholder="Input discount max nominal">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Minimal Transaction
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah transaksi paling sedikit untuk bisa mendapatkan potongan dari subscription" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" name="subscription_minimal_transaction" value="{{ $subscription['subscription_minimal_transaction']??old('subscription_minimal_transaction') }}" placeholder="minimal transaction" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Daily Usage Limit
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah penggunaan voucher maksimal dalam satu hari" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" name="daily_usage_limit" value="{{ $subscription['daily_usage_limit']??old('daily_usage_limit') }}" placeholder="Daily Usage Limit" min="0">
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
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="purchase_limit" id="radio15" value="limit" class="md-radiobtn" required @if (old('purchase_limit') == "limit" || !empty($subscription['new_purchase_after']) ) checked @endif>
                                            <label for="radio15">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Limit </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="purchase_limit" id="radio16" value="no_limit" class="md-radiobtn" required @if (old('purchase_limit') == "no_limit" || empty($subscription['new_purchase_after'])) checked @endif>
                                            <label for="radio16">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> No Limit </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="new-purchase-after" @if( empty($subscription['new_purchase_after']) ) style="display: none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            New Purchase After
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Pembelian baru dapat dilakukan lagi setelah subscription yang dibeli expired atau subscription voucher yang dibeli sudah habis" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="new_purchase_after" id="radio19" value="empty" class="md-radiobtn" @if (old('new_purchase_after') == "Empty" || (($subscription['new_purchase_after']??'') == 'Empty') ) checked @endif>
                                            <label for="radio19">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Voucher Run Out </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="new_purchase_after" id="radio20" value="expired" class="md-radiobtn" @if (old('new_purchase_after') == "expired" || (($subscription['new_purchase_after']??'') == 'Expired')) checked @endif>
                                            <label for="radio20">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Voucher Expired </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
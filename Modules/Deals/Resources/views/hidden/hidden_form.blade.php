<!-- 
<br>
<div class="form-group">
    <label class="col-md-3 control-label">Voucher Price <span class="required" aria-required="true"> * </span> </label>
    <div class="col-md-3">
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="prices_by" id="optionsRadios6" value="free" class="prices" required @if (old('prices_by') == "free") checked @endif> Free
                <span></span>
            </label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="prices_by" id="optionsRadios7" value="point" class="prices" required @if (old('prices_by') == "point") checked @endif> Point
                <span></span>
            </label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="prices_by" id="optionsRadios8" value="money" class="prices" required @if (old('prices_by') == "money") checked @endif> Money
                <span></span>
            </label>
      </div>
    </div>
</div>

<div class="form-group" id="prices" @if (old('prices_by')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9 payment" id="point"  @if (old('prices_by') == "point") style="display: block;" @else style="display: none;" @endif>
            <input type="text" class="form-control point moneyOpp freeOpp" name="deals_voucher_price_point" value="{{ old('deals_voucher_price_point') }}" placeholder="Input point values">
        </div>
        <div class="col-md-9 payment" id="money" @if (old('prices_by') == "money") style="display: block;" @else style="display: none;" @endif>
            <input type="text" class="form-control money pointOpp freeOpp" name="deals_voucher_price_cash" value="{{ old('deals_voucher_price_cash') }}" placeholder="Input money values">
        </div>
    </div>
</div>
 -->
<br>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Expiry  
        <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required @if (old('duration') == "dates") checked @endif>
                        <label for="radio9">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> By Date </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required @if (old('duration') == "duration") checked @endif>
                        <label for="radio10">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Duration </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="times"  @if (old('duration')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9 voucherTime" id="dates" @if (old('duration') == "dates") style="display: block;" @else style="display: none;" @endif>
            <div class="input-group">
                <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" value="{{ old('deals_voucher_expired') }}">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-md-9 voucherTime" id="duration" @if (old('duration') == "duration") style="display: block;" @else style="display: none;" @endif>
            <input type="number" class="form-control duration datesOpp" name="deals_voucher_duration" value="{{ old('deals_voucher_duration') }}" placeholder="in day">
        </div>
    </div>
</div>
<input type="hidden" name="deals_voucher_type" value="Auto generated">
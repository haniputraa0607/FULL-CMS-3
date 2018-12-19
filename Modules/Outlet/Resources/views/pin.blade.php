<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <h4>Update PIN</h4>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                New PIN
                <i class="fa fa-question-circle tooltips" data-original-title="Pin outlet berupa 6 digit angka" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="password" class="form-control" name="outlet_pin" required placeholder="New Outlet PIN">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Re-type New PIN
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan pin yang baru dibuat" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="password" class="form-control" name="outlet_pin_confirmation" required placeholder="Re-type New PIN">
            </div>
        </div>
    </div>
    <div class="form-actions">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                @if(MyHelper::hasAccess([27], $grantedFeature))
                    <button type="submit" class="btn green">Update PIN</button>
                @endif
                <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
            </div>
        </div>
    </div>
</form>
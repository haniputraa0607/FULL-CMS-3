<?php

namespace Modules\Voucher\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class WebviewVoucherController extends Controller
{
    public function voucherDetail(Request $request, $id_deals_user)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $post['id_deals_user'] = $id_deals_user;
        $post['used'] = 0;
        
        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me?log_save=0', $post, $bearer));
        
        return view('voucher::webview.voucher_detail_v3', $data);
    }

    public function voucherDetailV2(Request $request, $id_deals_user)
    {
    	$bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $post['id_deals_user'] = $id_deals_user;
        $post['used'] = 0;
        
        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me?log_save=0', $post, $bearer));
        
        return view('voucher::webview.voucher_detail_v4', $data);
    }

    // display detail voucher after used
    public function voucherUsed(Request $request, $id_deals_user)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $post['id_deals_user'] = $id_deals_user;
        $post['used'] = 1;
        
        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me?log_save=0', $post, $bearer));
        
        return view('voucher::webview.voucher_detail', $data);
    }
}

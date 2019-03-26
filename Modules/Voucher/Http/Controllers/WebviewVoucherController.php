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
        
        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me', $post, $bearer));
        $data['bearer'] = $bearer;
        $data['id_deals_user'] = $id_deals_user;
        
        return view('voucher::webview.voucher_detail', $data);
    }

    // invalidate
    public function voucherInvalidate(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        if (isset($request->bearer) && isset($request->id_deals_user)) {
            $post['id_deals_user'] = $request->id_deals_user;
            $post['used'] = 0;
            
            $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me', $post, $bearer));
            $data['bearer'] = $bearer;
        }
        
        return view('voucher::webview.voucher_detail', $data);
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
        
        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me', $post, $bearer));
        
        return view('voucher::webview.voucher_detail', $data);
    }
}

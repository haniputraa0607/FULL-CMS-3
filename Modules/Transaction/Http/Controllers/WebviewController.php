<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class WebviewController extends Controller
{

    public function detail(Request $request)
    {
        $bearer = $request->header('Authorization');
        $bearer = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjNhNzE1Zjg2N2E2NTFlMWY5MmRkZGExMTczNDJjYTBiOTllMTVkZDgzZjU1N2RjYzBkNGU4NTAyZWZlOTJmYTM5ZDQ5Mzk3ZmExMTNlODdhIn0.eyJhdWQiOiIyIiwianRpIjoiM2E3MTVmODY3YTY1MWUxZjkyZGRkYTExNzM0MmNhMGI5OWUxNWRkODNmNTU3ZGNjMGQ0ZTg1MDJlZmU5MmZhMzlkNDkzOTdmYTExM2U4N2EiLCJpYXQiOjE1Njg5NDkzMDQsIm5iZiI6MTU2ODk0OTMwNCwiZXhwIjoyODY0OTQ5MzAyLCJzdWIiOiI4Iiwic2NvcGVzIjpbIioiXX0.pmeZ4vXGP56GWL_AHB5Roc258ubrbsE1xmVV-iN8wWFuDILC5iF4PeIH994EGqH2xcsKl5b7rkiaNWHSYLEXM_SGoFB8WThwNJPxVh-InlaUgZJjg1_U5Ahc_fW9n3U95azBhxW0wcEbvjtqrAFgl97mNAAoGE3rcBCxIPlF7OMLO76T18w7pgFQDoEulaSZQvTOao5R4hOR8U5-NoBJYMg1lNJ9ZUl8rhOWmax0dMe23UYseMNnf_xFiABoPe0STfHMg296DGiXBo1uVnyOwmm9MXqdk40WFXgpkEnpva0XyLOPBMtASrZoZJT0YVAMxvOeNRYj47yzVRpTTNx-A5efp01kJcbPq5iTih8dq12UUsYDM00Eu9lSNyVCTRQGRFi4KY5Em4JHJ1yJXQRldlOJq2EmbwsAkaQXVdbYvzXwpldpmOkW4mYtg5TlyeSk13U_3yYWy9Oix7e3o2VL9u6RvXOxdIwv2GYlz08EUvYVXcW6i13LyrNNCmoWFlimMPw9qLFjuUpBabvVryVs1G_ftu_8ZQ6D7ut5wXHNxf9ShZoxAsz7PCrjke48pQ_eVktxOD46n6R-pnRdlesgFw6X0tN32hs1wEWfvDLbAYbhhLb6GQDPctS9vDBwyYBwvhoOKEbRQg_4YAvXCpLKQ41rdGeRxnP9-37avnQDyJY";
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        // if ($request->isMethod('get')) {
        //     return view('error', ['msg' => 'Url method is POST']);
        // }

        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::postWithBearer('transaction/detail/webview?log_save=0', $data, $bearer);
        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if ($data['kind'] == 'Delivery') {
            $view = 'detail_transaction_deliv';
        }

        if ($data['kind'] == 'Pickup Order' || $data['kind'] == 'Offline') {
            $view = 'detail_transaction_pickup';
        }

        // 	if ($data['kind'] == 'Offline') {
        // 		$view = 'detail_transaction_off';
        // 	}

        if ($data['kind'] == 'Voucher') {
            $view = 'detail_transaction_voucher';
        }

        if (isset($data['success'])) {
            $view = 'transaction_success';
        }

        if (isset($data['transaction_payment_status']) && $data['transaction_payment_status'] == 'Pending') {
            $view = 'transaction_proccess';
            // if (isset($data['data_payment'])) {
            //     foreach ($data['data_payment'] as $key => $value) {
            //         if ($value['type'] != 'Midtrans') {
            //             continue;
            //         } else {
            //             if (!isset($value['signature_key'])) {
            //                 $view = 'transaction_pending';
            //             }
            //         }
            //     }
            // }
        }

        if (isset($data['transaction_payment_status']) && $data['transaction_payment_status'] == 'Cancelled') {
            $view = 'transaction_failed';
        }

        if (isset($data['order_label_v2'])) {
            $data['order_label_v2'] = explode(',', $data['order_label_v2']);
            $data['order_v2'] = explode(',', $data['order_v2']);
        }
        return view('transaction::webview.' . $view . '')->with(compact('data'));
    }

    public function outletSuccess(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        // if ($request->isMethod('get')) {
        //     return view('error', ['msg' => 'Url method is POST']);
        // }

        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::postWithBearer('outletapp/order/detail/view?log_save=0', $data, $bearer);
        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if (isset($data['order_label_v2'])) {
            $data['order_label_v2'] = explode(',', $data['order_label_v2']);
            $data['order_v2'] = explode(',', $data['order_v2']);
        }
        return view('transaction::webview.outlet_app')->with(compact('data'));
    }

    public function detailPoint(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        // if ($request->isMethod('get')) {
        //     return view('error', ['msg' => 'Url method is POST']);
        // }

        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::postWithBearer('transaction/detail/webview/point?log_save=0', $data, $bearer);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if ($data['type'] == 'trx') {
            $view = 'detail_point_online';
        }

        if ($data['type'] == 'voucher') {
            $view = 'detail_point_voucher';
        }

        return view('transaction::webview.' . $view . '')->with(compact('data'));
    }

    public function detailBalance(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        // if ($request->isMethod('get')) {
        //     return view('error', ['msg' => 'Url method is POST']);
        // }

        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::postWithBearer('transaction/detail/webview/balance?log_save=0', $data, $bearer);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if ($data['type'] == 'trx') {
            $view = 'detail_balance_online';
        }

        if ($data['type'] == 'voucher') {
            $view = 'detail_balance_voucher';
        }

        return view('transaction::webview.' . $view . '')->with(compact('data'));
    }

    public function success()
    {
        return view('transaction::webview.transaction_success');
    }

    public function receiptOutletapp(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        // if ($request->isMethod('get')) {
        //     return view('error', ['msg' => 'Url method is POST']);
        // }

        $data = json_decode(base64_decode($request->get('data')), true);
        $check = MyHelper::postWithBearer('outletapp/order/detail/view?log_save=0', $data, $bearer);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        // return $data;

        return view('transaction::webview.receipt-outletapp')->with(compact('data'));
    }
}

<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class WebviewController extends Controller
{
    public function check(Request $request)
    {
        $post = $request->except('_token');
        $count = 0;
        $messages = '';

        while ($count <= 10) {
            $check = MyHelper::post('transaction/detail/webview', $post);
            if (isset($check['status']) && $check['status'] == 'success') {
                foreach ($check['result']['data_payment'] as $key => $value) {
                    if ($value['type'] == 'Midtrans') {
                        if ($value['payment_type'] == 'Bank Transfer' || $value['payment_type'] == 'Echannel' || $value['payment_type'] == 'Cstore') {
                            if (empty($value['eci'])) {
                                $count++;
                                $messages = 'Data not found';
                            } else {
                                $count = 11;
                                if (isset($value['store'])) {
                                    return '<div class="col-12 roboto-regular-font text-15px space-text text-grey">Virtual Number</div>
                                        <div class="col-12 text-greyish-brown text-21-7px space-bottom space-top-all seravek-medium-font"><span id="myInput">'.$value['eci'].'</span> &nbsp; 
                                            <i class="fa fa-clone clone" data-togle="tooltip" title="Hooray!" onclick="copyToClipboard(\'#myInput\')" style="cursor: pointer;"><div id="popover" rel="popover" data-content="Copied to clipboard" data-original-title="Copied"></div></i>
                                        </div>
                                        <div class="col-12 text-16-7px text-black space-text seravek-light-font">'.strtoupper($value['store']).'</div>';
                                }
                                if ($value['bank'] == 'Mandiri') {
                                    return '<div class="col-12 roboto-regular-font text-15px space-text text-grey">Virtual Number</div>
                                        <div class="col-12 text-greyish-brown text-21-7px space-bottom space-top-all seravek-medium-font"><span id="myInput">'.substr($value['eci'], 5).'</span> <span>('.substr($value['eci'], 0, 5).')</span> &nbsp; 
                                            <i class="fa fa-clone clone" data-togle="tooltip" title="Hooray!" onclick="copyToClipboard(\'#myInput\')" style="cursor: pointer;"><div id="popover" rel="popover" data-content="Copied to clipboard" data-original-title="Copied"></div></i>
                                        </div>
                                        <div class="col-12 text-16-7px text-black space-text seravek-light-font">'.strtoupper($value['bank']).'</div>';
                                } else {
                                    return '<div class="col-12 roboto-regular-font text-15px space-text text-grey">Virtual Number</div>
                                        <div class="col-12 text-greyish-brown text-21-7px space-bottom space-top-all seravek-medium-font"><span id="myInput">'.$value['eci'].'</span> &nbsp; 
                                            <i class="fa fa-clone clone" data-togle="tooltip" title="Hooray!" onclick="copyToClipboard(\'#myInput\')" style="cursor: pointer;"><div id="popover" rel="popover" data-content="Copied to clipboard" data-original-title="Copied"></div></i>
                                        </div>
                                        <div class="col-12 text-16-7px text-black space-text seravek-light-font">'.strtoupper($value['bank']).'</div>';
                                }
                            }
                        }
                    }
                }
            } elseif (isset($check['status']) && $check['status'] == 'fail') {
                $count++;
                $messages = 'Data not found';
            } else {
                $count++;
                $messages = 'Error server';
            }

            sleep(1);
        }

        return '<div class="col-12 text-greyish-brown text-21-7px space-bottom space-top-all seravek-medium-font">
                    </div>';
    }

    public function detail(Request $request)
    {
    	// return base64_decode($request->get('data'));
    	$data = json_decode(base64_decode($request->get('data')), true);
    	$data['check'] = 1;
    	$check = MyHelper::post('transaction/detail/webview', $data);
        // return $check;
    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'success') {
    		return back()->withErrors($lists['messages']);
    	} else {
    		return back()->withErrors(['Data not found']);
    	}

        // return $data;

    	if ($data['kind'] == 'Delivery') {
    		$view = 'detail_transaction_deliv';
    	}

    	if ($data['kind'] == 'Pickup Order') {
    		$view = 'detail_transaction_pickup';
    	}

    	if ($data['kind'] == 'Offline') {
    		$view = 'detail_transaction_off';
    	}

    	if ($data['kind'] == 'Voucher') {
    		$view = 'detail_transaction_voucher';
    	}

        if (isset($data['success'])) {
            $view = 'transaction_success';
        }

        if ($data['transaction_payment_status'] == 'Pending') {
            $view = 'transaction_pending';
        }

    	if (isset($data['order_label_v2'])) {
    		$data['order_label_v2'] = explode(',', $data['order_label_v2']);
    		$data['order_v2'] = explode(',', $data['order_v2']);
    	}
        return view('transaction::webview.'.$view.'')->with(compact('data'));
    }

    public function outletSuccess(Request $request)
    {
        // return base64_decode($request->get('data'));
        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::post('outletapp/order/detail/view', $data);
        // return $check;
        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'success') {
            return back()->withErrors($lists['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        if (isset($data['order_label_v2'])) {
            $data['order_label_v2'] = explode(',', $data['order_label_v2']);
            $data['order_v2'] = explode(',', $data['order_v2']);
        }
        return view('transaction::webview.outlet_app')->with(compact('data'));
    }

    public function detailPoint(Request $request)
    {
        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::post('transaction/detail/webview/point', $data);
        // return $check;

        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'success') {
            return back()->withErrors($lists['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        if ($data['type'] == 'trx') {
            $view = 'detail_point_online';
        }

        if ($data['type'] == 'voucher') {
            $view = 'detail_point_voucher';
        }

        return view('transaction::webview.'.$view.'')->with(compact('data'));
    }

    public function detailBalance(Request $request)
    {
        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::post('transaction/detail/webview/balance', $data);
        // return $check;

        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'success') {
            return back()->withErrors($lists['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        if ($data['type'] == 'trx') {
            $view = 'detail_balance_online';
        }

        if ($data['type'] == 'voucher') {
            $view = 'detail_balance_voucher';
        }

        return view('transaction::webview.'.$view.'')->with(compact('data'));
    }

    public function success()
    {
        return view('transaction::webview.transaction_success');
    }

    public function receiptOutletapp(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $data = json_decode(base64_decode($request->get('data')), true);
    	$check = MyHelper::postWithBearer('outletapp/order/detail/view', $data, $bearer);
      
        // return $check;
    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
    		return back()->withErrors($lists['messages']);
    	} else {
    		return back()->withErrors(['Data not found']);
        }
        // dd($data);

        return view('transaction::webview.receipt-outletapp')->with(compact('data'));
    }
}

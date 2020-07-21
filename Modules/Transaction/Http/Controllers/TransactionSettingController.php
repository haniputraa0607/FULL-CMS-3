<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class TransactionSettingController extends Controller
{
    public function list(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Global '.env('POINT_NAME', 'Points'),
            'submenu_active' => 'transaction-setting'
        ];

        $lists = MyHelper::get('transaction/setting/cashback');

        if (isset($lists['status']) && $lists['status'] == 'success') {
            $data['lists'] = $lists['result'];

            return view('transaction::setting.cashback_list', $data);
        } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
            if(isset($lists['messages'][0]) && $lists['messages'][0] == 'empty'){
                return view('transaction::setting.cashback_list', $data);
            }
            return view('transaction::setting.cashback_list', $data)->withErrors($lists['messages']);
        } else {
            return view('transaction::setting.cashback_list', $data)->withErrors(['Data not found']);
        }
    }

    public function update(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('transaction/setting/cashback/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return back()->with('success', ['Update setting success']);
        } elseif (isset($update['status']) && $update['status'] == 'fail') {
            return back()->withErrors([$update['messages']]);
        } else {
            return back()->withErrors(['Something went wrong']);
        }
    }

    public function refundRejectOrder(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Refund Reject Order',
            'submenu_active' => 'refund-reject-order'
        ];

        $data['status'] = ['refund_midtrans' => MyHelper::post('setting', ['key' => 'refund_midtrans'])['result']['value']??0];

        return view('transaction::setting.refund_reject_order', $data);
    }

    public function updateRefundRejectOrder(Request $request)
    {
        $sendData = [
            'refund_midtrans' => ['value', $request->refund_midtrans?1:0]
        ];
        $data['status'] = MyHelper::post('setting/update2', ['update' => $sendData]);
        if ($data['status']??false == 'success') {
            return back()->withSuccess(['Success update']);
        } else{
            return back()->withErrors(['Update failed']);
        }
    }

    public function autoReject(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Auto Reject time',
            'submenu_active' => 'auto-reject-time'
        ];

        $data['auto_reject_time'] = MyHelper::post('setting', ['key' => 'auto_reject_time'])['result']['value']??900;

        return view('transaction::setting.auto_reject', $data);
    }

    public function updateAutoReject(Request $request)
    {
        $sendData = [
            'auto_reject_time' => ['value', $request->auto_reject_time?:900]
        ];
        $data['status'] = MyHelper::post('setting/update2', ['update' => $sendData]);
        if ($data['status']??false == 'success') {
            return back()->withSuccess(['Success update']);
        } else{
            return back()->withErrors(['Update failed']);
        }
    }

}

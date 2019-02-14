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
            'sub_title'      => 'Global Kopi Point',
            'submenu_active' => 'transaction-setting'
        ];
        
        $lists = MyHelper::get('transaction/setting/cashback');

        if (isset($lists['status']) && $lists['status'] == 'success') {
            $data['lists'] = $lists['result'];

            return view('transaction::setting.cashback_list', $data);
        } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
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
}

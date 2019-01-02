<?php

namespace Modules\SettingFraud\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class SettingFraudController extends Controller
{
    public function list(){
        $data = [ 'title'             => 'Setting Fraud Detection List',
				  'menu_active'       => 'fraud-detection',
				  'submenu_active'    => 'campaign-list'
                ];
                
        $action = MyHelper::get('setting-fraud');
        
        if (isset($action['status']) && $action['status'] == "success") {
            $data['list'] = $action['result'];
        }
        else {
            $data['list'] = [];
        }

        return view('settingfraud::list', $data);
    }

    public function detail(Request $request, $id)
    {
        $post = $request->except('_token');

        //update data
        if($post){
            if(isset($post['files'])){
                unset($post['files']);
            }
            $save = MyHelper::post('setting-fraud/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('setting-fraud-detection/detail/'.$id)->withSuccess(['Setting fraud detection has been updated.']);
            }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }

        $data = [
            'title'          => 'Setting',
            'sub_title'      => 'Fraud Detection',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'fraud-detection',
        ];

        $getSetting = MyHelper::post('setting-fraud', ['id_fraud_setting' => $id]);
        
        if(isset($getSetting['status']) && $getSetting['status'] == 'success'){
            $data['result'] = $getSetting['result'];
        }else{
            $data['result'] = null;
        }

        $getApiKey = MyHelper::get('setting/whatsapp');
        if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        }else{
            $data['api_key_whatsapp'] = null;
        }

        $test = MyHelper::get('autocrm/textreplace');
        if($test['status'] == 'success'){
            $data['textreplaces'] = $test['result'];
        }

        $data['textreplaces'][] = [
            'keyword' => '%transaction_count_day%',
            'reference' => 'number of transaction in 1 day'
        ];

        $data['textreplaces'][] = [
            'keyword' => '%transaction_count_week%',
            'reference' => 'number of transaction in 1 week'
        ];

        $data['textreplaces'][] = [
            'keyword' => '%last_device_id%',
            'reference' => 'last device id used'
        ];
            
        return view('settingfraud::detail', $data);
    }
}

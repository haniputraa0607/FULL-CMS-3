<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class MerchantController extends Controller
{
    public function settingRegisterIntroduction(Request $request){
        $post = $request->all();
        if (empty($post)) {
            $data = [
                'title'          => 'Merchant',
                'menu_active'    => 'merchant',
                'sub_title'      => 'Setting Register Introduction',
                'submenu_active' => 'merchant-setting-register-introduction'
            ];

            $data['result'] = MyHelper::get('merchant/register/introduction/detail')['result']??[];
            return view('merchant::setting.register_introduction', $data);

        } else {
            if(!empty($post['image'])){
                $post['image'] = MyHelper::encodeImage($post['image']);
            }
            $update = MyHelper::post('merchant/register/introduction/save', $post);

            if (($update['status'] ?? false) == 'success'){
                return back()->with('success', ['Register introduction setting has been updated']);
            }else{
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }

    public function settingRegisterSuccess(Request $request){
        $post = $request->all();
        if (empty($post)) {
            $data = [
                'title'          => 'Merchant',
                'menu_active'    => 'merchant',
                'sub_title'      => 'Setting Register Success',
                'submenu_active' => 'merchant-setting-register-success'
            ];

            $data['result'] = MyHelper::get('merchant/register/success/detail')['result']??[];
            return view('merchant::setting.register_success', $data);

        } else {
            if(!empty($post['image'])){
                $post['image'] = MyHelper::encodeImage($post['image']);
            }
            $update = MyHelper::post('merchant/register/success/save', $post);

            if (($update['status'] ?? false) == 'success'){
                return back()->with('success', ['Register success setting has been updated']);
            }else{
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }
}

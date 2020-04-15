<?php

namespace Modules\Disburse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;

use Illuminate\Pagination\LengthAwarePaginator;


class DisburseSettingController extends Controller
{
    function listOutlet(Request $request){
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting List Outlet',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-list-outlet'
        ];

        if(Session::has('filter-disburse-list-outlet') && !empty($post) && !isset($post['filter'])){
            $post = Session::get('filter-disburse-list-outlet');
        }else{
            Session::forget('filter-disburse-list-outlet');
        }

        if($request->get('page')){
            $post['page'] = $request->get('page');
        }else{
            $post['page'] = 1;
        }
        $outlets = MyHelper::post('disburse/outlets',$post);
        if(isset($outlets['status']) && $outlets['status'] == 'success'){
            if (!empty($outlets['result']['data'])) {
                $data['outlets']          = $outlets['result']['data'];
                $data['outletTotal']     = $outlets['result']['total'];
                $data['outletPerPage']   = $outlets['result']['from'];
                $data['outletUpTo']      = $outlets['result']['from'] + count($outlets['result']['data'])-1;
                $data['outletPaginator'] = new LengthAwarePaginator($outlets['result']['data'], $outlets['result']['total'], $outlets['result']['per_page'], $outlets['result']['current_page'], ['path' => url()->current()]);
            }
            else {
                $data['outlets']          = [];
                $data['outletTotal']     = 0;
                $data['outletPerPage']   = 0;
                $data['outletUpTo']      = 0;
                $data['outletPaginator'] = false;
            }
        }else{
            $data['outlets']          = [];
            $data['outletTotal']     = 0;
            $data['outletPerPage']   = 0;
            $data['outletUpTo']      = 0;
            $data['outletPaginator'] = false;
        }

        if($post){
            Session::put('filter-disburse-list-outlet',$post);
        }
        return view('disburse::setting_bank_account.list_outlet', $data);
    }

    function bankAccount(Request $request){
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting Bank Account',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-bank-account'
        ];

        if($post){
            $storeSetting = MyHelper::post('disburse/setting/bank-account',$post);
            if(isset($storeSetting['status']) && $storeSetting['status'] == 'success'){
                return redirect('disburse/setting/bank-account')->withSuccess(['Success Update Data']);
            }else{
                return redirect('disburse/setting/bank-account')->withErrors(['Failed Update Data']);
            }
        }else{
            $bank = MyHelper::post('disburse/bank',$post);
            if(isset($bank['status']) && $bank['status'] == 'success'){
                $data['bank'] = $bank['result'];
            }else{
                $data['bank'] = [];
            }

            $user_franchisee = MyHelper::post('disburse/user-franchisee',$post);
            if(isset($user_franchisee['status']) && $user_franchisee['status'] == 'success'){
                $data['user_franchises'] = $user_franchisee['result'];
            }else{
                $data['user_franchises'] = [];
            }

            return view('disburse::setting_bank_account.setting', $data);
        }
    }

    function mdr(Request $request){
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Merchan Discount Rate (MDR)',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-mdr'
        ];

        if($post){
            $storeSetting = MyHelper::post('disburse/setting/mdr',$post);
            if(isset($storeSetting['status']) && $storeSetting['status'] == 'success'){
                return redirect('disburse/setting/mdr')->withSuccess(['Success Update Data']);
            }else{
                return redirect('disburse/setting/mdr')->withErrors(['Failed Update Data']);
            }
        }else{
            $mdr = MyHelper::get('disburse/setting/mdr');
            if(isset($mdr['status']) && $mdr['status'] == 'success'){
                $data['mdr'] = $mdr['result']['mdr'];
            }else{
                $data['mdr'] = [];
            }

            return view('disburse::setting_mdr.setting', $data);
        }
    }

    function mdrGlobal(Request $request){
        $post = $request->all();
        $updateSetting = MyHelper::post('disburse/setting/mdr-global',$post);

        if(isset($updateSetting['status']) && $updateSetting['status'] == 'success'){
            return redirect('disburse/setting/mdr')->withSuccess(['Success Update Data MDR Global']);
        }else{
            return redirect('disburse/setting/mdr')->withErrors(['Failed Update Data MDR Global']);
        }
    }

    function settingGlobal(){
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting Global',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-global'
        ];
        $fee = MyHelper::get('disburse/setting/fee-global');
        if(isset($fee['status']) && $fee['status'] == 'success'){
            $data['fee'] = $fee['result'];
        }else{
            $data['fee'] = [];
        }

        $point = MyHelper::get('disburse/setting/point-charged-global');
        if(isset($point['status']) && $point['status'] == 'success'){
            $data['point'] = $point['result'];
        }else{
            $data['point'] = [];
        }

        return view('disburse::setting_global.setting', $data);
    }
    function feeGlobal(Request $request){
        $post = $request->all();

        $update = MyHelper::post('disburse/setting/fee-global',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('disburse/setting/global#fee')->withSuccess(['Success Update Fee Global']);
        }else{
            return redirect('disburse/setting/global#fee')->withErrors(['Failed Update Fee Global']);
        }
    }

    function pointChargedGlobal(Request $request){
        $post = $request->all();

        $update = MyHelper::post('disburse/setting/point-charged-global',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('disburse/setting/global#point')->withSuccess(['Success Update Fee Global']);
        }else{
            return redirect('disburse/setting/global#point')->withErrors([$update['message']]);
        }
    }
}

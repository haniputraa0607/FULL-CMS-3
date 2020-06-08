<?php

namespace Modules\Disburse\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Imports\FirstSheetOnlyImport;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;

use Illuminate\Pagination\LengthAwarePaginator;
use Excel;

class DisburseSettingController extends Controller
{
    public function __construct()
    {
        $id_user_franchise = Session::get('id_user_franchise');
        if(!is_null($id_user_franchise)){
            $this->baseuri = 'disburse/user-franchise';
        }else{
            $this->baseuri = 'disburse';
        }
    }

    function editBankAccount(Request $request){
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting Bank Account',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-edit-bank-account'
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

        $bank = MyHelper::post('disburse/bank',$post);
        if(isset($bank['status']) && $bank['status'] == 'success'){
            $data['bank'] = $bank['result'];
        }else{
            $data['bank'] = [];
        }

        if($post){
            Session::put('filter-disburse-list-outlet',$post);
        }
        return view('disburse::setting_bank_account.edit', $data);
    }

    function bankAccountUpdate(Request $request){
        $post = $request->all();

        if($post){
            $udpateSetting = MyHelper::post('disburse/setting/bank-account',$post);
            if(isset($udpateSetting['status']) && $udpateSetting['status'] == 'success'){
                return redirect('disburse/setting/edit-bank-account')->withSuccess(['Success Update Data']);
            }else{
                return redirect('disburse/setting/edit-bank-account')->withErrors(['Failed Update Data']);
            }
        }
    }

    function bankAccount(Request $request){
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting Bank Account',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-add-bank-account'
        ];

        if($post){
            $storeSetting = MyHelper::post('disburse/setting/bank-account',$post);
            if(isset($storeSetting['status']) && $storeSetting['status'] == 'success'){
                return redirect('disburse/setting/bank-account#add')->withSuccess(['Success Update Data']);
            }else{
                return redirect('disburse/setting/bank-account#add')->withErrors(['Failed Update Data']);
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

            return view('disburse::setting_bank_account.add', $data);
        }
    }

    function exportListBank(Request $request){
        $bank = MyHelper::get('disburse/bank');
        if(isset($bank['status']) && $bank['status'] == 'success'){
            $arr['All Type'] = [];
            foreach ($bank['result'] as $value){
                $dt = [
                    'bank_code' => $value['bank_code'],
                    'bank_name' => $value['bank_name']
                ];
                $arr['All Type'][] = $dt;
            }
            $data = new MultisheetExport($arr);
            return Excel::download($data,'list_bank.xls');
        }else{
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['Failed Get Data List Bank']);
        }
    }

    function exportBankAccoutOutlet(Request $request){
        $outlet =  MyHelper::get('disburse/outlets');
        if(isset($outlet['status']) && $outlet['status'] == 'success'){
            $arr['All Type'] = [];
            foreach ($outlet['result'] as $value){
                $dt = [
                    'outlet_code' => $value['outlet_code'],
                    'outlet_name' => $value['outlet_name'],
                    'bank_code' => $value['bank_code'],
                    'beneficiary_name' => $value['beneficiary_name'],
                    'beneficiary_alias' => $value['beneficiary_alias'],
                    'beneficiary_account' => ' '.$value['beneficiary_account'],
                    'beneficiary_email' => $value['beneficiary_email']
                ];
                $arr['All Type'][] = $dt;
            }
            $data = new MultisheetExport($arr);
            return Excel::download($data,'janji_jiwa_bank_accout_outlet_'.date('dmYHis').'.xls');
        }else{
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['Failed Get Data List Bank']);
        }
    }

    function importBankAccoutOutlet(Request $request){
        $post = $request->except('_token');

        if($request->file('import_file')){

            $path = $request->file('import_file')->getRealPath();
            $name = $request->file('import_file')->getClientOriginalName();
            $dataimport = Excel::toArray(new FirstSheetOnlyImport(),$request->file('import_file'));
            $dataimport = array_map(function($x){return (Object)$x;}, $dataimport[0]??[]);
            $save = MyHelper::post('disburse/setting/import-bank-account-outlet', ['data_import' => $dataimport]);
            if (isset($save['status']) && $save['status'] == "success") {
                if(count($save['data_failed']) == 0){
                    $message = ['Success import '.count($save['data_success'])];
                }else{
                    $message = ['Success import '.count($save['data_success']),'Failed import ('.implode(",",$save['data_failed']).')'];
                }
                return redirect('disburse/setting/bank-account#export-import')->withSuccess($message);
            }else {
                if (isset($save['errors'])) {
                    return redirect('disburse/setting/bank-account#export-import')->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                return redirect('disburse/setting/bank-account#export-import')->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['Something when wrong. Please try again.'])->withInput();
        }else{
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['File is required.'])->withInput();
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
            if(!empty($post['days_to_sent'])){
                $post['days_to_sent'] = implode(",",$post['days_to_sent']);
            }

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

        $outlets = MyHelper::post($this->baseuri.'/outlets',[]);
        if(isset($outlets['status']) && $outlets['status'] == 'success'){
            $data['outlets'] = $outlets['result'];
        }else{
            $data['outlets'] = [];
        }

        $approver = MyHelper::get('disburse/setting/approver');
        if(isset($approver['status']) && $approver['status'] == 'success'){
            $data['approver'] = $approver['result'];
        }else{
            $data['approver'] = [];
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

    function listOutletAjax(Request $request){
        $post = $request->except('_token');
        $draw = $post["draw"];
        $list = MyHelper::post('disburse/setting/fee-outlet-special/outlets', $post);

        if(isset($list['status']) && isset($list['status']) == 'success'){
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $list['total'];
            $arr_result['recordsFiltered'] = $list['total'];
            $arr_result['data'] = $list['result'];
        }else{
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }
        return response()->json($arr_result);
    }

    function listOutletNotSpecialAjax(Request $request){
        $post = $request->except('_token');
        $draw = $post["draw"];
        $list = MyHelper::post('disburse/setting/fee-outlet-special/outlets-not-special', $post);

        if(isset($list['status']) && isset($list['status']) == 'success'){
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $list['total'];
            $arr_result['recordsFiltered'] = $list['total'];
            $arr_result['data'] = $list['result'];
        }else{
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }
        return response()->json($arr_result);
    }

    function settingFeeOutletSpecial(Request $request){
        $post = $request->except('_token');

        if($post['id_outlet'] != 'all'){
            $post['id_outlet'] = explode(',', $post['id_outlet']);
        }
        $update = MyHelper::post('disburse/setting/fee-outlet-special/update', $post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('disburse/setting/global#fee-special-outlet')->withSuccess(['Success Update Fee Special Outlet']);
        }else{
            return redirect('disburse/setting/global#fee-special-outlet')->withErrors([$update['messages']]);
        }
    }

    function settingSpecialOutlet(Request $request){
        $post = $request->except('_token');
        $post['id_outlet'] = explode(',',$post['id_outlet']);
        $save = MyHelper::post('disburse/setting/outlet-special', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            $data = ['status' => 'success'];
        }
        else {
            $data = ['status' => 'fail'];
            if(isset($save['messages'])){
                $data['messages'] = $save['messages'];
            }
        }
        return response()->json($save);
    }

    function settingApprover(Request $request){
        $post = $request->except('_token');
        if(isset($post['approver'])){
            $data['value'] = 1;
        }else{
            $data['value'] = 0;
        }
        $save = MyHelper::post('disburse/setting/approver', $data);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('disburse/setting/global#approver')->withSuccess(['Success Update Data']);
        }else{
            return redirect('disburse/setting/global#approver')->withErrors(['Failed Update Data']);
        }
    }
}

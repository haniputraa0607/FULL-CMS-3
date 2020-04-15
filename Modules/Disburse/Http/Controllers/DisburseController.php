<?php

namespace Modules\Disburse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Requests\loginRequest;
use App\Lib\MyHelper;
use Session;


class DisburseController extends Controller
{
    function login(Request $request){
        if(strlen($request->input('password')) != 6){
            return redirect('disburse/login')->withErrors(['Pin must be 6 digits' => 'Pin must be 6 digits'])->withInput();
        }

        $post = $request->all();
        $postLogin =  MyHelper::postLogin($request);

        if(isset($postLogin['error'])){
            // untuk log request
            $postLoginClient =  MyHelper::postLoginClient();

            if (isset($postLoginClient['access_token'])) {
                session([
                    'access_token'  => 'Bearer '.$postLoginClient['access_token']
                ]);
            }
            $checkpin = MyHelper::post('users/pin/check/be', array('phone' => $request->input('username'), 'pin' => $request->input('password')));
            return redirect('disburse/login')->withErrors(['invalid_credentials' => 'Invalid username / password'])->withInput();
        }
        else{
            if (isset($postLogin['status']) && $postLogin['status'] == "fail") {
                $postLoginClient =  MyHelper::postLoginClient();

                if (isset($postLoginClient['access_token'])) {
                    session([
                        'access_token'  => 'Bearer '.$postLoginClient['access_token']
                    ]);
                }

                $checkpin = MyHelper::post('users/pin/check/be', array('phone' => $request->input('username'), 'pin' => $request->input('password')));
                return redirect('disburse/login')->withErrors($postLogin['messages'])->withInput();
            }
            else {

                $checkpin = MyHelper::post('users/pin/check/be', array('phone' => $request->input('username'), 'pin' => $request->input('password')));
                session([
                    'access_token'  => 'Bearer '.$postLogin['access_token'],
                    'username'      => $request->input('username'),
                ]);

                $getFeature = MyHelper::get('granted-feature?log_save=0');

                $features = [];

                if(isset($getFeature['status']) && $getFeature['status'] == 'success' && !empty($getFeature['result'])) {
                    $features = $getFeature['result'];
                }

                $userData = null;

                while($userData == null){
                    $userData = MyHelper::get('user');
                }

                $getConfig = MyHelper::get('config');

                $configs = [];

                if(isset($getConfig['status']) && $getConfig['status'] == 'success' && !empty($getConfig['result'])) {
                    $configs = $getConfig['result'];
                }

                session([
                    'granted_features'  => $features,
                    'configs'  			=> $configs,
                    'level'             => $userData['level'],
                    'id_user'           => $userData['id'],
                    'phone'           	=> $userData['phone'],
                    'name'           	=> $userData['name'],
                    'email'           	=> $userData['email']
                ]);
            }

            return redirect('disburse/dashboard');
        }
    }

    public function dashboard(Request $request){
        $post = $request->all();
        if(!empty($post)){
            $post['id_user_franchise'] = session('id_user_franchise');
            $getData = MyHelper::post('disburse/dashboard', $post);
            if(isset($getData['status']) && $getData['status'] == 'success'){
                $data['status'] = 'success';
                $data['nominal_success'] = $getData['result']['nominal_success'];
                $data['nominal_fail'] = $getData['result']['nominal_fail'];
                $data['nominal_trx'] = $getData['result']['nominal_trx'];

                $data['format_nominal_success'] = number_format($getData['result']['nominal_success']);
                $data['format_nominal_fail'] = number_format($getData['result']['nominal_fail']);
                $data['format_nominal_trx'] = number_format($getData['result']['nominal_trx']);
            }else{
                $data['status'] = 'fail';
            }
            return response()->json($data);
        }else{
            $data = [
                'title'          => 'Disburse',
                'sub_title'      => 'Disburse Dashboard',
                'menu_active'    => 'disburse-dashboard',
                'submenu_active' => 'disburse-dashboard'
            ];

            $getData = MyHelper::post('disburse/dashboard', ['id_user_franchise' => session('id_user_franchise')]);
            if(isset($getData['status']) && $getData['status'] == 'success'){
                $data['nominal_success'] = $getData['result']['nominal_success'];
                $data['nominal_fail'] = $getData['result']['nominal_fail'];
                $data['nominal_trx'] = $getData['result']['nominal_trx'];
            }else{
                $data['nominal_success'] = [];
                $data['nominal_fail'] = [];
                $data['nominal_trx'] = [];
            }

            $outlets = MyHelper::post('disburse/outlets',$post);
            if(isset($getData['status']) && $getData['status'] == 'success'){
                $data['outlets'] = $outlets['result'];
            }else{
                $data['outlets'] = [];
            }
            return view('disburse::dashboard', $data);
        }
    }

    public function listDisburseDataTable(Request $request, $status){
        $post = $request->all();
        $draw = $post["draw"];
        $post['id_user_franchise'] = session('id_user_franchise');

        $getDisburse = MyHelper::post('disburse/list-datatable/fail',$post);
        if(isset($getDisburse['status']) && isset($getDisburse['status']) == 'success'){
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $getDisburse['total'];
            $arr_result['recordsFiltered'] = $getDisburse['total'];
            $arr_result['data'] = $getDisburse['result'];
        }else{
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }

    public function getOutlets(Request $request){
        $post = $request->all();
        $post['id_user_franchise'] = session('id_user_franchise');

        $outlets = MyHelper::post('disburse/outlets',$post);
        return response()->json($outlets);
    }

    public function listTrx(Request $request){
        $post = $request->all();
        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'List Transactions',
            'menu_active'    => 'disburse-list-trx',
            'submenu_active' => 'disburse-list-trx'
        ];

        if(Session::has('filter-list-disburse-trx') && !empty($post) && !isset($post['filter'])){
            $post = Session::get('filter-list-disburse-trx');
        }else{
            Session::forget('filter-list-disburse-trx');
        }

        $getTrx = MyHelper::post('disburse/list/trx',$post);

        if (isset($getTrx['status']) && $getTrx['status'] == "success") {
            $data['trx']          = $getTrx['result']['data'];
            $data['trxTotal']     = $getTrx['result']['total'];
            $data['trxPerPage']   = $getTrx['result']['from'];
            $data['trxUpTo']      = $getTrx['result']['from'] + count($getTrx['result']['data'])-1;
            $data['trxPaginator'] = new LengthAwarePaginator($getTrx['result']['data'], $getTrx['result']['total'], $getTrx['result']['per_page'], $getTrx['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['trx']          = [];
            $data['trxTotal']     = 0;
            $data['trxPerPage']   = 0;
            $data['trxUpTo']      = 0;
            $data['trxPaginator'] = false;
        }

        if($post){
            Session::put('filter-list-disburse-trx',$post);
        }
        return view('disburse::disburse.list_trx', $data);
    }

    public function listDisburse(Request $request, $status){
        $post = $request->all();
        $post['id_user_franchise'] = session('id_user_franchise');
        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'List Disburse '.ucfirst($status),
            'menu_active'    => 'disburse-list-'.$status,
            'submenu_active' => 'disburse-list-'.$status
        ];

        if(Session::has('filter-list-disburse') && !empty($post) && !isset($post['filter'])){
            $post = Session::get('filter-list-disburse');
        }else{
            Session::forget('filter-list-disburse');
        }

        $getDisburse = MyHelper::post('disburse/list/'.$status,$post);
        if (isset($getDisburse['status']) && $getDisburse['status'] == "success") {
            $data['disburse']          = $getDisburse['result']['data'];
            $data['disburseTotal']     = $getDisburse['result']['total'];
            $data['disbursePerPage']   = $getDisburse['result']['from'];
            $data['disburseUpTo']      = $getDisburse['result']['from'] + count($getDisburse['result']['data'])-1;
            $data['disbursePaginator'] = new LengthAwarePaginator($getDisburse['result']['data'], $getDisburse['result']['total'], $getDisburse['result']['per_page'], $getDisburse['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['disburse']          = [];
            $data['disburseTotal']     = 0;
            $data['disbursePerPage']   = 0;
            $data['disburseUpTo']      = 0;
            $data['disbursePaginator'] = false;
        }

        $bank = MyHelper::post('disburse/bank',$post);
        if(isset($bank['status']) && $bank['status'] == 'success'){
            $data['banks'] = $bank['result'];
        }else{
            $data['banks'] = [];
        }

        if($post){
            Session::put('filter-list-disburse',$post);
        }

        return view('disburse::disburse.list', $data);
    }

    public function detailDisburse(Request $request, $id){
        $post = $request->all();

        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'Detail Disburse',
            'menu_active'    => '',
            'submenu_active' => ''
        ];

        $getDisburse = MyHelper::post('disburse/detail/'.$id,$post);
        if (isset($getDisburse['status']) && $getDisburse['status'] == "success") {
            $data['trx']          = $getDisburse['result']['list_trx']['data'];
            $data['trxTotal']     = $getDisburse['result']['list_trx']['total'];
            $data['trxPerPage']   = $getDisburse['result']['list_trx']['from'];
            $data['trxUpTo']      = $getDisburse['result']['list_trx']['from'] + count($getDisburse['result']['list_trx']['data'])-1;
            $data['trxPaginator'] = new LengthAwarePaginator($getDisburse['result']['list_trx']['data'], $getDisburse['result']['list_trx']['total'], $getDisburse['result']['list_trx']['per_page'], $getDisburse['result']['list_trx']['current_page'], ['path' => url()->current()]);
            $data['disburse'] = $getDisburse['result']['data_disburse'];
        }else{
            $data['trx']          = [];
            $data['trxTotal']     = 0;
            $data['trxPerPage']   = 0;
            $data['trxUpTo']      = 0;
            $data['trxPaginator'] = false;
            $data['disburse'] = [];
        }

        return view('disburse::disburse.detail', $data);
    }

    function userFranchise(Request $request){
        $post = $request->all();
        $post['id_user_franchise'] = session('id_user_franchise');

        $user = MyHelper::post('disburse/user-franchise',$post);
        return response()->json($user);
    }
}

<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Lib\MyHelper;
use Modules\Reward\Http\Controllers\RewardController;
use Session;

class InvalidFlagController extends Controller
{
    public function markAsInvalid(Request $request){
        $post = $request->except('_token');

        $data = [
            'title'          => 'Mark as Invalid',
            'menu_active'    => 'mark-as-invalid',
            'sub_title'      => 'Mark as Invalid',
            'submenu_active' => 'mark-as-invalid'
        ];

        if(Session::has('filter-mark-as-invalid') && !empty($post) && !isset($post['filter'])){
            $post = Session::get('filter-mark-as-invalid');
        }else{
            Session::forget('filter-mark-as-invalid');
        }

        $data['list_trx'] = [];
        if(!empty($post)){
            $list = MyHelper::post('transaction/invalid-flag/filter', $post);

            if (isset($list['result']['data']) && !empty($list['result']['data'])) {
                $data['data']          = $list['result']['data'];
                $data['dataTotal']     = $list['result']['total'];
                $data['dataPerPage']   = $list['result']['from'];
                $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
                $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            }else {
                $data['data']          = [];
                $data['dataTotal']     = 0;
                $data['dataPerPage']   = 0;
                $data['dataUpTo']      = 0;
                $data['dataPaginator'] = false;
            }
        }

        if($post){
            Session::put('filter-mark-as-invalid',$post);
        }

        return view('transaction::flag_invalid.mark_as_invalid', $data);
    }

    public function markAsInvalidAdd(Request $request){
        $post = $request->except('_token');

        if(isset($post['image'])){
            $post['image'] = MyHelper::encodeImage($post['image']);
        }

        $add = MyHelper::post('transaction/invalid-flag/mark-as-invalid/add', $post);

        if (isset($add['status']) && $add['status'] == 'success') {
            return redirect('transaction/invalid-flag/mark-as-valid')->withSuccess(['Success Add Data']);
        }else{
            return redirect('transaction/invalid-flag/mark-as-invalid')->withErrors($add['messages']);
        }
    }

    public function markAsValidUpdate(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('transaction/invalid-flag/mark-as-valid/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('transaction/invalid-flag/mark-as-valid')->withSuccess(['Success Add Data']);
        }else{
            return redirect('transaction/invalid-flag/mark-as-valid')->withErrors($update['messages']);
        }
    }

    public function markAsValid(Request $request){
        $post = $request->except('_token');

        $data = [
            'title'          => 'Mark as Valid',
            'menu_active'    => 'mark-as-invalid',
            'sub_title'      => 'Mark as Invalid',
            'submenu_active' => 'mark-as-invalid'
        ];

        if(Session::has('filter-mark-as-valid') && !empty($post) && !isset($post['filter'])){
            $post = Session::get('filter-mark-as-valid');
        }else{
            Session::forget('filter-mark-as-valid');
        }

        $post['invalid'] = 1;
        $list = MyHelper::post('transaction/invalid-flag/filter', $post);
        if (isset($list['result']['data']) && !empty($list['result']['data'])) {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        }else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if($post){
            Session::put('filter-mark-as-valid',$post);
        }

        return view('transaction::flag_invalid.mark_as_valid', $data);
    }

    public function detailTrx(Request $request, $id){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Invalid Flag',
            'menu_active'    => 'mark-as-invalid',
            'sub_title'      => 'Mark as Invalid',
            'submenu_active' => 'mark-as-invalid'
        ];

        $post['id_transaction'] = $id;
        $post['type'] = 'trx';
        $post['check'] = 1;

        $check = MyHelper::post('transaction/be/detail', ['id_transaction' => $id, 'type' => 'trx', 'admin' => 1]);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data['data'] = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        $data['from'] = $post['from'];
        $data['id_transaction'] = $id;
        return view('transaction::transactionDetail3', $data);
    }

    public function listLogInvalidFlag(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Log Invalid Flag',
            'submenu_active' => 'log-invalid-flag'
        ];

        if(Session::has('filter-list-flag-invalid') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-list-flag-invalid');
            $post['page'] = $page;
        }else{
            Session::forget('filter-list-flag-invalid');
        }

        $list = MyHelper::post('transaction/log-invalid-flag/list', $post);

        if (isset($list['result']['data']) && !empty($list['result']['data'])) {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        }else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if($post){
            Session::put('filter-list-flag-invalid',$post);
        }

        return view('transaction::flag_invalid.list', $data);
    }

    public function detailLogInvalidFlag(Request $request){
        $post = $request->except('_token');
        $data = MyHelper::post('transaction/log-invalid-flag/detail',$post);

        return $data;
    }
}

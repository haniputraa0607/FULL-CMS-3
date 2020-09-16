<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Lib\MyHelper;
use Session;

class InvalidFlagController extends Controller
{
    public function markAsInvalid(Request $request){
        $post = $request->except('_token');
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

    public function markAsValid(Request $request){

    }
}

<?php

namespace Modules\UserFeedback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class UserFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {                    
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback List',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-list',
            'filter_title'   => 'User Feedback Filter'
        ];
        $page = $request->get('page')?:1;
        $post = [];

        if(session('feedback_list_filter')){
            $post=session('feedback_list_filter');
            $data['rule']=array_map('array_values', $post['rule']);
            $data['operator']=$post['operator'];
        }
        $rating_items = MyHelper::get('user-feedback/rating-item')['result']??[];
        $data['rating_items'] = [];
        foreach ($rating_items as $item) {
            $data['rating_items'][$item['rating_value']] = $item['text'];
        }
        $data['feedbackData'] = MyHelper::post('user-feedback?page='.$page,$post)['result']??[];
        $data['total'] = $data['feedbackData']['total']??count($data['feedbackData']['data']??[]);
        $data['outlets'] = array_map(function($var){
            $var = [$var['id_outlet'],$var['outlet_name']];
            return $var;
        },MyHelper::get('outlet/be/list')['result']??[]);
        $data['next_page'] = $data['feedbackData']['next_page_url']?url()->current().'?page='.($page+1):'';
        $data['prev_page'] = $data['feedbackData']['prev_page_url']?url()->current().'?page='.($page-1):'';
        return view('userfeedback::index',$data);
    }

    public function setFilter(Request $request)
    {
        $post = $request->except('_token');
        if($post['rule']??false){
            session(['feedback_list_filter'=>$post]);
        }elseif($post['clear']??false){
            session(['feedback_list_filter'=>null]);
            session(['feedback_list_filter'=>null]);
        }
        return back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback Detail',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-list'
        ];
        $ids = explode('#',base64_decode($id));
        if(!is_numeric($ids[0])||!is_numeric($ids[1])){
            return back()->withErrors(['User feedback not found']);
        }
        $post = [
            'id_user_feedback' => $ids[0]??'',
            'id_transaction' => $ids[1]??''
        ];
        $rating_items = MyHelper::get('user-feedback/rating-item')['result']??[];
        $data['rating_items'] = [];
        foreach ($rating_items as $item) {
            $data['rating_items'][$item['rating_value']] = $item['text'];
        }
        $data['feedback'] = MyHelper::post('user-feedback/detail',$post)['result']??false;
        if(!$data['feedback']){
            return back()->withErrors(['User feedback not found']);
        }
        $post['id_transaction'] = $data['feedback']['id_transaction'];
        $post['type'] = 'trx';
        $post['check'] = 1;

        $check = MyHelper::post('transaction/be/detail/webview/simple?log_save=0', $post);
        // $check = MyHelper::post('outletapp/order/detail/view?log_save=0', $data);
        if (isset($check['status']) && $check['status'] == 'success') {
            $data['data'] = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        return view('userfeedback::show',$data);
    }
    public function setting(Request $request) {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback Setting',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'feedback-setting'
        ];
        $ratings = MyHelper::post('setting',['key-like'=>'rating'])['result']??[];
        $popups = MyHelper::post('setting',['key-like'=>'popup'])['result']??[];
        $data['rating'] = [];
        $data['popup'] = [];
        foreach ($ratings as $rating) {
            $data['setting'][$rating['key']] = $rating;
        }
        foreach ($popups as $popup) {
            $data['setting'][$popup['key']] = $popup;
        }
        $items = MyHelper::get('user-feedback/rating-item')['result']??[];
        $newArr = [];
        foreach ($items as $item) {
            $newArr[$item['rating_value']]=$item;
        }
        $data['items'] = $newArr;
        return view('userfeedback::setting',$data);
    }

    public function settingUpdate(Request $request) {
        $data = [
            'popup_min_interval' => ['value',$request->post('popup_min_interval')],
            'popup_max_refuse' => ['value',$request->post('popup_max_refuse')],
            'rating_question_text' => ['value_text',substr($request->post('rating_question_text'),0,40)]
        ];
        $update = MyHelper::post('setting/update2',['update'=>$data]);
        if(($update['status']??false)=='success'){
            return back()->with('success',['Success update setting']);
        }else{
            dd($update);
            return back()->withInput()->withErrors(['Failed update setting']);
        }
    }
}

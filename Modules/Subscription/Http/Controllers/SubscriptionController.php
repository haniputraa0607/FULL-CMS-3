<?php

namespace Modules\Subscription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionController extends Controller
{

    function getData($access) {
        if (isset($access['status']) && $access['status'] == "success") {
            return $access['result'];
        }
        else {
            return [];
        }
    }

    function getSubscriptionType($request) 
    {
    	$subs_type = $request->route()->getAction('subscription_type');
    	return $subs_type;
    }

    function getSubscriptionMenu($subs_type, $menu)
    {
    	switch ($subs_type) {

    		case 'welcome':

    			switch ($menu) {

    				case 'create':
    					
    					$data = [
			                'title'          => 'Welcome Subscription',
			                'sub_title'      => 'Welcome Subscription Create',
			                'menu_active'    => 'welcome-subscription',
			                'submenu_active' => 'welcome-subscription-create'
			            ];
    					break;

    				case 'detail':
    					
    					$data = [
			                'title'          => 'Welcome Subscription',
			                'sub_title'      => 'Welcome Subscription Detail',
			                'menu_active'    => 'welcome-subscription',
			                'submenu_active' => 'welcome-subscription-list'
			            ];
    					break;
    				
    				case 'setting':
    					
    					$data = [
	                        'title'          => 'Welcome Subscription',
	                        'sub_title'      => 'Welcome Subscription Setting',
	                        'menu_active'    => 'welcome-subscription',
	                        'submenu_active' => 'welcome-subscription-setting'
	                    ];
    					break;
    				
    				default:
    				
    					$data = [
				            'title'          => 'Welcome Subscription',
				            'sub_title'      => 'Welcome Subscription List',
				            'menu_active'    => 'welcome-subscription',
				            'submenu_active' => 'welcome-subscription-list'
				        ];
    					break;
    			}
    			$data['subscription_type'] = 'welcome';
				$data['rpage'] = 'welcome-subscription';
    			break;
    		
    		default:

    			switch ($menu) {

    				case 'create':
    					
    					$data = [
			                'title'          => 'Subscription',
			                'sub_title'      => 'Subscription Create',
			                'menu_active'    => 'subscription',
			                'submenu_active' => 'subscription-create'
			            ];
    					break;

    				case 'detail':
    					
    					$data = [
			                'title'          => 'Subscription',
			                'sub_title'      => 'Subscription Detail',
			                'menu_active'    => 'subscription',
			                'submenu_active' => 'subscription-list'
			            ];
    					break;
    				
    				default:
    				
    					$data = [
				            'title'          => 'subscription',
				            'sub_title'      => 'subscription List',
				            'menu_active'    => 'subscription',
				            'submenu_active' => 'subscription-list'
				        ];
    					break;
    			}

    			$data['subscription_type'] = 'subscription';
    			$data['rpage'] = 'subscription';
    			break;
    	}

    	return $data;
    }

    public function index(Request $request)
    {
        $post 		= $request->except('_token');
		$subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'list');

        if($post){
            if(($post['clear']??false)=='session'){
                session(['subs_filter'=>[]]);
            }else{
                session(['subs_filter'=>$post]);
            }
            return back();
        }

        $post['newest'] = 1;
        $post['web'] = 1;
        $post['admin'] = 1;
        $post['created_at'] = 1;
        $post['with_brand'] = 1;
        $post['subscription_type'] = $subs_type??'subscription';

        if(($filter=session('subs_filter'))&&is_array($filter))
        {
            $post=array_merge($filter,$post);
            if($filter['rule']??false)
            {
                $data['rule']=array_map('array_values', $filter['rule']);
            }
            if($filter['operator']??false)
            {
                $data['operator']=$filter['operator'];
            }
        }

        $data['subs'] = array_map(function($var){
            $var['id_subscription'] = MyHelper::createSlug($var['id_subscription'],$var['created_at']);
            return $var;
        },$this->getData(MyHelper::post('subscription/be/list', $post)));

        $post['select'] = ['id_outlet','outlet_code','outlet_name'];
        $data['outlets'] = $this->getData(MyHelper::post('outlet/ajax_handler', $post));


        return view('subscription::list', $data);

    }

    public function participateAjax($input, $id_encrypt) {

        $return = $input;
        $return['draw']=(int)$input['draw'];
        // $exploded = MyHelper::explodeSlug($input['id_subscription']);
        // $id_encrypt = $input['id_subscription'];
        // $input['id_subscription'] = $exploded[0];
        $participate = MyHelper::post('subscription/participate-ajax', $input);
        
        if ( ($participate['status']??'') == 'success') {
            $return['recordsTotal'] = $participate['total'];
            $return['recordsFiltered'] = $participate['count'];
            $return['data'] = array_map(function($x) use ($participate, $id_encrypt){
                $detailUrl=url('subscription/detail/'.$id_encrypt.'/'.$x['subscription_user_receipt_number']);
                $price = $x['subscription_price_point']??$x['subscription_price_point']??'Free';
                return [
                    $x['subscription_user_receipt_number'],
                    $x['name'].' - '.$x['phone'],
                    date('d M Y', strtotime($x['bought_at'])),
                    date('d M Y', strtotime($x['subscription_expired_at'])),
                    $x['paid_status'],
                    $price,
                    number_format($x['kuota'], 2).' | '.number_format($x['used'], 2).' | '.number_format($x['available'], 2),
                    "<a href='$detailUrl' data-popout='true' class='btn btn-sm blue'><i class='fa fa-search'></i></a>"
                ];
            },$participate['result']);
            return $return;
        } else {
            $return['recordsTotal'] = 0;
            $return['recordsFiltered'] = 0;
            $return['data'] = [];
            return $return;
        }
        return $participate;
    }

    public function transaction($slug, $subs_receipt)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id_subscription = $exploded[0];
        $created_at = $exploded[1];
        // return $subs_receipt;
        $post['id_subscription'] = $id_subscription;
        $post['created_at'] = $created_at;
        $post['subscription_user_receipt_number'] = $subs_receipt;

        $data = [
            'title'          => 'Subscription',
            'sub_title'      => 'Subscription Transaction Detail',
            'menu_active'    => 'subscription',
            'submenu_active' => 'subscription-list'
        ];

        // $data['trx'] = $this->getData(MyHelper::post('subscription/trx', $post));
        $data['trx'] = MyHelper::post('subscription/trx', $post);

        // return $data;


        return view('subscription::list_transaction', $data);
    }

    public function changeDateFormat($date)
    {
        if ( !empty($date) ) {
            $date = date('Y-m-d H:i:s', strtotime($date));
        }
        return $date;
    }

    public function create(Request $request, $slug=null)
    {
    	$subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'create');

        if($slug){
            $exploded = MyHelper::explodeSlug($slug);
            $id_subscription = $exploded[0];
            $created_at = $exploded[1];
        }else{
            $id_subscription = null;
            $created_at = null;
        }
        $post = $request->except('_token');
        if (!empty($post)) {
            if(isset($post['charged_central']) && isset($post['charged_outlet'])){
                $check = $post['charged_central'] + $post['charged_outlet'];
                if((int)$check !== 100){
                    return back()->withErrors(['Value charged central and outlet not valid. Value charged central and outlet must be 100 %.'])->withInput();
                }
            }
            if($post['id_subscription']){
                $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0];
            }

            $post['subscription_start']         = $this->changeDateFormat($post['subscription_start']??null);
            $post['subscription_end']           = $this->changeDateFormat($post['subscription_end']??null);
            $post['subscription_publish_start'] = $this->changeDateFormat($post['subscription_publish_start']??null);
            $post['subscription_publish_end']   = $this->changeDateFormat($post['subscription_publish_end']??null);
            if (isset($post['subscription_image'])) {
                $post['subscription_image']         = MyHelper::encodeImage($post['subscription_image']);
            }

            $save = MyHelper::post('subscription/step1', $post);

            if ( ($save['status']??false) == "success") {
                isset($id_subscription) ? $message = ['Subscription has been Updated'] : $message = ['Subscription has been created'];
                return redirect($data['rpage'].'/step2/'.MyHelper::createSlug($save['result']['id_subscription'],$save['result']['created_at']??''))->with('success', $message);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
        }
        else {
            
            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step1', ['id_subscription' => $id_subscription])['result']??'';
                if ($data['subscription'] == '') {
                    return redirect($data['rpage'])->withErrors('Subscription not found');
                }
                if(isset($data['subscription']['id_subscription'])) {
                    $data['subscription']['id_subscription'] = MyHelper::createSlug($data['subscription']['id_subscription'],$data['subscription']['id_subscription']??'');
                }
            }

            return view('subscription::step1', $data);
        }
    }

    public function step2(Request $request, $slug = null)
    {
    	$subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'create');

        if($slug){
            $exploded = MyHelper::explodeSlug($slug);
            $id_subscription = $exploded[0];
            $created_at = $exploded[1];
        }else{
            $id_subscription = null;
            $created_at = null;
        }
        $post = $request->except('_token');

        if (!empty($post)) {
            if($post['id_subscription']){
                $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0];
            }
            $save = MyHelper::post('subscription/step2', $post);

            if ( ($save['status']??false) == "success") {
                return redirect($data['rpage'].'/step3/'.$slug)->with('success', ['Subscription has been updated']);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
        }
        else {

            $post['select'] = ['id_outlet','outlet_code','outlet_name'];
            $outlets = MyHelper::post('outlet/ajax_handler', $post);
            
            if (!empty($outlets['result'])) {
                $data['outlets'] = $outlets['result'];
            }
            if (isset($id_subscription)) {
                $data['subscription'] = $this->getData(MyHelper::post('subscription/show-step2', ['id_subscription' => $id_subscription]));
                if (empty($data['subscription'])) {
                    return redirect($data['rpage'])->withErrors('Subscription not found');
                }
                $data['subscription']['id_subscription'] = MyHelper::createSlug($data['subscription']['id_subscription'],$data['subscription']['id_subscription']??'');
            }

            // DATA BRAND
        	$data['brands'] = MyHelper::get('brand/be/list')['result']??[];

            return view('subscription::step2', $data);
        }
    }

    public function step3(Request $request, $slug)
    {
    	$subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'create');

        if($slug){
            $exploded = MyHelper::explodeSlug($slug);
            $id_subscription = $exploded[0];
            $created_at = $exploded[1];
        }else{
            $id_subscription = null;
            $created_at = null;
        }
        $post = $request->except('_token');
        if (!empty($post)) {
            if($post['id_subscription']){
                $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0];
            }

            $save = MyHelper::post('subscription/step3', $post);

            if ( ($save['status']??false) == "success") {
                return redirect($data['rpage'].'/detail/'.$slug)->with('success', ['Subscription has been updated']);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
            return $post;
        }
        else {

            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step3', ['id_subscription' => $id_subscription])['result']??'';
                if ($data['subscription'] == '') {
                    return redirect($data['rpage'])->withErrors('Subscription not found');
                }
                $data['subscription']['id_subscription'] = MyHelper::createSlug($data['subscription']['id_subscription'],$data['subscription']['id_subscription']??'');
            }

            return view('subscription::step3', $data);
        }
    }

    public function detail(Request $request, $slug, $subs_receipt=null)
    {
    	$subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'detail');
        $exploded = MyHelper::explodeSlug($slug);
        $id_subscription = $exploded[0];
        $created_at = $exploded[1];

        if (isset($subs_receipt)) {
            return $this->transaction($id_subscription, $subs_receipt);
        }
        $post = $request->except('_token');
        if (!empty($post)) {
            $post['id_subscription'] = $id_subscription;

            $post['subscription_start']         = $this->changeDateFormat($post['subscription_start']??null);
            $post['subscription_end']           = $this->changeDateFormat($post['subscription_end']??null);
            $post['subscription_publish_start'] = $this->changeDateFormat($post['subscription_publish_start']??null);
            $post['subscription_publish_end']   = $this->changeDateFormat($post['subscription_publish_end']??null);
            if (isset($post['subscription_image'])) {
                $post['subscription_image']         = MyHelper::encodeImage($post['subscription_image']);
            }
            $save = MyHelper::post('subscription/updateDetail', $post);

            if ( ($save['status']??false) == "success") {
                return redirect('subscription/detail/'.$slug)->with('success', ['Subscription has been updated']);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
        }
        else {

            $data['subscription'] = MyHelper::post('subscription/show-detail', ['id_subscription' => $id_subscription])['result']??'';
            if ($data['subscription'] == '') {
                return redirect('subscription')->withErrors('Subscription not found');
            }
            $data['subscription']['id_subscription'] = $slug;

            $post['condition']['rules'][0] = [
            	'subject' => 'id_brand',
            	'parameter' => $data['subscription']['id_brand'],
            	'operator' => '='
            ];
            $post['condition']['operator'] = 'and';
            $post['select'] = ['id_outlet','outlet_code','outlet_name'];
            $data['outlets'] = MyHelper::post('outlet/ajax_handler', $post)['result']??[];

            $post['select'] = ['id_product','product_code','product_name'];
            $data['products'] = MyHelper::post('product/ajax-product-brand', $post);
        	$data['brands'] = MyHelper::get('brand/be/list')['result']??[];

            return view('subscription::detail', $data);
        }
    }

    public function detailv2(Request $request, $slug, $subs_receipt=null)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id_subscription = $exploded[0];
        $created_at = $exploded[1];
        $subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'detail');

        if (isset($subs_receipt)) {
            return $this->transaction($id_subscription, $subs_receipt);
        }
        $post = $request->except('_token');

        if ($request->post('clear') == 'session') 
        {
            session(['participate_subscription_'.$id_subscription => '']);
            unset($post['rule']);
        }
        
        $this->session_mixer($request, $post,'participate_subscription_'.$id_subscription);

        $post['id_subscription'] = $id_subscription;
        if($request->input('ajax')=='true')
        {
            return $this->participateAjax($post, $slug);
        }

        $data['subscription'] = MyHelper::post('subscription/show-detail', $post)['result']??'';
        if ($data['subscription'] == '') {
            return redirect('subscription')->withErrors('Subscription not found');
        }
        $data['subscription']['id_subscription'] = $slug;

        $data['rule']=$post['rule']??[];
        if (isset($data['rule'])) {	
            $filter = array_map(function ($x) {
                return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
            }, $data['rule']);
            $data['rule'] = $filter;
        }
        
        $data['operator']=$post['operator']??'and';

        return view('subscription::detailv2', $data);

    }

    public function session_mixer($request, &$post,$sess='subscription_filter')
    {
        $session = session($sess);
        $session = is_array($session) ? $session : array();
        $post = array_merge($session, $post);
        session([$sess => $post]);
    }

    function listSubcriptionAjax(Request $request){
        $get = MyHelper::get('subscription/be/list/ajax');
        return response()->json($get);
    }

    function deleteSubscription(Request $request) {
        $post    = $request->except('_token');
        $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0]??'';
        $delete = MyHelper::post('subscription/delete', ['id_subscription' => $post['id_subscription']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    public function updateComplete(Request $request)
    {
    	$post = $request->except('_token');
    	$subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'create');
        
    	$slug = $post['id_subscription'];
        $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0]??'';
		$update = MyHelper::post('subscription/update-complete', $post);

        $rpage = $data['rpage'];

		if ( ($update['status']??false) == 'success' ) 
		{
			return redirect($rpage.'/detail/'.$slug)->withSuccess(['Subscription has been started']);
		}
		elseif ( ($update['status']??false) == 'fail' ) 
		{
			if ( !empty($update['step']) ) 
			{
				return redirect($rpage.'/step'.$update['step'].'/'.$slug)->withErrors($update['messages']);
			}
			else
			{
				return redirect()->back()->withErrors($update['messages']);
			}
		}
		else
		{
			return ['status' => 'fail', 'messages' => 'Something went wrong'];	
		}
    }

    function welcomeSubscriptionSetting(Request $request){
        $post = $request->except('_token');
    	$subs_type 	= $this->getSubscriptionType($request);
        $data 		= $this->getSubscriptionMenu($subs_type, 'setting');

        if($post){
            $updateSetting =  MyHelper::post('welcome-subscription/setting/update', $post);

            if($updateSetting){
                return redirect($data['rpage'].'/setting')->withSuccess(['Setting Welcome Subscription has been updated.']);
            }else{
                return redirect($data['rpage'].'/setting')->withErrors(['Setting Welcome Subscription failed.']);
            }
        }
        $setting 	= MyHelper::post('welcome-subscription/setting', $post);
        $list_subs 	= MyHelper::post('welcome-subscription/list', ['subscription_type' => 'welcome', 'web' => 1]);
        if(isset($setting['status']) && $setting['status'] == 'success'){
            $data['setting'] = $setting['data']['setting'];
            $data['subscription'] = $setting['data']['subscription'];
        }else{
            $data['setting'] = [];
            $data['subscription'] = [];
        }

        if(isset($list_subs['status']) && $list_subs['status'] == 'success'){
            $data['list_subs'] = $list_subs['result'];
        }else{
            $data['list_subs'] = [];
        }

        return view('subscription::welcome-subscription.setting', $data);
    }

    function welcomeSubscriptionUpdateStatus(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('welcome-subscription/setting/update/status', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update status welcome pack'];
        }
    }
}

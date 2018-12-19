<?php

namespace Modules\Promotion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;
use Excel;
use View;


class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request){
		$data = [ 'title'             => 'Promotion List',
				  'menu_active'       => 'promotion',
				  'submenu_active'    => 'promotion-list'
				];
				
		$post = $request->except(['_token']);
		
		if(isset($post['reset'])){
			Session::forget('promotion_name');
		}
		if(isset($post['promotion_name'])){
			Session::put('promotion_name', $post['promotion_name']);
			unset($post['page']);
		}
		
		$getPromotionName = Session::get('promotion_name');
		if(!empty($getPromotionName)){
			$post['promotion_name'] = $getPromotionName;
		}
		if(!empty($post)){
			if(!empty($post['page'])){
				$action = MyHelper::post('promotion/list?page='.$post['page'], $post);
			} else {
				$action = MyHelper::post('promotion/list', $post);
			}
		} else {
			$action = MyHelper::get('promotion/list');
		}

		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result']['data'];
			$data['from'] = $action['result']['from'];
			$data['to'] = $action['result']['to'];
			$data['total'] = $action['result']['total'];
			$data['post'] = $post;
			$data['paginator'] = new LengthAwarePaginator($action['result']['data'], $action['result']['total'], $action['result']['per_page'], $action['result']['current_page'], ['path' => url()->current()]);
			return view('promotion::index', $data);
		} else{
			return redirect('promotion/create')->withErrors($action['messages']);
		}
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
		$data = [ 'title'             => 'Promotion',
				  'menu_active'       => 'promotion',
				  'submenu_active'    => 'promotion-create'
				];
				
		$getCity = MyHelper::get('city/list');
		if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;
		
		$getProvince = MyHelper::get('province/list');
		if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;
        
		$getCourier = MyHelper::get('courier/list');
		if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = null;
		
		$getOutlet = MyHelper::get('outlet/list');
		if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = null;
		
		$getProduct = MyHelper::get('product/list');
		if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = null;
		
		$getTag = MyHelper::get('product/tag/list');
		if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

		$getMembership = MyHelper::post('membership/list',[]);
		if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];
		
        return view('promotion::create-step-1',$data);
    }
	
    public function store(Request $request)
    {
		$post = $request->except("_token");
		// print_r($post);exit;
		$action = MyHelper::post('promotion/create', $post);
		// print_r($action);exit;
		if($action['status'] == 'success'){
			return redirect('promotion/step2/'.$action['promotion']['id_promotion']);
		} else{
			return back()->withErrors($action['messages']);
		}
    }
	
	public function step1($id_promotion){
		$action = MyHelper::post('promotion/step2', ['id_promotion' => $id_promotion]);
		// print_r($action);exit;
		if($action['status'] == 'success'){
			$data = [ 'title'		  => 'Promotion',
					  'menu_active'       => 'promotion',
					  'submenu_active'    => 'promotion-create'
				];
			
			$data['result'] = $action['result'];
			
			$getCity = MyHelper::get('city/list');
			if(isset($getCity['status']) && $getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;
			
			$getProvince = MyHelper::get('province/list');
			if(isset($getProvince['status']) && $getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;
			
			$getCourier = MyHelper::get('courier/list');
			if(isset($getCourier['status']) && $getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = null;
			
			$getOutlet = MyHelper::get('outlet/list');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = null;
			
			$getProduct = MyHelper::get('product/list');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = null;
			
			$getTag = MyHelper::get('product/tag/list');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

			$getMembership = MyHelper::post('membership/list',[]);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];
		
			return view('promotion::create-step-1', $data);
		} else{
			return back()->withErrors($action['messages']);
		}
    }
	
	public function step1Post(Request $request, $id_promotion){
		$post = $request->except(['_token','sample_1_length','files']);
		$post['id_promotion'] = $id_promotion;
		// print_r($post);exit;
		$action = MyHelper::post('promotion/create', $post);
		// print_r($action);exit;
		if($action['status'] == 'success'){
			return redirect('promotion/step2/'.$id_promotion);
		} else{
			return back()->withErrors($action['messages']);
		}
	}
	
	public function step2($id_promotion){
		// echo $id_promotion;exit;
		$action = MyHelper::post('promotion/step2', ['id_promotion' => $id_promotion]);
		// dd($action);exit;
		if($action['status'] == 'success'){
			$data = [ 'title'		  => 'Promotion',
				  'menu_active'       => 'promotion',
				  'submenu_active'    => 'promotion-create'
				];
			$test = MyHelper::get('autocrm/textreplace');
			
			$data['result'] = $action['result'];
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}
			
			$getOutlet = MyHelper::get('outlet/list');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = null;
			
			$getProduct = MyHelper::get('product/list');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = null;
			
			$getTag = MyHelper::get('product/tag/list');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

			$getMembership = MyHelper::post('membership/list',[]);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];
		
			return view('promotion::create-step-2', $data);
		} else{
			return back()->withErrors($action['messages']);
		}
    }
	
	public function step2Post(Request $request, $id_promotion){
		$post = $request->except(['_token','sample_1_length','promotion_push_image','files']);
		$post['id_promotion'] = $id_promotion;
		
		
		if (isset($request['promotion_push_image'])) {
			foreach ($request['promotion_push_image'] as $key => $value) {
				$post['promotion_push_image'][$key] = MyHelper::encodeImage($value);
			}
		}

		if (isset($post['promotion_whatsapp_content'])) {
			foreach($post['promotion_whatsapp_content'] as $q => $content_series){
				foreach($content_series as $key => $content){
					if($content['content'] || isset($content['content_file']) && $content['content_file']){
						if($content['content_type'] == 'image'){
							$post['promotion_whatsapp_content'][$q][$key]['content'] = MyHelper::encodeImage($content['content']);
						}
						else if($content['content_type'] == 'file'){
							$post['promotion_whatsapp_content'][$q][$key]['content'] = base64_encode(file_get_contents($content['content_file']));
							$post['promotion_whatsapp_content'][$q][$key]['content_file_name'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_FILENAME);
							$post['promotion_whatsapp_content'][$q][$key]['content_file_ext'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_EXTENSION);
							unset($post['promotion_whatsapp_content'][$q][$key]['content_file']);
						}
					}
				}
			}
		}
		
		// dd($post);exit;
		$action = MyHelper::post('promotion/update', $post);
		// dd($action);exit;
		
		if(isset($action['status']) && $action['status'] == 'success'){
			if($post['promotion_type'] == 'Instant Campaign' && isset($post['send'])){
				$sendCampaign = MyHelper::post('promotion/queue', ['id_promotion' => $id_promotion]);
				if(isset($sendCampaign['status']) && $sendCampaign['status'] == 'success'){
					return redirect('promotion/step3/'.$id_promotion)->withSuccess(['Promotion will be sent to '.$sendCampaign['count_user'].' users.']);
				}
			}
			return redirect('promotion/step3/'.$id_promotion);
		} else{
			return back()->withErrors($action['messages']);
		}
    }
	
	public function step3($id_promotion, Request $request){
		$post = $request->except('_token');
		if ($request->ajax()) {
			if(isset($post['page'])){
				$recipient = MyHelper::post('promotion/recipient/list?page='.$post['page'], ['id_promotion' => $id_promotion]);
			}else{
				$recipient = MyHelper::post('promotion/recipient/list', ['id_promotion' => $id_promotion]);
			}
			$data['users'] = new LengthAwarePaginator($recipient['result']['data'], $recipient['result']['total'], $recipient['result']['per_page'], $recipient['result']['current_page'], ['path' => url()->current()]);
			$data['from'] = $recipient['result']['from'];
			$data['to'] = $recipient['result']['to'];
			$data['total'] = $recipient['result']['total'];

			$data['result'] = Session::get('resultStep3');

			return view('promotion::recipient', $data)->render();  
		}else{
			$action = MyHelper::post('promotion/step2', ['id_promotion' => $id_promotion, 'summary' => true]);
			// dd($action);exit;
			if($action['status'] == 'success'){
				$data = [ 'title'		  => 'Promotion',
					  'menu_active'       => 'promotion',
					  'submenu_active'    => 'promotion-create'
					];
				$data['result'] = $action['result'];
				Session::put('resultStep3', $action['result']);

				$getCity = MyHelper::get('city/list');
				if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;
				
				$getProvince = MyHelper::get('province/list');
				if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;
				
				$getCourier = MyHelper::get('courier/list');
				if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = null;
				
				$getOutlet = MyHelper::get('outlet/list');
				if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = null;
				
				$getProduct = MyHelper::get('product/list');
				if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = null;
				
				$getTag = MyHelper::get('product/tag/list');
				if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

				$getMembership = MyHelper::post('membership/list',[]);
				if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];
		
				if(isset($post['page'])){
					$recipient = MyHelper::post('promotion/recipient/list?page='.$post['page'], ['id_promotion' => $id_promotion]);
				}else{
					$recipient = MyHelper::post('promotion/recipient/list', ['id_promotion' => $id_promotion]);
				}
	
				$data['users'] = new LengthAwarePaginator($recipient['result']['data'], $recipient['result']['total'], $recipient['result']['per_page'], $recipient['result']['current_page'], ['path' => url()->current()]);
				
				$data['from'] = $recipient['result']['from'];
				$data['to'] = $recipient['result']['to'];
				$data['total'] = $recipient['result']['total'];

				if(!$data['from']) $data['from'] = 0;
				if(!$data['to']) $data['to'] = 0;

				return view('promotion::create-step-3', $data);
			} else{
				return back()->withErrors($action['messages']);
			}
		}
	}
	
	public function sentList($id_promotion_content, $page = null, $type = null){
		if($page == null){
			if($type == null){
				$data = MyHelper::post('promotion/sent/list', ['id_promotion_content' => $id_promotion_content]);
			}else{
				$data = MyHelper::post('promotion/sent/list', ['id_promotion_content' => $id_promotion_content, $type => true]);
			}
		}else{
			if($type == null){
				$data = MyHelper::post('promotion/sent/list?page='.$page, ['id_promotion_content' => $id_promotion_content]);
			}else{
				$data = MyHelper::post('promotion/sent/list?page='.$page, ['id_promotion_content' => $id_promotion_content, 'type' => $type]);
			}
		}
		if (isset($data['status']) && $data['status'] == 'success') {
			$list = $data['result'];
		}else{
			$list = [];
		}
		return $list;
	}

	public function voucherList($id_promotion_content, $page = null, $type=null){
		if($page == null){
			if($type == null){
				$data = MyHelper::post('promotion/voucher/list', ['id_promotion_content' => $id_promotion_content]);
			}else{
				$data = MyHelper::post('promotion/voucher/list', ['id_promotion_content' => $id_promotion_content, $type=>true]);
			}
		}else{
			if($type == null){
				$data = MyHelper::post('promotion/voucher/list?page='.$page, ['id_promotion_content' => $id_promotion_content]);
			}else{
				$data = MyHelper::post('promotion/voucher/list?page='.$page, ['id_promotion_content' => $id_promotion_content, $type=>true]);
			}
		}
		if (isset($data['status']) && $data['status'] == 'success') {
			$list = $data['result'];
		}else{
			$list = [];
		}
		return $list;
	}

	public function voucherTrx($id_promotion_content, $page = null){
		if($page == null){
			$data = MyHelper::post('promotion/voucher/trx', ['id_promotion_content' => $id_promotion_content]);
		}else{
			$data = MyHelper::post('promotion/voucher/trx?page='.$page, ['id_promotion_content' => $id_promotion_content]);
		}
		if (isset($data['status']) && $data['status'] == 'success') {
			$list = $data['result'];
		}else{
			$list = [];
		}
		return $list;
	}

	public function linkClickedList($id_promotion_content, $page = null, $type){
		if($page == null){
			$data = MyHelper::post('promotion/linkclicked/list', ['id_promotion_content' => $id_promotion_content, 'type' => $type]);
		}else{
			$data = MyHelper::post('promotion/linkclicked/list?page='.$page, ['id_promotion_content' => $id_promotion_content, 'type' => $type]);
		}
		if (isset($data['status']) && $data['status'] == 'success') {
			$list = $data['result'];
		}else{
			$list = [];
		}
		return $list;
	}
	
    public function delete(Request $request){
		$post = $request->except('_token');
		$delete = MyHelper::post('promotion/delete', ['id_promotion' => $post['id_promotion']]);
		return $delete;
    }
}

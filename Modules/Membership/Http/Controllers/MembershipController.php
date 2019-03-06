<?php

namespace Modules\Membership\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function membershipList(Request $request) {
        $data = [ 'title'             => 'Membership List',
				  'menu_active'       => 'membership',
				  'submenu_active'    => 'membership-list'
				];
				
		$post = $request->except('_token');
		if(!empty($post)){
			
			$post['membership'] = array_values($post['membership']);
			// dd($post);exit;
			foreach($post['membership'] as $key => $membership){
				if (isset($membership['membership_image'])) {
					$post['membership'][$key]['membership_image'] = MyHelper::encodeImage($membership['membership_image']);
				}  else {
					$post['membership'][$key]['membership_image'] = "";
				}
			}
			$action = MyHelper::post('membership/update', $post);
			// dd($action);exit;
			if(isset($action['status']) && $action['status'] == 'success'){
				session(['success' => ['Membership has been updated']]);
				return redirect('membership');
			} else{
				return redirect('membership')->withErrors($action['messages']);
			}
		} else {
			$action = MyHelper::post('membership/list', []);
			if(isset($action['status']) && $action['status'] == 'success'){
				$data['result'] = $action['result'];
				$data['post'] = $post;
				// print_r($data);exit;
				return view('membership::list', $data);
			} else{
				return view('membership::list', $data);
			}
		}
    }

    
    public function create(Request $request) {
		$post = $request->except('_token');
		$data = [
                'title'          => 'New Membership',
                'menu_active'    => 'membership',
                'submenu_active' => 'membership-new',
            ];
        if (empty($post)) {
			return view('membership::create', $data);
		} else {
			// print_r($post);exit;
			$save = MyHelper::post('membership/create', $post);
			if (isset($save['status']) && $save['status'] == "success") {
				session(['success' => ['New membership has been created']]);
				return redirect('membership/create');
			}
			else {
                return redirect('membership/create')->withErrors($save['messages']);
			}
		}
    }
	
	public function update(Request $request, $id_membership) {
		$post = $request->except('_token');
		$data = [
                'title'          => 'Update Membership',
                'menu_active'    => 'membership',
                'submenu_active' => 'membership-list',
            ];
        if (empty($post)) {
			$query = MyHelper::post('membership/list', ['id_membership' => $id_membership]);
			if (isset($query['status']) && $query['status'] == "success") {
				$data['data'] = $query['result'][0];
				return view('membership::update', $data);
			}
			else {
                return redirect('membership')->withErrors($query['messages']);
			}
		} else {
			$post['id_membership'] = $id_membership;
			$save = MyHelper::post('membership/update', $post);
			if (isset($save['status']) && $save['status'] == "success") {
				session(['success' => ['Membership has been updated']]);
				return redirect('membership');
			}
			else {
                return redirect('membership/update/'.$id_membership)->withErrors($save['messages']);
			}
		}
    }
	
	public function delete($id_membership) {
		$save = MyHelper::post('membership/delete', ['id_membership' => $id_membership]);
		// print_r($save);exit;
		if (isset($save['status']) && $save['status'] == "success") {
			session(['success' => ['Membership has been deleted']]);
			return redirect('membership');
		}
		else {
			return redirect('membership')->withErrors($save['messages']);
		}
	}
	
	public function detailWebview(Request $request)
    {
		$bearer = $request->header('Authorization');
        if ($bearer == "") {
			$bearer = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ0ZmE5NmIzYjdhYTc4NWM2NThlYzlhZDA4ZjYxN2E2N2M5YTkxNDE1ZmY3Y2UwZDEyZDkxOGVlNjZjNDEzYzMwZWZiNDYyZGU5ZjVhMDM2In0.eyJhdWQiOiIyIiwianRpIjoiZDRmYTk2YjNiN2FhNzg1YzY1OGVjOWFkMDhmNjE3YTY3YzlhOTE0MTVmZjdjZTBkMTJkOTE4ZWU2NmM0MTNjMzBlZmI0NjJkZTlmNWEwMzYiLCJpYXQiOjE1NDY0Nzk0MzcsIm5iZiI6MTU0NjQ3OTQzNywiZXhwIjoxNTc4MDE1NDM3LCJzdWIiOiIzIiwic2NvcGVzIjpbIioiXX0.lfaUcgDutdJ9UkzY509qrOtfoxteZMTGO0tuXPWVd8Yq3mi5mIFxDYrChfwmVhntTpni31sreY_ivRVWp5Y0dlnVnR_yVUVPp5Cf5lzxkgTfMkktMLGD906TaSuuCF2aA-KAoIqhJMX42ZoZUM0xRaAhqOROIifzUuxVwNTLGDNqPi_VMDjmHZE2sI8gtrV69MhjBgqjLbp0lWSzQLkl5gSsTuE4giqMGjnUIJtYhqHzUkUYvcdTRtokzxoTFAowRU0WkwSy6K0kReBM0S8J41YrL1-62tPnKMqZFUz4l8DIkaRS6Zf9agxQ8cU2wz9I8QqDRt2xUNtWf8xbvLS4CevOHB4ZoPaUx1T9qzmzxul4CACYCYrBdjJst_LlJRd2HokPe_XQQtByjc3yMzgpwfxW2uyfL1DVzsG5fOrMraqEeRrxei3gafEQIamHDRv8StLHkF4zFpY-lg5fqQnC0RMIUXVfGuzsNv19uydwwYtONSPHTEhXNfodf2cV91C5Wtp80yG2GXfqkCZr-TGSBj6j1ZWlHV9fhkxiGBDyEbe25nurXvHSGZwQXWaQmwyaH-hW9XFXK23_xrZW9nMy60SQIeB9PsF-FVJ8sK6TIbEfP3cehnXpeuhS4Y5UFUsyK6zQD1UV6mD7bGPNXdUgOnRPEOYlb7mKlHZ82EPzuDc";
            // return view('error', ['msg' => 'Unauthenticated']);
		}
		
    	$data = json_decode(base64_decode($request->get('data')), true);
    	$data['check'] = 1;
    	$check = MyHelper::postWithBearer('membership/detail/webview', $data, $bearer);
        // return $check;
    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data = $check['result'];
		} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
		}
		
        return view('membership::webview.detail_membership')->with(compact('data'));
    }
	
}

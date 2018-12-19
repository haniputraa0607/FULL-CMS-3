<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class WebviewUserController extends Controller
{
    // get webview form
    public function completeProfile($user_phone)
    {
        $user = parent::getData(MyHelper::postBiasa('users/get', ['phone' => $user_phone]));
        $data['cities'] = parent::getData(MyHelper::get('city/list'));

        // get only some data
        if ($user) {
            $user_data['phone']    = $user['phone'];
            $user_data['gender']   = $user['gender'];
            $user_data['birthday'] = $user['birthday'];
            $user_data['id_city']  = $user['id_city'];
            
            $data['user'] = $user_data;
        }
        else{
            $data['user'] = [];
        }

        return view('users::webview_complete_profile', $data);
    }

    public function completeProfileSubmit(Request $request, $user_phone)
    {
        $post = $request->except('_token');
        $post['phone'] = $user_phone;

        // convert date format
        if (isset($post['birthday'])) {
            $post['birthday'] = date('Y-m-d', strtotime($post['birthday']));
        }
        
        $result = MyHelper::post('users/complete-profile', $post);
        // dd($result);

        if ($result['status']=="success") {
            $data['messages'] = ["Save data success", "Thank you"];
            return view('users::webview_complete_profile_success', $data);
        }
        else{
            return back()->withInput()->withErrors(['Save data fail', 'Please check again your input']);
        }
    }
    
    // when user skip profile form
    public function completeProfileLater($user_phone)
    {
        $post['phone'] = $user_phone;
        $result = MyHelper::post('users/complete-profile/later', $post);

        return $result;
    }
}

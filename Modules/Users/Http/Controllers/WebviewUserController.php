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
    public function completeProfile(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }
        $data['bearer'] = $bearer;

        $user = parent::getData(MyHelper::getWithBearer('users/get', $bearer));
        if (empty($user)) {
            return [
                'status' => 'fail',
                'message' => 'Unauthenticated'
            ];
        }

        $data['cities'] = parent::getData(MyHelper::get('city/list'));

        $data['user'] = [];
        // get only some data
        if ($user) {
            $user_data['phone']    = $user['phone'];
            $user_data['gender']   = $user['gender'];
            $user_data['birthday'] = $user['birthday'];
            $user_data['id_city']  = $user['id_city'];
            
            $data['user'] = $user_data;
        }
        
        return view('users::webview_complete_profile', $data);
    }

    public function completeProfileSubmit(Request $request)
    {
        $post = $request->except('_token');
        $bearer = $post['bearer'];
        unset($post['bearer']);

        // convert date format
        if (isset($post['birthday'])) {
            $post['birthday'] = date('Y-m-d', strtotime($post['birthday']));
        }

        $result = MyHelper::postWithBearer('users/complete-profile', $post, $bearer);

        if (isset($result['status']) && $result['status']=="success") {
            $data['content'] = $result['result'];
            return view('users::webview_complete_profile_success', $data);
            // return redirect('webview/complete-profile/success');
        }
        else{
            return back()->withInput()->withErrors(['Save data fail']);
        }
    }

    /*public function completeProfileSuccess(Request $request)
    {
        $data['messages'] = ["Save data success", "Thank you"];
        return view('users::webview_complete_profile_success', $data);
    }*/

}

<?php
namespace Modules\Outlet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class WebviewGofoodController extends Controller
{
    public function listOutletGofood(Request $request)
    {
    	$bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

    	$post = $request->all();
    	// $post['latitude'] = '-7.803761';
    	// $post['longitude'] = '110.383058';
        $list = MyHelper::post('outlet/list/gofood', $post);
        // return $list;
        if (isset($list['status']) && $list['status'] == 'success') {
            return view('outlet::webview.outlet_gofood', ['outlet' => $list['result']]);
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }
    }
}

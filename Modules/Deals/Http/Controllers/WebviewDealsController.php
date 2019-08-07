<?php

namespace Modules\Deals\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class WebviewDealsController extends Controller
{
    // webview deals detail
    public function dealsDetail(Request $request, $id_deals, $deals_type)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $post['id_deals'] = $id_deals;
        $post['publish'] = 1;
        $post['deals_type'] = $deals_type;
        $post['web'] = 1;

        $data['deals'] = parent::getData(MyHelper::postWithBearer('deals/list', $post, $bearer));

        if (empty($data['deals'])) {
            return [
                'status' => 'fail',
                'messages' => ['Deals is not found']
            ];
        }

        return view('deals::deals.webview.deals_detail', $data);
    }

}

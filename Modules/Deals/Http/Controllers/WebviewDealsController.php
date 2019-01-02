<?php

namespace Modules\Deals\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class WebviewDealsController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function dealsDetail($id_deals, $deals_type)
    {
        $post['id_deals'] = $id_deals;
        $post['publish'] = 1;
        $post['deals_type'] = $deals_type;
        
        $data['deals'] = parent::getData(MyHelper::post('deals/list', $post));
        // dd($data);
        
        return view('deals::deals.webview.deals_detail', $data);
    }

}

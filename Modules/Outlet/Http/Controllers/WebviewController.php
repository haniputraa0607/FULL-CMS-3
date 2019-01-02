<?php

namespace Modules\Outlet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class WebviewController extends Controller
{
    public function detailWebview($id)
    {
        $list = MyHelper::post('outlet/list', ['id_outlet' => $id]);
        // return $list;
        return view('outlet::webview.list', ['data' => $list['result']]);
    }
}

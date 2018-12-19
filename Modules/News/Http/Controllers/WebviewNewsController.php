<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class WebviewNewsController extends Controller
{
    public function detail($id)
    {
        $news = MyHelper::post('news/list/web', ['id_news'=> $id]);
        if (isset($news['status']) && $news['status'] == 'success') {
            // return $news['result'];
            return view('news::webview.news', ['news' => $news['result']]);
        } else {
            return view('news::webview.fail');
        }
    }
}
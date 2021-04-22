<?php

namespace Modules\Quest\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportQuestController extends Controller
{
    function reportQuest(Request $request){
        $post = $request->all();

        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Report Quest',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-report'
        ];

        if(Session::has('filter-report-quest') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-report-quest');
            $post['page'] = $page;
        }else{
            Session::forget('filter-report-quest');
        }

        $getData = MyHelper::post('quest/report', $post);

        if (isset($getData['status']) && $getData['status'] == "success") {
            $data['data']          = $getData['result']['data'];
            $data['dataTotal']     = $getData['result']['total'];
            $data['dataPerPage']   = $getData['result']['from'];
            $data['dataUpTo']      = $getData['result']['from'] + count($getData['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getData['result']['data'], $getData['result']['total'], $getData['result']['per_page'], $getData['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if($post){
            Session::put('filter-report-quest',$post);
        }
        return view('quest::report.list', $data);
    }
}

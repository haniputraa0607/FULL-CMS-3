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

    function reportDetail(Request $request, $id_quest){
        $post = $request->all();
        $post['id_quest'] = $id_quest;

        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Report Detail Quest',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-report'
        ];

        $detail = MyHelper::post('quest/report/detail', $post);

        if ( ($detail['status'] ?? false) == 'success') {
        	$data['detail'] = $detail['result'];
        }else{
        	return redirect('quest/report')->withErrors($detail['messages'] ?? ['Detail report not found']);
        }

        return view('quest::report.detail', $data);
    }

    function reportListUser(Request $request, $id_quest){
        $post = $request->all();
        $post['id_quest'] = $id_quest;
        $draw = $post['draw'] ?? 10;

        $page = 1;
        if(isset($post['start']) && isset($post['length'])){
            $page = $post['start']/$post['length'] + 1;
        }
        $getDataListUser = MyHelper::post('quest/report/list/user-quest?page='.$page, $post);

        if(isset($getDataListUser['status']) && $getDataListUser['status'] == 'success'){
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $getDataListUser['result']['total'];
            $arr_result['recordsFiltered'] = $getDataListUser['result']['total'];
            $arr_result['data'] = $getDataListUser['result']['data'];
        }else{
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }
}

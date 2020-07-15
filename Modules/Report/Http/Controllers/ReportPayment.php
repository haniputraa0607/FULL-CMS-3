<?php

namespace Modules\Report\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;
use Session;
use Excel;

class ReportPayment extends Controller
{
    function index(Request $request, $type){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-payment',
            'sub_title'      => 'Report Payment '.ucfirst($type),
            'submenu_active' => 'report-payment-'.$type,
        ];

        if(Session::has('filter-list-payment-'.$type) && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-list-payment-'.$type);
            $post['page'] = $page;
        }else{
            Session::forget('filter-list-payment-'.$type);
        }

        $report = MyHelper::post('report/payment/'.$type, $post);

        if (isset($report['status']) && $report['status'] == "success") {
            $data['data']          = $report['result']['data'];
            $data['dataTotal']     = $report['result']['total'];
            $data['dataPerPage']   = $report['result']['from'];
            $data['dataUpTo']      = $report['result']['from'] + count($report['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($report['result']['data'], $report['result']['total'], $report['result']['per_page'], $report['result']['current_page'], ['path' => url()->current()]);
            $data['sum'] = 0;
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
            $data['sum'] = 0;
        }

        if($post){
            Session::put('filter-list-payment-'.$type);
        }
        return view('report::report_payment.index', $data);
    }

    function export(Request $request, $type){
        $post = $request->except('_token');

        if(Session::has('filter-list-payment-'.$type) && !isset($post['filter'])){
            $post = Session::get('filter-list-payment-'.$type);
        }
        $post['export'] = 1;
        $report = MyHelper::post('report/payment/'.$type, $post);

        if (isset($report['status']) && $report['status'] == "success") {
            $arr['All Type'] = $report['result'];
            $data = new MultisheetExport($arr);
            return Excel::download($data,'report_payment_'.date('dmYHis').'.xls');
        }else{
            return redirect('report/payment')->withErrors(['No data to export']);
        }
    }
}

<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class SingleReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-single',
            'sub_title'      => 'Report',
            'submenu_active' => 'report-single'
        ];

        // get report year
        $data['year_list'] = [date('Y')];
        $year_list = MyHelper::get('report/single/year-list');
        if (isset($year_list['status']) && $year_list['status']=='success' ) {
            $data['year_list'] = $year_list['result'];
        }
        // get outlet list
        $data['outlets'] = [];
        $outlets = MyHelper::get('report/single/outlet-list');
        if (isset($outlets['status']) && $outlets['status']=='success' ) {
            $data['outlets'] = $outlets['result'];
        }
        // get product list
        $data['products'] = [];
        $products = MyHelper::get('report/single/product-list');
        if (isset($products['status']) && $products['status']=='success' ) {
            $data['products'] = $products['result'];
        }
        // get membership list
        $data['memberships'] = [];
        $memberships = MyHelper::get('report/single/membership-list');
        if (isset($memberships['status']) && $memberships['status']=='success' ) {
            $data['memberships'] = $memberships['result'];
        }

        $today = date('Y-m-d');
        $one_week_ago = date("Y-m-d", strtotime("-16 week"));

        $post['time_type'] = 'day';
        $post['param1'] = $one_week_ago;
        $post['param2'] = $today;

        if (!empty($data['products'])) {
            $post['id_product'] = $data['products'][0]['id_product'];
            $post['product_name'] = $data['products'][0]['product_name'];
        }
        if (!empty($data['memberships'])) {
            $post['id_membership'] = $data['memberships'][0]['id_membership'];
            $post['membership_name'] = $data['memberships'][0]['membership_name'];
        }
        $data['filter'] = $post;

        // get report
        $data['report'] = [];
        $report = MyHelper::post('report/single', $post);
        if (isset($report['status']) && $report['status']=='success' ) {
            $data['report'] = $report['result'];
        }
        // dd($data);
        // dd(empty($data['report']), count($data['report']));

        return view('report::single_report.single_report', $data);
    }

    // ajax get report
    public function singleReport(Request $request)
    {
        $post = $request->except('_token');

        $date_range = "";
        // request validation
        $fail = false;
        switch ($post['time_type']) {
            case 'day':
                if ($post['param1']=="" || $post['param2']=="") {
                    $fail = true;
                } else {
                    $post['param1'] = date('Y-m-d', strtotime($post['param1']));
                    $post['param2'] = date('Y-m-d', strtotime($post['param2']));

                    $date_range = date('d M Y', strtotime($post['param1'])) ." - ". date('d M Y', strtotime($post['param2']));
                }
                break;
            case 'month':
                if ($post['param1']=="" || $post['param2']=="") {
                    $fail = true;
                }
                else{
                    $month_name_1 = date('F', mktime(0, 0, 0, $post['param1'], 10));
                    $month_name_2 = date('F', mktime(0, 0, 0, $post['param2'], 10));
                    $date_range = $month_name_1 ." - ". $month_name_2 ." ". $post['param3'];
                }
                break;
            case 'year':
                if ($post['param1']=="") {
                    $fail = true;
                } else {
                    $date_range = $post['param1'] ." - ". $post['param2'];
                }
                break;
            
            default:
                $fail = true;
                break;
        }
        // return [$post, $date_range];
        if ($fail) {
            return [
                "status" => "fail",
                "messages" => ['Field is required']
            ];
        }

        $result = MyHelper::post('report/single', $post);
        $result['date_range'] = $date_range;
        
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('report::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('report::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}

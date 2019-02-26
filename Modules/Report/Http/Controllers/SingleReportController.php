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

        // get outlet list
        $data['outlets'] = [];
        $outlets = MyHelper::get('report/single/outlet-list');
        if (isset($outlets['status']) && $outlets['status']=='success' ) {
            $data['outlets'] = $outlets['result'];
        }

        // get report year
        $data['year_list'] = [date('Y')];
        $year_list = MyHelper::get('report/single/year-list');
        if (isset($year_list['status']) && $year_list['status']=='success' ) {
            $data['year_list'] = $year_list['result'];
        }

        $today = date('Y-m-d');
        $one_week_ago = date("Y-m-d", strtotime("-15 week"));

        $post['time_type'] = 'day';
        $post['param1'] = $one_week_ago;
        $post['param2'] = $today;

        $data['filter'] = $post;

        // get report
        $data['report'] = [];
        $report = MyHelper::post('report/single', $post);
        if (isset($report['status']) && $report['status']=='success' ) {
            $data['report'] = $report['result'];
        }
        // dd($data);

        return view('report::single_report.single_report', $data);
    }

    // ajax get report
    public function singleReport(Request $request)
    {
        $post = $request->except('_token');

        // request validation
        $fail = false;
        switch ($post['time_type']) {
            case 'day':
                if ($post['param1']=="" || $post['param2']=="") {
                    $fail = true;
                } else {
                    $post['param1'] = date('Y-m-d', strtotime($post['param1']));
                    $post['param2'] = date('Y-m-d', strtotime($post['param2']));
                }
                break;
            case 'month':
                if ($post['param1']=="" || $post['param2']=="") {
                    $fail = true;
                } /*else {
                    $post['month'] = $post['param1'];
                    $post['year'] = $post['param2'];
                }*/
                break;
            case 'year':
                if ($post['param1']=="") {
                    $fail = true;
                } /*else {
                    $post['year'] = $post['param1'];
                }*/
                break;
            
            default:
                $fail = true;
                break;
        }
        if ($fail) {
            return [
                "status" => "fail",
                "messages" => ['Field is required']
            ];
        }
        // return $post;

        // unset($post['param1']);
        // unset($post['param2']);

        $result = MyHelper::post('report/single', $post);
        /*if (isset($result['status']) && $result['status'] == "success") {
            $data['result'] = $result;
        }
        else {
            $data['items'] = [];
        }*/
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

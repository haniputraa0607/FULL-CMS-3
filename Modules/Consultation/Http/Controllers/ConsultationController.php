<?php

namespace Modules\Consultation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class ConsultationController extends Controller
{
    // public function index()
    // {
    //     return view('consultation::index');
    // }

    public function consultationList() {
        $data = [];
        $data = [
            'title'          => 'Consultation',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-list'
        ];

        $list = MyHelper::get('consultation');

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['list'] = $list['result'];
        } else {
            return view('consultation::consultationList', $data)->withErrors($list['messages']);
        }

        return view('consultation::consultationList', $data);
    }

    public function consultationSearch() {
        $data = [];
        $data = [
            'title'   => 'Consultation',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-search'
        ];

        $getList = MyHelper::get('consultation');
        if($getList['status'] == 'success') $data['list'] = $getList['result']; else $data['list'] = null;

        $getCity = MyHelper::get('city/list');
        if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;

        $getProvince = MyHelper::get('province/list');
        if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;
        
		$getCourier = MyHelper::get('courier/list');
		if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = null;
		
		// return $data;
        return view('consultation::consultationSearch', $data);
    }

    public function consultationFilter(Request $request) {
        $post = $request->all();

        if (empty($post)) {
            return redirect('consultation/search');
        }

        $data = [];
        $data = [
            'title'   => 'Consultation',
            'sub_title'   => 'Filter',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-search'
        ];

        $filter = MyHelper::post('consultation/filter', $post);
       
        if (isset($filter['status']) && $filter['status'] == 'success') {
            $data['list']       = $filter['data'];
            $data['conditions'] = $filter['conditions'];
            $data['count']      = $filter['count'];
            $data['rule']       = $filter['rule'];
            $data['search']     = $filter['search'];
            return view('consultation::consultationSearch', $data);

        } elseif (isset($filter['status']) && $filter['status'] == 'fail') {
            $data['list']       = $filter['data'];
            $data['conditions'] = $filter['conditions'];
            $data['count']      = $filter['count'];
            $data['rule']       = $filter['rule'];
            $data['search']     = $filter['search'];

            return view('consultation::consultationSearch', $data);

        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Consultation',
            'sub_title'      => 'Consultation List',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-list',
            'filter_title'   => 'Filter Consultation',
        ];

        if(session('list_consultation_filter')){
            $extra=session('list_consultation_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('be/consultation', $post + $extra )['result'] ?? [];
            $data['recordsFiltered'] = $data['total'] ?? 0;
            $data['recordsTotal'] = $data['total'] ?? 0;
            $data['draw'] = $request->draw;

            return $data;
        }

        return view('consultation::index', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            session(['list_consultation_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_consultation_filter'=>null]);
            return back();
        }

        return abort(404);
    }
    
    public function detail($id)
    {
        $data = [
            'title'          => 'Consultation',
            'sub_title'      => 'Consultation List',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-list',
        ];

        $doctor = MyHelper::get('be/consultation/detail/'.$id);

        dd($doctor);

        return view('consultation::detail', $data);
    }
}

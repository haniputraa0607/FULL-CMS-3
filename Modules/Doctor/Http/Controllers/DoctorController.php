<?php

namespace Modules\Doctor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Doctor',
            'sub_title'      => 'Doctor List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-list',
            'filter_title'   => 'Filter Doctor',
        ];

        if(session('list_doctor_filter')){
            $extra=session('list_doctor_filter');
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
            $data = MyHelper::post('doctor', $post + $extra )['result'] ?? [];
            $data['recordsFiltered'] = $data['total'] ?? 0;
            $data['recordsTotal'] = $data['total'] ?? 0;
            $data['draw'] = $request->draw;

            return $data;
        }

        return view('doctor::index', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            session(['list_doctor_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_doctor_filter'=>null]);
            return back();
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Doctor',
            'sub_title'      => 'Doctor Create',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-create'
        ];

        $clinic = MyHelper::get('outlet/be/list');

        if (isset($clinic['status']) && $clinic['status'] == "success") {
            $data['clinic'] = $clinic['result'];
        } 

        $service = MyHelper::get('doctor/service');

        if (isset($service['status']) && $service['status'] == "success") {
            $data['service'] = $service['result'];
        }

        $specialist = MyHelper::get('doctor/specialist');

        if (isset($specialist['status']) && $specialist['status'] == "success") {
            $data['specialist'] = $specialist['result'];
        }

        $data['id_outlet'] = $post['id_outlet']??null;

        return view('doctor::form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        if(isset($post['doctor_photo']) && !empty($post['doctor_photo'])){
            $post['doctor_photo'] = MyHelper::encodeImage($post['doctor_photo']);
        }
        $post['pin'] = null;
        $store = MyHelper::post('doctor/store', $post);

        if(($store['status']??'')=='success'){
            return redirect('doctor')->with('success',['Create Doctor Success']);
        }else{
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('doctor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Clinic',
            'sub_title'      => 'Clinic Edit',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-clinic'
        ];

        $doctor = MyHelper::get('doctor/detail/'.$id);

        $explode = explode( ", " , $doctor['result']['doctor_service']);
        $doctor['result']['doctor_service'] = $explode;

        if (isset($doctor['status']) && $doctor['status'] == "success") {
            $data['doctor'] = $doctor['result'];
        } else {
            $data['doctor'] = [];
        }
        
        $clinic = MyHelper::get('doctor/clinic');

        if (isset($clinic['status']) && $clinic['status'] == "success") {
            $data['clinic'] = $clinic['result'];
        } 

        $service = MyHelper::get('doctor/service');

        if (isset($service['status']) && $service['status'] == "success") {
            $data['service'] = $service['result'];
        }

        $specialist = MyHelper::get('doctor/specialist');

        if (isset($specialist['status']) && $specialist['status'] == "success") {
            $data['specialist'] = $specialist['result'];
        }

        $data['selected_id_specialist'] = array();
        foreach($data['doctor']['specialists'] as $row) {
            $data['selected_id_specialist'][] = $row['id_doctor_specialist'];
        }

        return view('doctor::form', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $post = $request->except('_method');
        if(isset($post['doctor_photo']) && !empty($post['doctor_photo'])){ $post['doctor_photo'] = MyHelper::encodeImage($post['doctor_photo']);} else {unset($post['doctor_photo']);}

        if(isset($post['doctor_service']) && !empty($post['doctor_service'])){$post['doctor_service'] = implode(',' , $post['doctor_service']);} else {$post['doctor_service'] = null;}
        
        $post['pin'] = null;
        
        $store = MyHelper::post('doctor/store', $post);

        if(($store['status']??'')=='success'){
            return redirect('doctor')->with('success',['Update Doctor Success']);
        }else{
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $result = MyHelper::post('doctor/delete', ['id_doctor' => $post['id_doctor']]);
        return $result;
    }
}

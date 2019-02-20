<?php

namespace Modules\Outlet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Lib\MyHelper;
use Excel;
use Validator;

class OutletController extends Controller
{
    /**
     * list
     */
    public function index(Request $request) {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet List',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list',
        ];

        // outlet
        $outlet = MyHelper::get('outlet/list');
        
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            $data['outlet'] = [];
        }

        return view('outlet::list', $data);
    }
	
	public function indexAjax(Request $request) {
        $outlet = MyHelper::get('outlet/list');

		if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data = $outlet['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }

    /**
     * create
     */
    public function create(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'New Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-new',
            ];
            
            // province
            $data['province'] = $this->getPropinsi();
        
            return view('outlet::create', $data);
        }
        else {
            if(isset($post['ampas'])){
                unset($post['ampas']);
            }
            if (isset($post['next'])) {
                $next = 1;
                unset($post['next']);
            }
            //cek pin confirmation
            if($post['outlet_pin'] != null){
                $validator = Validator::make($request->all(), [
                    'outlet_pin' => 'required|confirmed|min:6|max:6',
                ],[
                    'confirmed' => 'Re-type PIN does not match',
                    'min'       => 'PIN must 6 digit',
                    'max'       => 'PIN must 6 digit'
                ]);
        
                if ($validator->fails()) {
                    return back()
                            ->withErrors($validator)
                            ->withInput();
                }
            }

            if(!empty($post['outlet_open_hours'])) $post['outlet_open_hours'] = date('H:i:s', strtotime($post['outlet_open_hours']));
            if(!empty($post['outlet_open_hours'])) $post['outlet_close_hours'] = date('H:i:s', strtotime($post['outlet_close_hours']));
            
            $post = array_filter($post);

            $save = MyHelper::post('outlet/create', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                if (isset($next)) {
                    return parent::redirect($save, 'Outlet has been created.', 'outlet/detail/'.$save['result']['outlet_code'].'#photo');
                }
                else {
                    return parent::redirect($save, 'Outlet has been created.', 'outlet/list');
                }
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }
   
                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }
                   
                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
               }
           
        }
    }

    /*
    Detail
    */
    function detail(Request $request, $code) {

        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Detail Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-list',
            ];

            $outlet = MyHelper::post('outlet/list', ['outlet_code' => $code, 'qrcode' => 1, 'admin' => 1]);
            // return $outlet;

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet']    = $outlet['result'];
            }
            else {
                $e = ['e' => 'Data outlet not found.d'];
                return back()->witherrors($e);
            }

            // province
            $data['province'] = $this->getPropinsi();
            // return $data;
            // print_r($data); exit();
            return view('outlet::detail', $data);
        }
        else {

            //change pin
            if(isset($post['outlet_pin'])){
                $validator = Validator::make($request->all(), [
                    'outlet_pin' => 'required|confirmed|min:6|max:6',
                ],[
                    'confirmed' => 'Re-type PIN does not match',
                    'min'       => 'PIN must 6 digit',
                    'max'       => 'PIN must 6 digit'
                ]);
        
                if ($validator->fails()) {
                    return redirect('outlet/detail/'.$code.'#pin')
                                ->withErrors($validator)
                                ->withInput();
                }else{
                    $save = MyHelper::post('outlet/update/pin', $post);
                    return parent::redirect($save, 'Outlet pin has been changed.', 'outlet/detail/'.$code.'#pin'); 
                }
            }

            // photo
            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo']);

                // save
                $save          = MyHelper::post('outlet/photo/create', $post);
                return parent::redirect($save, 'Outlet photo has been added.', 'outlet/detail/'.$code.'#photo'); 
            }

            // order photo
            if (isset($post['id_outlet_photo'])) {
                for ($x= 0; $x < count($post['id_outlet_photo']); $x++) {
                    $data = [
                        'id_outlet_photo' => $post['id_outlet_photo'][$x],
                        'outlet_photo_order' => $x+1,
                    ];

                    /**
                     * save product photo
                     */
                    $save = MyHelper::post('outlet/photo/update', $data);
                   
                    if (!isset($save['status']) || $save['status'] != "success") {
                        return redirect('outlet/detail/'.$code.'#photo')->witherrors(['Something went wrong. Please try again.']);
                    }
                }

                return redirect('outlet/detail/'.$code.'#photo')->with('success', ['Photo\'s order has been updated']);
            }  

            // update
            if (isset($post['id_outlet'])) {
                if(!empty($post['outlet_open_hours'])) $post['outlet_open_hours']  = date('H:i:s', strtotime($post['outlet_open_hours']));
                if(!empty($post['outlet_open_hours'])) $post['outlet_close_hours'] = date('H:i:s', strtotime($post['outlet_close_hours']));

                $post = array_filter($post);
                $save = MyHelper::post('outlet/update', $post);
                if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Outlet has been updated.', 'outlet/detail/'.$code.'#info');
                }else {
                       if (isset($save['errors'])) {
                           return back()->withErrors($save['errors'])->withInput();
                       }
       
                       if (isset($save['status']) && $save['status'] == "fail") {
                           return back()->withErrors($save['messages'])->withInput();
                       }
                       
                       return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }
                      
            } 
        }
    }

    /*
    Propinsi
    */
    function getPropinsi() {
        $province = MyHelper::get('province/list');

        if (isset($province['status']) && $province['status'] == "success") {
            return $province['result'];
        }
        else {
            return [];
        }
    }

    // get city
    function getCity(Request $request) {
        $post = $request->except('_token');

        $query = MyHelper::post('city/list', $post);

        return $query;
    }

    /**
     * delete photo
     */
    function deletePhoto(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/photo/delete', ['id_outlet_photo' => $post['id_outlet_photo']]);
       
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /* DELETE OUTLET */
    function delete(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/delete', ['id_outlet' => $post['id_outlet']]);
        
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    public function Holiday(Request $request) {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet Holliday',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-holiday',
        ];
        $outlet = MyHelper::get('outlet/list');
        
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            return redirect('outlet/create')->withErrors('Create Outlet First');
        }

        $holiday = MyHelper::get('outlet/holiday/list');
        if (isset($holiday['status']) && $holiday['status'] == "success") {
            $data['holiday'] = $holiday['result'];
        }
        else {
            $data['holiday'] = [];
        }
        return view('outlet::outlet_holiday', $data);
    }

    public function createHoliday(Request $request) {
        $post = $request->except('_token');
        if (empty($post)) {
            
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Holliday',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-holiday',
            ];
            
            $outlet = MyHelper::get('outlet/list');
    
            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet'] = $outlet['result'];
            }
            else {
                return redirect('outlet/create')->withErrors('Create Outlet First');
            }
    
            return view('outlet::holiday', $data);
        }
        else {

            $post = array_filter($post);

            $save = MyHelper::post('outlet/holiday/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Outlet Holiday has been created.');
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }
   
                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }
                   
                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
               }
        }
    }

    function deleteHoliday(Request $request) {
        $post   = $request->all();
        
        $delete = MyHelper::post('outlet/holiday/delete', ['id_holiday' => $post['id_holiday']]);
        
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    function detailHoliday(Request $request, $id_holiday) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Holliday',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-holiday',
            ];

            $holiday = MyHelper::post('outlet/holiday/list', ['id_holiday' => $id_holiday]);


            if (isset($holiday['status']) && $holiday['status'] == "success") {
                $data['holiday']    = $holiday['result'][0];
            }
            else {
                $e = ['e' => 'Data outlet holiday not found.'];
                return back()->witherrors($e);
            }

            $outlet = MyHelper::get('outlet/list');

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet'] = $outlet['result'];
            }
            else {
                $e = ['e' => 'Data outlet not found.'];
                return redirect('outlet/list')->witherrors($e);
            }
            
            return view('outlet::outlet_holiday_update', $data);
        }
        //update
        else {

            $post['id_holiday'] = $id_holiday;
            $save = MyHelper::post('outlet/holiday/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Outlet Holiday has been updated.', 'outlet/holiday');
            }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    function import(Request $request) {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Export & Import Outlet',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-import',
        ];

        return view('outlet::import', $data);
    }

    function importOutlet(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Import Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-import',
            ];
    
            return view('outlet::import', $data);
        }else{
            if($request->file('import_file')){

                $path = $request->file('import_file')->getRealPath(); 
                $save = MyHelper::postFile('outlet/import', 'import_file', $path); 
                // dd($save);
                if (isset($save['status']) && $save['status'] == "success") { 
                    return parent::redirect($save, $save['message'], 'outlet/list'); 
                }else { 
                    if (isset($save['errors'])) { 
                        return back()->withErrors($save['errors'])->withInput(); 
                    } 
     
                    if (isset($save['status']) && $save['status'] == "fail") { 
                        return back()->withErrors($save['messages'])->withInput(); 
                    } 
                    return back()->withErrors(['Something when wrong. Please try again.'])->withInput(); 
                } 
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }else{
                return back()->withErrors(['File is required.'])->withInput();
            }
        }
    }

    function exportData(Request $request) {

        $outlet = MyHelper::get('outlet/export');
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data = $outlet['result'];
            $download = Excel::create('Data_Outlets_'.date('Ymdhis'), function($excel) use ($data) {
                $excel->sheet('Sheet 01', function($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->download('xls');

        }else {
            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }
        
    }

    function createAdminOutlet(Request $request, $outlet_code) {
        $post = $request->except('_token');
        if (empty($post)) {
            
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Admin',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-list',
            ];
            // get user
            $user = MyHelper::post('users/list',$post);
            if (isset($user['status']) && $user['status'] == "success") {
                $data['users'] = $user['result'];
            }
            else {
                $data['users'] = [];
            }
            return view('outlet::create_admin_outlet', $data);
        }
        else {

            $post['outlet_code'] = $outlet_code;
            unset($post['user']);
            $post = array_filter($post);
            $save = MyHelper::post('outlet/admin/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Admin Outlet has been created.', 'outlet/detail/'.$outlet_code.'#admin');
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }
   
                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }
                   
                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
               }
        }
    }

    function deleteAdminOutlet(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/admin/delete', $post);
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    function detailAdminOutlet(Request $request, $outlet_code, $id_user_outlet){
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet Admin',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list',
        ];
        $post['outlet_code'] = $outlet_code;
        $post['id_user_outlet'] = $id_user_outlet;
        $get = MyHelper::post('outlet/admin/detail', $post);
        if (isset($get['status']) && $get['status'] == "success") {
            $data['user_outlet'] = $get['result'];
        }else {
            if (isset($get['errors'])) {
                return back()->withErrors($get['errors'])->withInput();
            }

            if (isset($get['status']) && $get['status'] == "fail") {
                return back()->withErrors($get['messages'])->withInput();
            }
            
            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }
        
        return view('outlet::edit_admin_outlet', $data);
    }

    function updateAdminOutlet(Request $request, $outlet_code) {
        $post = $request->except('_token');

        $post = array_filter($post);
        $save = MyHelper::post('outlet/admin/update', $post);
        if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Admin Outlet has been updated.', 'outlet/detail/'.$outlet_code.'#admin');
        }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
    }

    public function getUser(Request $request) {
        $post = $request->except('_token');
        if(isset($post['q'])){
            $post['conditions'][0] = array(
                ['subject' => 'name', 'operator' => 'like', 'parameter' => $post['q']],
                ['subject' => 'email', 'operator' => 'like', 'parameter' => $post['q']],
                ['subject' => 'phone', 'operator' => 'like', 'parameter' => $post['q']]
            );
            $post['conditions'][0]['rule'] = 'or';
            $post['conditions'][0]['rule_next'] = 'or';
            unset($post['q']);
        }
        
        $user = parent::getData(MyHelper::post('users/list', $post));

        return $user;
    }

    public function scheduleSave(Request $request)
    {
        $post = $request->except('_token');

        $save = MyHelper::post('outlet/schedule/save', $post);
        if (isset($save['status']) && $save['status'] == 'success') {
            return back()->with(['success' => ['Update schedule success']]);
        }

        return back()->withErrors(['Update failed']);
    }

    public function qrcodePrint()
    {
        $outlet = MyHelper::post('outlet/list', ['qrcode'=>true]);
        
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            $data['outlet'] = [];
        }
        return view('outlet::qrcode', $data);
    }

    public function qrcodeView(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet QRCode',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-qrcode',
        ];

        if(isset($post['page'])){
            $outlet = MyHelper::post('outlet/list?page='.$post['page'], ['qrcode'=>true, 'qrcode_paginate'=>true]);
        }else{
            $outlet = MyHelper::post('outlet/list', ['qrcode'=>true, 'qrcode_paginate'=>true]);
        }
        
        $data['from'] = 0;
        $data['to'] = 0;
        $data['total'] = 0;
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['paginator'] = new LengthAwarePaginator($outlet['result']['data'], $outlet['result']['total'], $outlet['result']['per_page'], $outlet['result']['current_page'], ['path' => url()->current()]);
            $data['outlet'] = $outlet['result']['data'];
            $data['from'] = $outlet['result']['from'];
            $data['to'] = $outlet['result']['to'];
            $data['total'] = $outlet['result']['total'];
        }
        else {
            $data['outlet'] = [];
        }
        return view('outlet::qrcode_view', $data);
    }
}

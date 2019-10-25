<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Brand',
            'sub_title'      => 'Brand List',
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-list',
        ];

        $brand = MyHelper::get('brand');

        if (isset($brand['status']) && $brand['status'] == "success") {
            $data['brand'] = $brand['result'];
        } else {
            $data['brand'] = [];
        }

        return view('brand::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'New Brand',
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-new',
        ];

        return view('brand::form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except(['_token']);

        $data = [
            'title'          => 'New Brand',
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-new',
        ];

        if (isset($post['logo_brand']) && $post['logo_brand'] != null) {
            $post['logo_brand'] = MyHelper::encodeImage($post['logo_brand']);
        }

        if (isset($post['image_brand']) && $post['image_brand'] != null) {
            $post['image_brand'] = MyHelper::encodeImage($post['image_brand']);
        }

        $action = MyHelper::post('brand/store', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('brand/show/' . $action['result']['id_brand']);
        } else {
            return redirect('brand/create')->withInput()->withErrors($action['messages']);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id_brand)
    {
        $data = [
            'title'          => 'New Brand',
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-new',
        ];

        $action = MyHelper::post('brand/show', ['id_brand' => $id_brand]);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            return view('brand::form', $data);
        } else {
            return redirect('brand/create')->withInput()->withErrors($action['messages']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post   = $request->all();

        $delete = MyHelper::post('brand/delete', ['id_brand' => $post['id_brand']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function inactiveImage(Request $request){
        $data = [
            'title'          => 'Inactive Brand Image',
            'menu_active'    => 'brand',
            'submenu_active' => 'inactive-brand-image',
        ];

        $post=$request->except('_token');
        if($post){
            if (isset($post['logo_brand']) && $post['logo_brand'] != null) {
                $post['logo_brand'] = MyHelper::encodeImage($post['logo_brand']);
            }

            if (isset($post['image_brand']) && $post['image_brand'] != null) {
                $post['image_brand'] = MyHelper::encodeImage($post['image_brand']);
            }

            $action = MyHelper::post('brand/inactive-image', $post);
            if(($action['status']??false)=='success'){
                return redirect('brand/inactive-image')->with('success',['Upload image success']);
            }
            return back()->withErrors($action['messages']??['Upload image fail']);
        }else{
            $data['inactive_logo_brand'] = MyHelper::get('setting/get/inactive_logo_brand')['result']['value']??null;
            $data['inactive_image_brand'] = MyHelper::get('setting/get/inactive_image_brand')['result']['value']??null;
            return view('brand::inactive-image', $data);
        }
    }
}

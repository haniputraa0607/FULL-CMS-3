<?php

namespace Modules\ProductBundling\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;

class ProductBundlingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'Product Bundling List',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-list',
        ];
        
        $bundling = MyHelper::get('product-bundling/list');

        if (isset($bundling['status']) && $bundling['status'] == "success") {
            $data['bundling'] = $bundling['result'];
        } else {
            $data['bundling'] = [];
        }

        return view('productbundling::list', $data);
    }

    public function getAjax(Request $request)
    {
        $post = $request->except('_token');

        if($request->ajax())
        {
            $brandProduct = MyHelper::post('product-bundling/brandproduct', $post);
            return $brandProduct;
        }
    }

    public function ajaxHandler(Request $request){
        $post=$request->except('_token');
        $outlets=MyHelper::post('outlet/ajax_handler', $post);
        return $outlets;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'New Product Bundling',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-new',
        ];
        
        $data['brands'] = MyHelper::get('brand/list')['result']??[];

        return view('productbundling::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('productbundling::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('productbundling::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class ProductPlasticController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    function index(){
        $data = [
            'title'          => 'Product Plactic',
            'sub_title'      => 'Product Plastic List',
            'menu_active'    => 'product',
            'submenu_active' => 'product-plastic',
            'child_active' => 'product-plastic-list'
        ];

        $data['data'] = MyHelper::get('product-plastic/list')['result']??[];

        return view('product::product_plastic.list',$data);
    }

    function create() {
        $data = [
            'title'          => 'Product Plactic',
            'sub_title'      => 'New Product Plastic',
            'menu_active'    => 'product',
            'submenu_active' => 'product-plastic',
            'child_active' => 'product-plastic-new'
        ];
        return view('product::product_plastic.create',$data);
    }

    function store(Request $request){
        $post = $request->except('_token');

        $store = MyHelper::post('product-plastic/store', $post);

        if(isset($store['status']) && $store['status'] == 'success'){
            return redirect('product/plastic')->withSuccess(['Success create product plastic']);
        }else{
            return redirect('product/plastic/create')->withErrors($store['messages']??['Failed create product plastic'])->withInput();
        }
    }

    function detail($id){
        $detail = MyHelper::post('product-plastic/detail', ['id_product' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Product Plactic',
                'sub_title'      => 'Product Plastic Detail',
                'menu_active'    => 'product',
                'submenu_active' => 'product-plastic',
                'child_active' => 'product-plastic-list'
            ];

            $data['detail'] = $detail['result'];

            return view('product::product_plastic.detail', $data);
        }else{
            return redirect('product/plastic')->withErrors($store['messages']??['Failed get detail outlet group filter']);
        }
    }

    function update(Request $request, $id)
    {
        $post = $request->except('_token');

        $post['id_product'] = $id;
        $update = MyHelper::post('product-plastic/update', $post);

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('product/plastic/detail/'.$id)->withSuccess(['Success update product plastic']);
        }else{
            return redirect('product/plastic/detail/'.$id)->withErrors($update['messages']??['Failed update product plastic']);
        }
    }

    public function visibility(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('product-plastic/visibility', $post);
        return $update;
    }

    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('product-plastic/delete', $post);
        return $delete;
    }
}

<?php

namespace Modules\ProductBundling\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
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
            $data['data']          = $bundling['result']['data'];
            $data['dataTotal']     = $bundling['result']['total'];
            $data['dataPerPage']   = $bundling['result']['from'];
            $data['dataUpTo']      = $bundling['result']['from'] + count($bundling['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($bundling['result']['data'], $bundling['result']['total'], $bundling['result']['per_page'], $bundling['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }
        return view('productbundling::index', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'New Product Bundling',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-new',
        ];

        $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
        return view('productbundling::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['photo'])) {
            $post['photo'] = MyHelper::encodeImage($post['photo']);
        }

        if (isset($post['photo_detail'])) {
            $post['photo_detail'] = MyHelper::encodeImage($post['photo_detail']);
        }

        $store = MyHelper::post('product-bundling/store', $post);
        if(isset($store['status']) && $store['status'] == 'success'){
            return redirect('product-bundling')->withSuccess(['Success create product bundling']);
        }else{
            return redirect('product-bundling/create')->withErrors($store['messages']??['Failed create product bundling']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function detail($id)
    {
        $detail = MyHelper::post('product-bundling/be/detail', ['id_bundling' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Product Bundling',
                'sub_title'      => 'Product Bundling Detail',
                'menu_active'    => 'product-bundling',
                'submenu_active' => 'product-bundling-list',
            ];

            $data['result'] = $detail['result']['detail'];
            $data['outlets'] = $detail['result']['outlets']??[];
            $data['selected_outlet'] = $detail['result']['selected_outlet']??[];
            $data['count_list_product'] = count($detail['result']['bundling_product']??[]);
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];

            return view('productbundling::detail', $data);
        }else{
            return redirect('product-bundling')->withErrors($store['messages']??['Failed get detail product bundling']);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        if (isset($post['photo'])) {
            $post['photo'] = MyHelper::encodeImage($post['photo']);
        }

        if (isset($post['photo_detail'])) {
            $post['photo_detail'] = MyHelper::encodeImage($post['photo_detail']);
        }

        $post['id_bundling'] = $id;
        $update = MyHelper::post('product-bundling/update', $post);

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('product-bundling/detail/'.$id)->withSuccess(['Success update product bundling']);
        }else{
            return redirect('product-bundling/detail/'.$id)->withErrors($update['messages']??['Failed update product bundling']);
        }
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

    public function productBrand(Request $request){
        $post = $request->except('_token');
        $getDataProduct = MyHelper::post('product/product-brand', $post);
        return $getDataProduct;
    }

    public function outletAvailable(Request $request){
        $post = $request->except('_token');
        $outlets = MyHelper::post('product-bundling/outlet-available', $post);
        return $outlets;
    }
    public function getGlobalPrice(Request $request){
        $post = $request->except('_token');
        $outlets = MyHelper::post('product-bundling/global-price', $post);
        return $outlets;
    }
}

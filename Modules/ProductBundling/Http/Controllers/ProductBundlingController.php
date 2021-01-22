<?php

namespace Modules\ProductBundling\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Session;

class ProductBundlingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'Product Bundling List',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-list',
        ];

        if(Session::has('filter-list-bundling') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-list-bundling');
            $post['page'] = $page;
        }else{
            Session::forget('filter-list-bundling');
        }

        $bundling = MyHelper::post('product-bundling/list', $post);

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

        $data['order_field'] = $post['order_field']??'id_bundling';
        $data['order_method'] = $post['order_method']??'asc';
        if($post){
            Session::put('filter-list-bundling',$post);
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

        $data['category'] = MyHelper::get('product-bundling-category/list')['result']??[];
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
            return redirect('product-bundling/create')->withErrors($store['messages']??['Failed create product bundling'])->withInput();
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

            $data['category'] = MyHelper::get('product-bundling-category/list')['result']??[];
            $data['result'] = $detail['result']['detail'];
            $data['outlets'] = $detail['result']['outlets']??[];
            $data['selected_outlet'] = $detail['result']['selected_outlet']??[];
            $data['count_list_product'] = count($detail['result']['detail']['bundling_product']??[]);
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            $data['brand_tmp'] = json_encode($detail['result']['brand_tmp'])??[];

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
    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('product-bundling/delete', $post);
        return $delete;
    }

    public function destroyBundlingProduct(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('product-bundling/delete-product', $post);
        return $delete;
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

    //Product Bundling Category
    public function indexBundlingCategory(){
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'Product Bundling Category',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-category',
        ];

        $bundling = MyHelper::get('product-bundling-category/list');

        if (isset($bundling['status']) && $bundling['status'] == "success") {
            $data['data']          = $bundling['result'];
        }else{
            $data['data']          = [];
        }

        return view('productbundling::category.list', $data);
    }

    public function createBundlingCategory()
    {
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'New Bundling Category',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-category-new',
        ];

        $data['bundling_category_parent'] = MyHelper::post('product-bundling-category/list', ['id_parent_category' => 0])['result']??[];
        return view('productbundling::category.create', $data);
    }

    public function storeBundlingCategory(Request $request)
    {
        $post = $request->except('_token');
        $store = MyHelper::post('product-bundling-category/store', $post);

        if(isset($store['status']) && $store['status'] == 'success'){
            return redirect('product-bundling/category')->withSuccess(['Success create bundling category']);
        }else{
            return redirect('product-bundling/category/create')->withErrors($store['messages']??['Failed create bundling category'])->withInput();
        }
    }

    public function updateBundlingCategory(Request $request, $id){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'Bundling Category Update',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-category',
        ];

        if (empty($post)) {
            $detail = MyHelper::post('product-bundling-category/list', ['id_bundling_category' => $id]);
            if(isset($detail['status']) && $detail['status'] == 'success'){
                $data['parent'] = MyHelper::post('product-bundling-category/list', ['id_parent_category' => 0])['result']??[];
                $data['category'] = $detail['result'];
                return view('productbundling::category.update', $data);
            }else{
                return redirect('product-bundling/category')->withErrors($store['messages']??['Failed get detail bundling category'])->withInput();
            }
        }
        else {
            if (isset($post['id_parent_category']) && $post['id_parent_category'] == 0) {
                $post['id_parent_category'] = null;
            }

            $save = MyHelper::post('product-bundling-category/update', $post);
            if(isset($save['status']) && $save['status'] == 'success'){
                return redirect('product-bundling/category/edit/'.$id)->withSuccess(['Success create bundling category']);
            }else{
                return redirect('product-bundling/category/edit/'.$id)->withErrors($store['messages']??['Failed create bundling category'])->withInput();
            }
        }
    }

    function deleteBundlingCategory(Request $request) {
        $post = $request->except('_token');

        $delete = MyHelper::post('product-bundling-category/delete', $post);
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }
}

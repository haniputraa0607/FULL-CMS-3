<?php

namespace Modules\ProductVariant\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;

class ProductVariantGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function listPrice(Request $request, $id_outlet = null)
    {
        $outlets = MyHelper::post('outlet/be/list', ['filter' => 'different_price'])['result'] ?? [];
        if (($id_outlet && !in_array($id_outlet, array_column($outlets, 'id_outlet'))) || !is_numeric($id_outlet)) {
            $outlet = 0;
            return redirect('product-variant-group/price/' . $outlet);
        }

        $data = [
            'title'          => 'Product Variant',
            'sub_title'      => 'Product Variant Price',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-price',
            'filter_title'   => 'Filter Product Variant Group',
        ];
        if (session('product_variant_group_price_filter')) {
            $post             = session('product_variant_group_price_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }

        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;

        $get = MyHelper::post('product-variant-group/list-price', $post);

        if (isset($get['status']) && $get['status'] == "success") {
            $data['total']     = $get['result']['total'];
            $data['productVariant']  = $get['result']['data'];
            $data['productVariantTotal']     = $get['result']['total'];
            $data['productVariantPerPage']   = $get['result']['from'];
            $data['productVariantUpTo']      = $get['result']['from'] + count($get['result']['data'])-1;
            $data['productVariantPaginator'] = new LengthAwarePaginator($get['result']['data'], $get['result']['total'], $get['result']['per_page'], $get['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['productVariant']  = [];
            $data['productVariantTotal']     = 0;
            $data['productVariantPerPage']   = 0;
            $data['productVariantUpTo']      = 0;
            $data['productVariantPaginator'] = false;
            $data['total'] = 0;
        }

        return view('productvariant::group.price', $data);
    }

    public function updatePrice(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_variant_group_price_filter' => $post]);
            return redirect('product-variant-group/price');
        }
        if ($post['clear'] ?? false) {
            session(['product_variant_group_price_filter' => null]);
            return redirect('product-variant-group/price');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product-variant-group/update-price', $post);

        if (($result['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update price']);
        } else {
            return back()->withErrors(['Fail update price']);
        }
    }
}

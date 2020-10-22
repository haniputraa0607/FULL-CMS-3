<?php

namespace Modules\ProductVariant\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Excel;
use App\Imports\FirstSheetOnlyImport;

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

    public function listDetail(Request $request, $id_outlet = null)
    {
        $outlets = MyHelper::get('outlet/be/list')['result'] ?? [];
        if (!$outlets) {
            return back()->withErrors(['Something went wrong']);
        }
        if (!$id_outlet || !in_array($id_outlet, array_column($outlets, 'id_outlet'))) {
            $outlet = $outlets[0]['id_outlet'] ?? false;
            if (!$outlet) {
                return back()->withErrors(['Something went wrong']);
            }
            return redirect('product-variant-group/detail/' . $outlet);
        }
        $data = [
            'title'          => 'Product Variant',
            'sub_title'      => 'Product Variant Detail',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-detail',
            'filter_title'   => 'Filter Product Variant Group',
        ];
        if (session('product_variant_group_detail_filter')) {
            $post             = session('product_variant_group_detail_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }
        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;

        $get = MyHelper::post('product-variant-group/list-detail', $post);

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

        return view('productvariant::group.detail', $data);
    }

    public function updateDetail(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_variant_group_detail_filter' => $post]);
            return redirect('product-variant-group/detail');
        }
        if ($post['clear'] ?? false) {
            session(['product_variant_group_detail_filter' => null]);
            return redirect('product-variant-group/detail');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product-variant-group/update-detail', $post);
        if (($result['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update detail']);
        } else {
            return back()->withErrors(['Fail update detail']);
        }
    }

    public function export(Request $request) {
        $post = $request->except('_token');
        $data = MyHelper::get('product-variant-group/export')['result']??[];
        $tab_title = 'List Product Variant';

        if(empty($data)){
            $datas['All Type'] = [
                [
                    'product_name' => 'Product 1',
                    'product_code' => 'P1',
                    'use_variant_status' => 'YES',
                    'Size' => 'S,M,L',
                    'Type' => 'Hot,Ice'
                ],
                [
                    'product_name' => 'Product 2',
                    'product_code' => 'P2',
                    'use_variant_status' => 'NO',
                    'Size' => '',
                    'Type' => ''
                ]
            ];
        }else{
            $datas['All Type'] = $data;
        }
        return Excel::download(new MultisheetExport($datas),date('YmdHi').'_product variant group.xlsx');
    }

    public function import(Request $request){
        $data = [
            'title'          => 'Product Variant Group',
            'sub_title'      => 'Import Product Variant Group',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-import-global'
        ];

        return view('productvariant::group.import', $data);
    }

    public function importSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product-variant-group/import', ['data' => $data]);
            }
        }

        return $import;
    }

    public function exportPrice(Request $request){
        $post = $request->except('_token');
        $data = MyHelper::post('product-variant-group/export-price', [])['result']??[];
        $tab_title = 'List Product Variant Group Price';

        if(empty($data)){
            $datas['All Type'] = $data['products'] = [
                [
                    'product' => 'P1 - Kopi Susu',
                    'current_product_variant_group_code' => 'PVG001',
                    'new_product_variant_group_code' => '',
                    'product_variant_group' => 'Hot, S',
                    'global_price' => 10000,
                    'price_PP001' => 15000,
                    'price_PP002' =>13500
                ],
                [
                    'product' => 'P2 - Kopi',
                    'current_product_variant_group_code' => 'PVG002',
                    'new_product_variant_group_code' => 'PVG002A',
                    'product_variant_group' => 'Hot, L',
                    'global_price' => 15000,
                    'price_PP001' => 20000,
                    'price_PP002' =>23000
                ],
                [
                    'product' => 'P3 - Es Milo',
                    'current_product_variant_group_code' => 'PVG003',
                    'new_product_variant_group_code' => '',
                    'product_variant_group' => 'Ice, S',
                    'global_price' => 15000,
                    'price_PP001' => 20000,
                    'price_PP002' =>23000
                ]
            ];
        }else{
            $datas['All Type'] = $data;
        }
        return Excel::download(new MultisheetExport($datas),date('YmdHi').'_product variant group price.xlsx');
    }

    public function importPrice(Request $request){
        $data = [
            'title'          => 'Product Variant Group',
            'sub_title'      => 'Import Product Variant Group Price',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-import-price'
        ];

        return view('productvariant::group.import_price', $data);
    }

    public function importPriceSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product-variant-group/import-price', ['data' => $data]);
            }
        }

        return $import;
    }
}

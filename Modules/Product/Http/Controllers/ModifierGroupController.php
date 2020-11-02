<?php

namespace Modules\Product\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Excel;
use App\Imports\FirstSheetOnlyImport;

class ModifierGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Product Modifier Group',
            'sub_title'      => 'List Product Modifier Group',
            'menu_active'    => 'product-modifier-group',
            'submenu_active' => 'product-modifier-group-list',
            'filter_title'   => 'Filter Product Modifier Group',
        ];
        if (session('product_modifier_group_filter')) {
            $post             = session('product_modifier_group_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }

        $page = $request->page;
        if (!$page) {
            $page = 1;
        }
        $post['page'] = $page;
        $get = MyHelper::post('product/modifier-group', $post);

        if (isset($get['status']) && $get['status'] == "success") {
            $data['total'] = $get['result']['total'];
            $data['modifierGroup']  = $get['result']['data'];
            $data['modifierGroupTotal']     = $get['result']['total'];
            $data['modifierGroupPerPage']   = $get['result']['from'];
            $data['modifierGroupUpTo']      = $get['result']['from'] + count($get['result']['data'])-1;
            $data['modifierGroupPaginator'] = new LengthAwarePaginator($get['result']['data'], $get['result']['total'], $get['result']['per_page'], $get['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['modifierGroup']  = [];
            $data['modifierGroupTotal']     = 0;
            $data['modifierGroupPerPage']   = 0;
            $data['modifierGroupUpTo']      = 0;
            $data['modifierGroupPaginator'] = false;
            $data['total'] = 0;
        }

        return view('product::modifier_group.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Product Modifier Group',
            'sub_title'      => 'New Product Modifier Group',
            'menu_active'    => 'product-modifier-group',
            'submenu_active' => 'product-modifier-group-new',
        ];
        $data['products'] = MyHelper::get('product/be/list')['result'] ?? [];

        $data['product_variant'] = MyHelper::post('product-variant', ['get_child' => 1])['result'] ?? [];
        return view('product::modifier_group.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_modifier_group_filter' => $post]);
            return redirect('product/modifier-group');
        }
        if ($post['clear'] ?? false) {
            session(['product_modifier_group_filter' => null]);
            return redirect('product/modifier-group');
        }
        $result = MyHelper::post('product/modifier-group/create', $post);
        if (($result['status'] ?? false) == 'success') {
            return redirect('product/modifier-group')->with('success', ['Success create modifier group']);
        } else {
            return back()->withErrors($result['messages'] ?? ['Something went wrong'])->withInput();
        }
    }

    public function update(Request $request, $id){
        $post = $request->except(['_token']);

        if(!$post){
            $data = [
                'title'          => 'Product Modifier Group',
                'sub_title'      => 'Detail Product Modifier Group',
                'menu_active'    => 'product-modifier-group',
                'submenu_active' => 'product-modifier-group-list',
            ];
            $modifierGroup = MyHelper::post('product/modifier-group', ['id_product_modifier_group' => $id]);

            if (!($modifierGroup['result'] ?? false)) {
                return back()->withErrors($modifierGroup['messages'] ?? ['Something went wrong']);
            }
            $data['result'] = $modifierGroup['result'];
            $data['count'] = count($modifierGroup['result']['product_modifier']);
            $data['products'] = MyHelper::get('product/be/list')['result'] ?? [];
            $data['product_variant'] = MyHelper::post('product-variant', ['get_child' => 1])['result'] ?? [];

            return view('product::modifier_group.edit', $data);
        }else{
            $post['id_product_modifier_group'] = $id;
            $result = MyHelper::post('product/modifier-group/update', $post);
            if (isset($result['status']) && $result['status'] == 'success') {
                return redirect('product/modifier-group/edit/' . $id)->with('success', ['Success update modifier group']);
            } else {
                return back()->withErrors($result['messages'] ?? [$result['message'] ?? 'Something went wrong'])->withInput();
            }
        }
    }

    public function listPrice(Request $request, $id_outlet = null)
    {
        $outlets = MyHelper::post('outlet/be/list', ['filter' => 'different_price'])['result'] ?? [];
        if (($id_outlet && !in_array($id_outlet, array_column($outlets, 'id_outlet'))) || !is_numeric($id_outlet)) {
            $outlet = 0;
            return redirect('product/modifier-group/price/' . $outlet);
        }
        $data = [
            'title'          => 'Modifier Group',
            'sub_title'      => 'Modifier Group Prices',
            'menu_active'    => 'product-modifier-group',
            'submenu_active' => 'product-modifier-group-price',
            'filter_title'   => 'Filter Modifier Group',
        ];
        if (session('product_modifier_group_price_filter')) {
            $post             = session('product_modifier_group_price_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }

        $page = $request->page;
        if (!$page) {
            $page = 1;
        }

        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;
        $data['modifiers'] = MyHelper::post('product/modifier-group/list-price?page=' . $page, $post)['result'] ?? [];
        $data['total']     = $data['modifiers']['total'];
        $data['paginator'] = new LengthAwarePaginator($data['modifiers']['data'], $data['modifiers']['total'], $data['modifiers']['per_page'], $data['modifiers']['current_page'], ['path' => url()->current()]);

        $data['start']     = ($page - 1) * 10;
        $data['next_page'] = $data['modifiers']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['modifiers']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        return view('product::modifier_group.price', $data);
    }

    public function updatePrice(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_modifier_group_price_filter' => $post]);
            return redirect('product/modifier-group/price');
        }
        if ($post['clear'] ?? false) {
            session(['product_modifier_group_price_filter' => null]);
            return redirect('product/modifier-group/price');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product/modifier/update-price', $post);
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
            return redirect('product/modifier-group/detail/' . $outlet);
        }
        $data = [
            'title'          => 'Modifier Group',
            'sub_title'      => 'Modifier Group Detail',
            'menu_active'    => 'product-modifier-group',
            'submenu_active' => 'product-modifier-group-detail',
            'filter_title'   => 'Filter Modifier Group',
        ];
        if (session('product_modifier_group_detail_filter')) {
            $post             = session('product_modifier_group_detail_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }

        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;
        $data['modifiers'] = MyHelper::post('product/modifier-group/list-detail?page=' . $page, $post)['result'] ?? [];
        $data['total']     = $data['modifiers']['total'];
        $data['paginator'] = new LengthAwarePaginator($data['modifiers']['data'], $data['modifiers']['total'], $data['modifiers']['per_page'], $data['modifiers']['current_page'], ['path' => url()->current()]);

        $data['start']     = ($page - 1) * 10;
        $data['next_page'] = $data['modifiers']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['modifiers']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        return view('product::modifier_group.detail', $data);
    }

    /**
     * update detail product modifiers
     * @return view list modifiers detail
     */
    public function updateDetail(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_modifier_group_detail_filter' => $post]);
            return redirect('product/modifier-group/detail');
        }
        if ($post['clear'] ?? false) {
            session(['product_modifier_group_detail_filter' => null]);
            return redirect('product/modifier-group/detail');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product/modifier/update-detail', $post);
        if (($result['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update detail']);
        } else {
            return back()->withErrors(['Fail update detail']);
        }
    }

    public function destroy($id)
    {
        $result = MyHelper::post('product/modifier-group/delete', ['id_product_modifier_group' => $id]);

        if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('product/modifier-group')->with('success', ['Success delete modifier group']);
        }
        return redirect('product/modifier-group')->withErrors(['Fail delete modifier group']);
    }

    public function export(Request $request) {
        $post = $request->except('_token');
        $data = MyHelper::get('product/modifier-group/export')['result']??[];

        if(empty($data)){
            $datas['All Type'] = [
                [
                    'product_modifier_group_name' => 'Ice',
                    'product' => '',
                    'variant' => 'Ice',
                    'modifier' => 'Less Ice,More Ice(A0001)'
                ],
                [
                    'product_name' => 'Level Pedas',
                    'product' => 'P0001,P0002,P0006',
                    'variant' => '',
                    'modifier' => 'Level 1(A0002),Level2,Level3'
                ]
            ];
        }else{
            $datas['All Type'] = $data;
        }
        return Excel::download(new MultisheetExport($datas),date('YmdHi').'_product modifier group.xlsx');
    }

    public function import(Request $request){
        $data = [
            'title'          => 'Product Modifier Group',
            'sub_title'      => 'Import Product Modifier Group',
            'menu_active'    => 'product-modifier-group',
            'submenu_active' => 'product-modifier-group-import-global'
        ];

        return view('product::modifier_group.import', $data);
    }

    public function importSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product/modifier-group/import', ['data' => $data]);
            }
        }

        return $import;
    }

    public function exportPrice(Request $request) {
        $post = $request->except('_token');
        $data = MyHelper::get('product/modifier-group/export-price')['result']??[];

        if(empty($data)){
            $datas['All Type'] = [
                [
                    'modifier_group_code' => 'M0001',
                    'global_price' => '5000',
                    'price_PP001' => '6000',
                    'price_PP002' => '2000'
                ],
                [
                    'modifier_group_code' => 'M0002',
                    'global_price' => '4000',
                    'price_PP001' => '5000',
                    'price_PP002' => '3000'
                ],
            ];
        }else{
            $datas['All Type'] = $data;
        }
        return Excel::download(new MultisheetExport($datas),date('YmdHi').'_modifier group price.xlsx');
    }

    public function importPrice(Request $request){
        $data = [
            'title'          => 'Modifier Group Price',
            'sub_title'      => 'Import Modifier Group Price',
            'menu_active'    => 'product-modifier-group',
            'submenu_active' => 'product-modifier-group-import-price'
        ];

        return view('product::modifier_group.import_price', $data);
    }

    public function importSavePrice(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product/modifier-group/import-price', ['data' => $data]);
                \Log::info($import);
            }
        }

        return $import;
    }
}

<?php

namespace Modules\ProductVariant\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Excel;

use App\Imports\FirstSheetOnlyImport;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'Variant List',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-list',
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('product-variant',$request->all());

            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('productvariant::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'New Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-new',
        ];
        return view('productvariant::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $store = MyHelper::post('product-variant/store', $post);

        if(($store['status']??'')=='success'){
            return redirect('product-variant')->with('success',['Create Variant Success']);
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
        return view('productvariant::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'Update Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant',
        ];

        $post['id_product_variant'] = $id;
        $get_data = MyHelper::post('product-variant/edit', $post);

        $data['all_parent'] = [];
        $data['product_variant'] = [];
        if(($get_data['status']??'')=='success'){
            $data['all_parent'] = $get_data['result']['all_parent'];
            $data['product_variant'] = $get_data['result']['product_variant'];
        }

        return view('productvariant::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->all();
        $post['id_product_variant'] = $id;


        if(isset($post['product_variant_visibility'])) {
            $post['product_variant_visibility'] = 'Visible';
        }else{
            $post['product_variant_visibility'] = 'Hidden';
        }

        $update = MyHelper::post('product-variant/update', $post);

        if(($update['status']??'')=='success'){
            return redirect('product-variant/edit/'.$id)->with('success',['Updated Variant Success']);
        }else{
            return back()->withInput()->withErrors($update['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post('product-variant/delete', ['id_product_variant' => $id]);
         if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('product-variant')->with('success', ['Success delete product variant']);
        }
        return redirect('product-variant')->withErrors(['Fail delete product variant, product variant already to use in transaction']);
    }

    public function export(Request $request) {
        $post = $request->except('_token');
        $data = MyHelper::post('product-variant', [])['result']??[];
        $tab_title = 'List Variant';

        if(empty($data)){
            $datas['All Type'] = [
                [
                    'product_variant_name' => 'Size',
                    'product_variant_child' => 'S,M,L,XL'
                ],
                [
                    'product_variant_name' => 'Type',
                    'product_variant_child' => 'Hot,Ice'
                ]
            ];
        }else{
            $arr = [];
            foreach ($data as $dt){
                $child = array_column($dt['product_variant_child'], 'product_variant_name');
                if(!empty($dt['product_variant_child'])){
                    $arr[] = [
                        'product_variant_name' => $dt['product_variant_name'],
                        'product_variant_child' => implode(",",$child)
                    ];
                }
            }
            $datas['All Type'] = $arr;
        }
        return Excel::download(new MultisheetExport($datas),date('YmdHi').'_variant.xlsx');
    }

    public function import(){
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'Import Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-import-global'
        ];

        return view('productvariant::import', $data);
    }

    public function importSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product-variant/import', ['data' => $data]);
            }
        }

        return $import;
    }
}

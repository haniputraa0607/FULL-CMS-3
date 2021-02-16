<?php

namespace Modules\Plastic\Http\Controllers;

use App\Exports\ProductExport;
use App\Exports\ProductVariantPriceArrayExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\MultisheetExport;
use App\Imports\ProductImport;
use App\Imports\FirstSheetOnlyImport;
use App\Http\Controllers\Controller;
use Excel;

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
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'product-plastic-list'
        ];

        $data['data'] = MyHelper::get('product-plastic/list')['result']??[];

        return view('plastic::list',$data);
    }

    function create() {
        $data = [
            'title'          => 'Product Plactic',
            'sub_title'      => 'New Product Plastic',
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'product-plastic-new'
        ];
        $data['plastic_type'] = MyHelper::get('plastic-type/list')['result']??[];
        return view('plastic::create',$data);
    }

    function store(Request $request){
        $post = $request->except('_token');

        $store = MyHelper::post('product-plastic/store', $post);

        if(isset($store['status']) && $store['status'] == 'success'){
            return redirect('product-plastic')->withSuccess(['Success create product plastic']);
        }else{
            return redirect('product-plastic/create')->withErrors($store['messages']??['Failed create product plastic'])->withInput();
        }
    }

    function detail($id){
        $detail = MyHelper::post('product-plastic/detail', ['id_product' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Product Plactic',
                'sub_title'      => 'Product Plastic Detail',
                'menu_active'    => 'product-plastic',
                'submenu_active' => 'product-plastic-list'
            ];

            $data['detail'] = $detail['result'];
            $data['plastic_type'] = MyHelper::get('plastic-type/list')['result']??[];

            return view('plastic::detail', $data);
        }else{
            return redirect('product-plastic')->withErrors($store['messages']??['Failed get detail outlet group filter']);
        }
    }

    function update(Request $request, $id)
    {
        $post = $request->except('_token');

        $post['id_product'] = $id;
        $update = MyHelper::post('product-plastic/update', $post);

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('product-plastic/detail/'.$id)->withSuccess(['Success update product plastic']);
        }else{
            return redirect('product-plastic/detail/'.$id)->withErrors($update['messages']??['Failed update product plastic']);
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

    public function exportUsePlastic(Request $request) {
        $post = $request->except('_token');
        $data = MyHelper::post('product-plastic/export-product', $post)['result']??[];

        if(empty($data)){
            $datas['brand'] = [
                'name_brand' => '',
                'code_brand' => ''
            ];
            $datas['products'] = [
                [
                    'product_name' => 'Product 1',
                    'product_code' => 'P1',
                    'total_use_plastic' => 2
                ],
                [
                    'product_name' => 'Product 2',
                    'product_code' => 'P2',
                    'total_use_plastic' => 5
                ]
            ];
        }else{
            $datas = $data;
        }

        $tab_title = 'List Products';
        return Excel::download(new ProductExport($datas['products'],$datas['brand'],$tab_title),date('YmdHi').'_product_'.$datas['brand']['name_brand'].'.xlsx');
    }

    public function importUsePlastic(){
        $data = [
            'title'          => 'Product Plactic',
            'sub_title'      => 'Import Product',
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'product-plastic-import'
        ];

        $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
        return view('plastic::import', $data);
    }

    public function imporSavetUsePlastic(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $excel = \Excel::toCollection(new ProductImport(),$request->file('import_file'));
            $data = [];
            $head = [];
            foreach ($excel[0]??[] as $key => $value) {
                $value = json_decode($value);
                if($key == 2){
                    $head = $value;
                }elseif($key > 2){
                    $data[] = array_combine($head, $value);
                }
            }

            if(!empty($data)){
                $import = MyHelper::post('product-plastic/import-product', ['data' => $data]);
                return $import;
            }else{
                return [
                    'status'=>'fail',
                    'messages'=>['File empty']
                ];
            }
        }else{
            return [
                'status'=>'fail',
                'messages'=>['File empty']
            ];
        }
    }

    public function exportProductVariantUsePlastic(Request $request){
        $post = $request->except('_token');
        $data = MyHelper::post('product-plastic/export-product-variant', $post)['result']??[];

        if(empty($data)){
            $datas['brand'] = [
                'name_brand' => '',
                'code_brand' => ''
            ];
            $datas['products_variant'] = [
                [
                    'product' => 'P1 - Kopi Susu',
                    'product_variant_code' => 'PVG001',
                    'product_variant' => 'Hot,Large',
                    'total_use_plastic' => 1
                ],
                [
                    'product' => 'P2 - Kopi',
                    'product_variant_code' => 'PVG002',
                    'product_variant' => 'Hot,Large',
                    'total_use_plastic' => 0
                ],
                [
                    'product' => 'P3 - Es Milo',
                    'product_variant_code' => 'PVG003',
                    'product_variant' => 'Hot,Reguler',
                    'total_use_plastic' => 5
                ]
            ];
        }else{
            $datas = $data;
        }

        $tab_title = 'List Product Variant Group';
        return Excel::download(new ProductExport($datas['products_variant'],$datas['brand'],$tab_title),date('YmdHi').'_product variant group_'.$datas['brand']['name_brand'].'.xlsx');
    }

    function imporProductVariantUsePlastic(){
        $data = [
            'title'          => 'Product Plactic',
            'sub_title'      => 'Import Product Variant',
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'product-plastic-import-product-variant'
        ];

        $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
        return view('plastic::import_product_variant', $data);
    }

    public function imporProductVariantSavetUsePlastic(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $excel = \Excel::toCollection(new ProductImport(),$request->file('import_file'));
            $data = [];
            $head = [];
            foreach ($excel[0]??[] as $key => $value) {
                $value = json_decode($value);
                if($key == 2){
                    $head = $value;
                }elseif($key > 2){
                    $data[] = array_combine($head, $value);
                }
            }

            if(!empty($data)){
                $import = MyHelper::post('product-plastic/import-product-variant', ['data' => $data]);
                return $import;
            }else{
                return [
                    'status'=>'fail',
                    'messages'=>['File empty']
                ];
            }
        }else{
            return [
                'status'=>'fail',
                'messages'=>['File empty']
            ];
        }
    }

    public function exportPlasticPrice(Request $request) {
        $post = $request->except('_token');
        $data = MyHelper::post('product-plastic/export-price', $post)['result']['products']??[];

        if(empty($data)){
            $datas['All Type'] = [
                [
                    'product_plastic_name' => 'Product 1',
                    'product_plastic_code' => 'P1',
                    'global_price' => 1000,
                    'price_0002' => 2000
                ],
                [
                    'product_plastic_name' => 'Product 2',
                    'product_plastic_code' => 'P2',
                    'global_price' => 1000,
                    'price_0002' => 2000
                ]
            ];
        }else{
            $datas['All Type'] = $data;
        }

        return Excel::download(new MultisheetExport($datas),date('YmdHi').'_product plastic price.xlsx');
    }

    function importPlasticPrice(){
        $data = [
            'title'          => 'Product Plactic',
            'sub_title'      => 'Import Plastic Price',
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'product-plastic-import-price'
        ];
        return view('plastic::import_price', $data);
    }

    public function imporSavePlasticPrice(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product-plastic/import-price', ['data' => $data]);
            }
        }

        return $import;
    }

    public function exportPlasticStatusOutlet(Request $request) {
        $post = $request->except('_token');
        $data = MyHelper::post('product-plastic/export-plastic-status-outlet', $post)['result']??[];

        if(empty($data)){
            $datas['All Type'] = [
                [
                    'outlet_code' => '0001',
                    'outlet_name' => 'Outlet 1',
                    'plastic_status' => 'Active'
                ],
                [
                    'outlet_code' => '0002',
                    'outlet_name' => 'Outlet 2',
                    'plastic_status' => 'Inactive'
                ]
            ];
        }else{
            $datas['All Type'] = $data;
        }

        return Excel::download(new MultisheetExport($datas),date('YmdHi').'_plastic status outlet.xlsx');
    }

    public function importPlasticStatusOutlet(Request $request){
        $data = [
            'title'          => 'Product Plactic',
            'sub_title'      => 'Import Plastic Price',
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'import-plastic-status'
        ];
        return view('plastic::import_plastic_status_outlet', $data);
    }

    public function importSavePlasticStatusOutlet(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product-plastic/import-plastic-status-outlet', ['data' => $data]);
            }
        }

        return $import;
    }

}

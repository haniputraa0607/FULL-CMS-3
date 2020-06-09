<?php

namespace Modules\Achievement\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Achievement List',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-list'
        ];
        return view('achievement::index', $data);
    }

    public function report(Request $request, $slug)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Achievement List',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-list'
        ];
        switch ($slug) {
            case 'user-achivement':
                if (!empty($post)) {
                    $post = $request->except('_token');
                    $raw_data = MyHelper::post('achievement/report/' . $slug, $post)['result'] ?? [];
                    return MyHelper::post('achievement/report/' . $slug, $post);
                    $data['data'] = $raw_data['data'];
                    $data['total'] = $raw_data['total'] ?? 0;
                    $data['from'] = $raw_data['from'] ?? 0;
                    $data['order_by'] = $raw_data['order_by'] ?? 0;
                    $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
                    $data['last_page'] = !($raw_data['next_page_url'] ?? false);
                    return $data;
                }
                return view('achievement::report.user', $data);
                break;
            case 'list-achivement':
                if (!empty($post)) {
                    $post = $request->except('_token');
                    $raw_data = MyHelper::post('achievement/report/' . $slug, $post)['result'] ?? [];
                    $data['data'] = $raw_data['data'];
                    $data['total'] = $raw_data['total'] ?? 0;
                    $data['from'] = $raw_data['from'] ?? 0;
                    $data['order_by'] = $raw_data['order_by'] ?? 0;
                    $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
                    $data['last_page'] = !($raw_data['next_page_url'] ?? false);
                    return $data;
                }
                return view('achievement::report.index', $data);
                break;
            case 'membership-achivement':
                if (!empty($post)) {
                    $post = $request->except('_token');
                    $raw_data = MyHelper::post('achievement/report/' . $slug, $post)['result'] ?? [];
                    $data['data'] = $raw_data['data'];
                    $data['total'] = $raw_data['total'] ?? 0;
                    $data['from'] = $raw_data['from'] ?? 0;
                    $data['order_by'] = $raw_data['order_by'] ?? 0;
                    $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
                    $data['last_page'] = !($raw_data['next_page_url'] ?? false);
                    return $data;
                }
                return view('achievement::report.membership', $data);
                break;
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function indexAjax(Request $request)
    {
        $post = $request->except('_token');
        $raw_data = MyHelper::post('achievement', $post)['result'] ?? [];
        $data['data'] = $raw_data['data'];
        $data['total'] = $raw_data['total'] ?? 0;
        $data['from'] = $raw_data['from'] ?? 0;
        $data['order_by'] = $raw_data['order_by'] ?? 0;
        $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
        $data['last_page'] = !($raw_data['next_page_url'] ?? false);
        return $data;
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            if (isset($post['id_achievement_group'])) {
                foreach ($post['detail'] as $key => $value) {
                    $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                    switch ($value['rule_total']) {
                        case 'total_transaction':
                            $post['detail'][$key]['trx_total'] = $value['value_total'];
                            break;
                        case 'total_outlet':
                            $post['detail'][$key]['different_outlet'] = $value['value_total'];
                            break;
                        case 'total_province':
                            $post['detail'][$key]['different_province'] = $value['value_total'];
                            break;
                    }
                    unset($post['detail'][$key]['rule_total']);
                    unset($post['detail'][$key]['value_total']);
                }

                $save = MyHelper::post('achievement/create', $post);

                if (isset($save['status']) && $save['status'] == "success") {
                    return redirect('achievement/detail/' . $save['data']);
                } else {
                    return back()->with('error', $save['errors'])->withInput();
                }
            } else {
                $post['group']['logo_badge_default'] = MyHelper::encodeImage($post['group']['logo_badge_default']);

                if (isset($post['detail'])) {
                    foreach ($post['detail'] as $key => $value) {
                        $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                        switch ($value['rule_total']) {
                            case 'total_transaction':
                                $post['detail'][$key]['trx_total'] = $value['value_total'];
                                break;
                            case 'total_outlet':
                                $post['detail'][$key]['different_outlet'] = $value['value_total'];
                                break;
                            case 'total_province':
                                $post['detail'][$key]['different_province'] = $value['value_total'];
                                break;
                        }
                        unset($post['detail'][$key]['rule_total']);
                        unset($post['detail'][$key]['value_total']);
                    }
                }

                $save = MyHelper::post('achievement/create', $post);

                if (isset($save['status']) && $save['status'] == "success") {
                    return redirect('achievement/detail/' . $save['data']);
                } else {
                    return back()->with('error', $save['errors'])->withInput();
                }
            }
        } else {
            $data = [
                'title'          => 'Achievement',
                'sub_title'      => 'Achievement Create',
                'menu_active'    => 'achievement',
                'submenu_active' => 'achievement-create'
            ];

            $data['category']   = MyHelper::get('achievement/category')['data'];
            $data['product']    = MyHelper::get('product/be/list')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];

            return view('achievement::create', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Achievement Detail',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-list'
        ];

        $getDetail = MyHelper::post('achievement/detail', ['id_achievement_group' => $id]);

        if (isset($getDetail['status']) && $getDetail['status'] == "success") {
            $data['data'] = $getDetail['data'];

            $data['category']   = MyHelper::get('achievement/category')['data'];
            $data['product']    = MyHelper::get('product/be/list')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];

            return view('achievement::detail', $data);
        } else {
            $data = [
                'title'          => 'Achievement',
                'sub_title'      => 'Achievement Create',
                'menu_active'    => 'achievement',
                'submenu_active' => 'achievement-create'
            ];

            $data['category']   = MyHelper::get('achievement/category')['data'];
            $data['product']    = MyHelper::get('product/be/list')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];

            return view('achievement::create', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('achievement::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('achievement/detail/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return back();
        } else {
            return back()->with('error', $update['errors'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function remove(Request $request)
    {
        $post = $request->except('_token');

        $remove = MyHelper::post('achievement/destroy', $post);

        return $remove;
    }
}

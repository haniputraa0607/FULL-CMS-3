<?php

namespace Modules\Quest\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Quest List',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-list'
        ];
        if ($request->method() == 'POST') {
            $post = $request->except('_token');
            $raw_data = MyHelper::post('quest', $post)['result'] ?? [];
            $data['data'] = $raw_data['data'];
            $data['total'] = $raw_data['total'] ?? 0;
            $data['from'] = $raw_data['from'] ?? 0;
            $data['order_by'] = $raw_data['order_by'] ?? 0;
            $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
            $data['last_page'] = !($raw_data['next_page_url'] ?? false);
            return $data;
        }

        return view('quest::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Quest Create',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-create'
        ];

        $data['category']   = MyHelper::get('product/category/be/list')['result'];
        $data['product']    = MyHelper::get('product/be/list')['result'];
        $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
        $data['province']   = MyHelper::get('province/list')['result'];
        $data['deals']      = MyHelper::get('quest/list-deals')['result'];;
        $data['details']     = (old('detail') ?? false) ?: [[]];

        return view('quest::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['id_quest'])) {
            foreach ($post['detail'] as $key => $value) {
                if ($post['detail'][$key]['logo_badge'] ?? false) {
                    $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                }
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
            
            $save = MyHelper::post('quest/create', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('quest/detail/' . $save['data']);
            } else {
                return back()->with('error', $save['errors'])->withInput();
            }
        } else {
            $post['quest']['image'] = MyHelper::encodeImage($post['quest']['image']);

            if (isset($post['detail'])) {
                foreach ($post['detail'] as $key => $value) {
                    if ($post['detail'][$key]['logo_badge'] ?? false) {
                        $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                    }
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

            $save = MyHelper::post('quest/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('quest/detail/' . $save['data'] . '#content');
            } else {
                return ['error' => $save];
                return back()->with('error', $save['errors'] ?? ['Something went wrong'])->withInput();
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Quest Detail',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-list'
        ];

        $getDetail = MyHelper::post('quest/detail', ['id_quest' => $id]);
        if (isset($getDetail['status']) && $getDetail['status'] == "success") {
            $data['data']       = $getDetail['data'];
            $data['category']   = MyHelper::get('product/category/be/list')['result'];
            $data['product']    = MyHelper::get('product/be/list')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];
            $data['deals']      = MyHelper::get('quest/list-deals')['result'];;

            return view('quest::detail', $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('quest::edit');
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

        $update = MyHelper::post('quest/detail/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return back()->withSuccess(['Success update detail']);
        } else {
            return back()->with('error', $update['errors'])->withInput();
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

    public function updateContent(Request $request, $slug)
    {
        $post = $request->all();
        $result = MyHelper::post('quest/update-content', $post + ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/'.$slug.'#content')->withSuccess(['Update Success']);
        }
        return redirect('quest/detail/'.$slug.'#content')->withErrors($result['messages']??['Something went wrong']);
    }

    public function updateQuest(Request $request, $slug)
    {
        $post = $request->all();
        if ($post['quest']['image'] ?? false) {
            $post['quest']['image'] = MyHelper::encodeImage($post['quest']['image']);
        }
        if ($post['quest']['publish_start'] ?? false) {
            $post['quest']['publish_start'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['publish_start'])));
        }
        if ($post['quest']['publish_end'] ?? false) {
            $post['quest']['publish_end'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['publish_end'])));
        }
        if ($post['quest']['date_start'] ?? false) {
            $post['quest']['date_start'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['date_start'])));
        }
        if ($post['quest']['date_end'] ?? false) {
            $post['quest']['date_end'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['date_end'])));
        }
        $result = MyHelper::post('quest/update-quest', $post + ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/'.$slug)->withSuccess(['Update Success']);
        }
        return redirect('quest/detail/'.$slug)->withErrors($result['messages']??['Something went wrong']);
    }

    public function updateBenefit(Request $request, $slug)
    {
        $post = $request->all();
        $result = MyHelper::post('quest/update-benefit', $post + ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/'.$slug)->withSuccess(['Update Success']);
        }
        return redirect('quest/detail/'.$slug)->withErrors($result['messages']??['Something went wrong']);
    }

    public function start(Request $request, $slug)
    {
        $result = MyHelper::post('quest/start', ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/'.$slug)->withSuccess(['Quest Started']);
        }
        return redirect('quest/detail/'.$slug)->withErrors($result['messages']??['Something went wrong']);
    }
}

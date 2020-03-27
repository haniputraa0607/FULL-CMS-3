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
    public function index()
    {
        return view('quest::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            if (isset($post['id_quest'])) {
                $save = MyHelper::post('quest/create', $post);

                if (isset($save['status']) && $save['status'] == "success") {
                    return redirect('quest/detail/' . $save['data']);
                } else {
                    return back()->with('error', $save['errors'])->withInput();
                }
            } else {
                $post['quest']['image'] = MyHelper::encodeImage($post['quest']['image']);

                $save = MyHelper::post('quest/create', $post);

                if (isset($save['status']) && $save['status'] == "success") {
                    return redirect('quest/detail/' . $save['data']);
                } else {
                    return back()->with('error', $save['errors'])->withInput();
                }
            }
        } else {
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

            return view('quest::create', $data);
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

            return view('quest::detail', $data);
        } else {
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

            return view('quest::create', $data);
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
    public function destroy($id)
    {
        //
    }
}

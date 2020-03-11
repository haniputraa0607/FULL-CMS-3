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
        return view('achievement::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request, $slug = null)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            dd($post);
            $post['group']['logo_badge_default'] = MyHelper::encodeImage($post['group']['logo_badge_default']);

            $save = MyHelper::post('achievement/create', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('achievement')->with('success', $save['message']);
            } else {
                if (isset($save['errors'])) {
                    return back()->with('error', $save['errors'])->withInput();
                }
                return back()->with('success', $save['message'])->withInput();
            }
        } else {

            $data = [
                'title'          => 'Achievement',
                'sub_title'      => 'Achievement Create',
                'menu_active'    => 'achievement',
                'submenu_active' => 'achievement-create'
            ];

            $data['category'] = MyHelper::get('achievement/category')['data'];

            if (isset($id_achievement)) {
                $data['achievement'] = MyHelper::post('achievement/show-step1', ['id_achievement' => $id_achievement])['result'] ?? '';
                if ($data['achievement'] == '') {
                    return redirect('achievement')->withErrors('Achievement not found');
                }
                if (isset($data['achievement']['id_achievement'])) {
                    $data['achievement']['id_achievement'] = MyHelper::createSlug($data['achievement']['id_achievement'], $data['achievement']['id_achievement'] ?? '');
                }
            }

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
        return view('achievement::show');
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
    public function update(Request $request, $id)
    {
        //
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

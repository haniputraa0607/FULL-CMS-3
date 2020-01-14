<?php

namespace Modules\UserFeedback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class RatingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'Rating Item',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'rating-item'
        ];
        $data['items'] = MyHelper::get('user-feedback/rating-item')['result']??[];
        return view('userfeedback::rating_item.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');
        $items = $post['item']??[];
        $new_items = $post['new_item']??[];
        if(!$items){
            return back()->withInput()->withErrors('Data could not be empty');
        }
        foreach ($items as $key => &$item) {
            $item['id_rating_item'] = $key;
            if(isset($item['image'])){
                $item['image'] = MyHelper::encodeImage($item['image']);
            }
            if(isset($item['image_selected'])){
                $item['image_selected'] = MyHelper::encodeImage($item['image_selected']);
            }
        }

        foreach ($new_items as &$item) {
            if(isset($item['image'])){
                $item['image'] = MyHelper::encodeImage($item['image']);
            }
            if(isset($item['image_selected'])){
                $item['image_selected'] = MyHelper::encodeImage($item['image_selected']);
            }
        }
        $data = array_merge(array_values($items),array_values($new_items));
        $result = MyHelper::post('user-feedback/rating-item/update',['rating_item'=>$data]);
        if(($result['status']??false) == 'success'){
            return back()->with('success',['Success update rating item']);
        }else{
            return back()->withInput()->withErrors($result['messages']??['Failed update rating item']);
        }
    }

}

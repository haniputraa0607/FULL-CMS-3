<?php

namespace Modules\Subscription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionController extends Controller
{

    public function index()
    {
        return view('subscription::index');
    }

    public function changeDateFormat($date)
    {
        if ( !empty($date) ) {
            $date = date('Y-m-d H:i:s', strtotime($date));
        }
        return $date;
    }

    public function create(Request $request, $id_subscription=null)
    {
        $post = $request->except('_token');
        if (!empty($post)) {

            $post['subscription_start']         = $this->changeDateFormat($post['subscription_start']??null);
            $post['subscription_end']           = $this->changeDateFormat($post['subscription_end']??null);
            $post['subscription_publish_start'] = $this->changeDateFormat($post['subscription_publish_start']??null);
            $post['subscription_publish_end']   = $this->changeDateFormat($post['subscription_publish_end']??null);
            if (isset($post['subscription_image'])) {
                $post['subscription_image']         = MyHelper::encodeImage($post['subscription_image']);
            }

            $save = MyHelper::post('subscription/step1', $post);

            if ( $save['status']??0 == "success") {
                return redirect('subscription/step2/'.$save['result']['id_subscription'])->with('success', ['Subscription has been created']);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
        }
        else {

            $data = [
                'title'          => 'Subscription',
                'sub_title'      => 'Subscription Create',
                'menu_active'    => 'subscription',
                'submenu_active' => 'subscription-create'
            ];
            
            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step1', ['id_subscription' => $id_subscription])['result']??'';
            }

            return view('subscription::step1', $data);
        }
    }

    public function step2(Request $request, $id_subscription = null)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            return $post;
        }
        else {

            $data = [
                'title'          => 'Subscription',
                'sub_title'      => 'Subscription Create',
                'menu_active'    => 'subscription',
                'submenu_active' => 'subscription-create'
            ];

            $post['select'] = ['id_outlet','outlet_code','outlet_name'];
            $outlets = MyHelper::post('outlet/ajax_handler', $post);
            
            if (!empty($outlets['result'])) {
                $data['outlets'] = $outlets['result'];
            }

            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step1', ['id_subscription' => $id_subscription])['result']??'';
            }
            return view('subscription::step2', $data);
        }
    }

    public function step3(Request $request, $id_subscription=null)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            return $post;
        }
        else {

            $data = [
                'title'          => 'Subscription',
                'sub_title'      => 'Subscription Create',
                'menu_active'    => 'subscription',
                'submenu_active' => 'subscription-create'
            ];

            $post['select'] = ['id_outlet','outlet_code','outlet_name'];
            $outlets = MyHelper::post('outlet/ajax_handler', $post);
            
            if (!empty($outlets['result'])) {
                $data['outlets'] = $outlets['result'];
            }

            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step1', ['id_subscription' => $id_subscription])['result']??'';
            }

            return view('subscription::step3', $data);
        }
    }
}

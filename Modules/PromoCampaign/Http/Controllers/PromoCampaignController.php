<?php

namespace Modules\PromoCampaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

use App\lib\MyHelper;
use Session;

class PromoCampaignController extends Controller
{
    public function step1(Request $request, $id_promo_campaign=null)
    {
        $post = $request->except('_token');

        if (empty($post)) 
        {
            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Step 1',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-create'
            ];

            if (isset($id_promo_campaign)) 
            {
                $get_data = MyHelper::post('promo-campaign/show-step1', ['id_promo_campaign' => $id_promo_campaign]);
// return $get_data;
                $data['result'] = $get_data['result']??'';
            }
            return view('promocampaign::create-promo-campaign-step-1', $data);

        }
        else
        {

            $action = MyHelper::post('promo-campaign/step1', $post);
return $action;
            
            if (isset($action['status']) && $action['status'] == 'success') 
            {
                return redirect('promo-campaign/step2/' . $action['promo-campaign']['id_promo_campaign']);
            } 
            else 
            {
                return back()->withErrors($action['messages'])->withInput();
            }

            
        }
    }

    public function step2(Request $request, $id_promo_campaign)
    {
        $post = $request->except('_token');

        if (empty($post)) {

            $get_data = MyHelper::post('promo-campaign/show-step2', ['id_promo_campaign' => $id_promo_campaign]);

            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Step 2',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-create'
            ];

            if (isset($get_data['status']) && $get_data['status'] == 'success') {

                $data['result'] = $get_data['result'];

            } else {

                return redirect('promo-campaign')->withErrors($get_data['messages']);
            }

            return view('promocampaign::promo-campaign-step-2', $data);

        }else{

            $post['id_promo_campaign'] = $id_promo_campaign;
            
            $action = MyHelper::post('promo-campaign/step2', $post);

            if (isset($action['status']) && $action['status'] == 'success') {

                return redirect('promo-campaign/step2/' . $id_promo_campaign);
            } 
            elseif($action['messages']??false) {
                return back()->withErrors($action['messages'])->withInput();
            }
            else{
                return back()->withErrors(['Something went wrong'])->withInput();
            }
        }
    }

    public function getTag()
    {
        $action = MyHelper::post('promo-campaign/getTag', ['get' => 'Tag']);

        if (empty($action)) {
            $action = [];
        }
        return $action;
    }

    public function checkCode()
    {
        $action = MyHelper::post('promo-campaign/check', $_GET);

        return $action;
    }

    public function getData()
    {
        $action = MyHelper::post('promo-campaign/getData', ['get' => $_GET['get']]);

        return $action;
    }
}

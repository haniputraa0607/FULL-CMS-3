<?php

namespace Modules\DeliveryService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class DeliveryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('deliveryservice::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('deliveryservice::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    { }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('deliveryservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('deliveryservice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    { }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    { }

    public function detailWebview(Request $request)
    {
        $bearer = $request->header('Authorization');

        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $data = MyHelper::getWithBearer('delivery-service/webview?log_save=0', $bearer);

        // dd($data);
        return view('deliveryservice::webview.detail', $data);
    }
}

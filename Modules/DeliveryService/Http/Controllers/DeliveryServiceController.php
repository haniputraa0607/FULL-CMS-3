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
        $bearer = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFiZjU2NTI1N2I2MmY1ZjhkOWYyMTI5ZWFkNDZmN2I0MTdiNzBlMTM2ZTI4NDc4YTY1NmE3Yjc3YTQxNDY2MTU4Y2U1YTk5MThmYzU5YWViIn0.eyJhdWQiOiIyIiwianRpIjoiMWJmNTY1MjU3YjYyZjVmOGQ5ZjIxMjllYWQ0NmY3YjQxN2I3MGUxMzZlMjg0NzhhNjU2YTdiNzdhNDE0NjYxNThjZTVhOTkxOGZjNTlhZWIiLCJpYXQiOjE1NjkyOTkyMTEsIm5iZiI6MTU2OTI5OTIxMSwiZXhwIjoyODY1Mjk5MjExLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.GtvJNFp3RERbU1QyFkVQvZ1A_flyBBdMOAa6McrDA-u-7LkeDnKItG4UvxJdtRS87e4MhjfMrWkTNMbS5Aqq4vsckeJjG1c2HNiH9ipfB1UdQ4J3k4_JFmHQ7XoxmdG0D7zsPI4tJ2VUFzs3HrDnaXX6hah8JJLwYwnc2_J59CLNkVLV4OTxuaGGs023KNCT_8_7_gnwXn_MXxQCL0s1DzV44_ZXEI3uzapqRUiPCYplaBUU0KDyaNpQSP00weBHtxjIv6cV-FSJDUcwxR8dfi_OJ_Z2UwNjhjf_J68yTRo7GF6RP_4vPzGhU85z_zE-6ldCV5j7K3TqTUbQQh51GeyhXSrs9PzfQBPBbMCrM2AIc3low-3GOE6hIrmHwMucCDSNA6mr6PtOPRB5PWTpx1lAC5llYJm3Xed_MVDadSd-qpvGTGsMugiwWMNoQdRRiStm_i6zqSfVwvFvFUJxg6yDgTYlcRl6MABrL7-8yKd1f24GK09kLunIa8TEtzTqhst5bbvaLPSpyuWQTOmcZpGlX67TRDOldljLEAn5bhgPqXUMXRYG2JtHjWjNvqPhmRTVP3MoTAlIxy0NNLtnw3q5FTsaixJQx9r9c3Gt5CdEgHW74jP2DHr8QiBK1mWBlLWlQo85dZfAGbtQn2_qCAQOm-ooYzGtIuUsty-4DdU";
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $data = MyHelper::getWithBearer('delivery-service/webview?log_save=0', $bearer);

        // dd($data);
        return view('deliveryservice::webview.detail', $data);
    }
}

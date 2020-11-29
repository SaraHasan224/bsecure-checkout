<?php

namespace App\Http\Controllers;

use bSecure\UniveralCheckout\BsecureCheckout;
use bSecure\UniveralCheckout\BsecureSSO;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /*
     *  CHECKOUT
    */
    public function createOrder(Request $request)
    {
        $requestData = $request->all();
        $order = new BsecureCheckout();
        return $order->createOrder($requestData);
    }

    public function manualOrderStatusUpdate(Request $request)
    {
        $requestData = $request->all();
        $order_ref = $requestData['order_ref'];
        $orderStatus = $requestData['status'];

        $order = new BsecureCheckout();
        return $order->updateManualOrderStatus($order_ref,$orderStatus);
    }

    public function orderStatus(Request $request)
    {
        $requestData = $request->all();

        $order_ref = $requestData['order_ref'];

        $order = new BsecureCheckout();
        return $order->orderUpdates($order_ref);
    }

    /*
     *  SSO
    */
    public function ssoWebLogin(Request $request)
    {
        $requestData = $request->all();
        $state = $requestData['state'];

        $client = new BsecureSSO();
        return $client->authenticateWebClient($state);
    }


    public function ssoSDKLogin(Request $request)
    {
        $requestData = $request->all();

        $state = $requestData['state'];

        $client = new BsecureSSO();
        return $client->authenticateSDKClient($state);
    }

    public function verifyCustomer(Request $request)
    {
        $requestData = $request->all();
        $auth_code = $requestData['code'];

        $client = new BsecureSSO();
        return $client->customerProfile($auth_code);
    }

}

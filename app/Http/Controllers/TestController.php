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
    public function ssoLogin(Request $request)
    {
        $requestData = $request->all();
        $client = new BsecureSSO();
        return $client->authenticateClient($requestData);
    }

    public function verifyCustomer(Request $request)
    {
        $requestData = $request->all();
        $client = new BsecureSSO();
        return $client->customerProfile($requestData);
    }

}

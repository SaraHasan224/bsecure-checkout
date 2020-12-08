<?php

namespace App\Http\Controllers;

use bSecure\UniversalCheckout\BsecureCheckout;
use bSecure\UniversalCheckout\BsecureSSO;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /*
     *  CHECKOUT
    */
    public function createOrder(Request $request)
    {
        $requestData = $request->all();

        $orderId = array_key_exists('order_id',$requestData) ? $requestData['order_id'] : null;
        $products = array_key_exists('products',$requestData) ? $requestData['products'] : null;
        $customer = array_key_exists('customer',$requestData) ? $requestData['customer'] : null;
        $shipment = array_key_exists('shipment',$requestData) ? $requestData['shipment'] : null;

        $order = new BsecureCheckout();

        $order->setOrderId($orderId);
        $order->setCustomer($customer);
        $order->setCartItems($products);
//        $order->setShipmentDetails($shipment);

        return $order->createOrder();
    }


    public function orderStatus(Request $request)
    {
        $requestData = $request->all();

        $order_ref = $requestData['order_ref'];

        $order = new BsecureCheckout();
        return $order->orderStatusUpdates($order_ref);
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

    //Receive authcode after successfull login


}

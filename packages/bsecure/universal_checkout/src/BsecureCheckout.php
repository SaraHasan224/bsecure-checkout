<?php

namespace bSecure\UniveralCheckout;

use bSecure\UniveralCheckout\Controllers\Orders\CreateOrderController;
use bSecure\UniveralCheckout\Controllers\Orders\IOPNController;
use bSecure\UniveralCheckout\Controllers\Orders\OrderStatusUpdateController;

use bSecure\UniveralCheckout\Helpers\ApiResponseHandler;
use Illuminate\Support\Facades\Facade;

class BsecureCheckout extends Facade
{
    /*
     *  CREATE ORDER: Create Order using Merchant Access Token from Merchant backend server
    */
    public function createOrder($requestData)
    {
        try {
            $order = new CreateOrderController();
            return $order->create($requestData);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    /*
     *  INSTANT ORDER PROCESSING NOTIFICATIONS : Get order status for merchant
    */

    public function orderUpdates($order_ref = null)
    {
        try {
            $customer = new IOPNController();
            return $customer->orderStatus($order_ref);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
     *  MANUAL ORDERS STATUS UPDATE: Update order status for merchant's manual orders
    */
    public function updateManualOrderStatus($order_ref = null,$orderStatus = null)
    {
        try {
            $order = new OrderStatusUpdateController();
            return $order->updateStatus($order_ref,$orderStatus);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
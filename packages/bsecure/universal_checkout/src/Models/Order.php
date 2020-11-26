<?php

namespace bSecure\UniveralCheckout\Models;

use bSecure\UniveralCheckout\Models\Merchant;
use bSecure\UniveralCheckout\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static $validationRules = [
      'createOrder' => [

        'order_id'                     => 'required',

        'products'                     => 'required',
        'products.*.id'                => 'required|string|min:1|max:100|not_in:0',
        'products.*.name'              => 'required|string|min:1|max:100',
        'products.*.sku'               => 'nullable|string|max:25',
        'products.*.quantity'          => 'required|integer|max:999',
        'products.*.price'             => 'required|numeric|regex:/^\d+(\.\d{1,4})?$/|not_in:0',
        'products.*.sale_price'        => 'required|numeric|regex:/^\d+(\.\d{1,4})?$/',
        'products.*.image'             => 'required|url',
        'products.*.description'       => 'nullable|string',
        'products.*.short_description' => 'nullable|string|max:1000',
      ],
      'order-status' => [
        'order_ref'                     => 'required',
      ],
      'manual-order-status-update' => [
        'order_ref'                     => 'required',
        'status'                     => 'required|integer',
      ]
    ];


    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function createMerchantOrder($orderPayload)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Create Order API
                $order_response = Helper::createOrder($merchantAccessToken, $orderPayload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.failure'), 'exception' => $e->getTraceAsString()];
        }
    }


    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function getOrderStatus($order_ref)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Order Status Update API

                $payload = ['order_ref'=>$order_ref];

                $order_response = Helper::orderStatus($merchantAccessToken, $payload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.status.failure'), 'exception' => $e->getTraceAsString()];
        }
    }



    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function updateManualOrderStatus($payload)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Order Status Update API
                $order_response = Helper::manualOrderStatusUpdate($merchantAccessToken, $payload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.status.failure'), 'exception' => $e->getTraceAsString()];
        }
    }


    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public static function getMerchantStatus($order_ref)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Create Order API
                $order_response = Helper::createOrder($merchantAccessToken, $order_ref);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.failure'), 'exception' => $e->getTraceAsString()];
        }
    }

}

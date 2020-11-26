<?php

namespace bSecure\UniveralCheckout\Controllers\Orders;

use App\Http\Controllers\Controller;


//Models
use bSecure\UniveralCheckout\Models\Order;

//Helper
use bSecure\UniveralCheckout\Helpers\AppException;
use bSecure\UniveralCheckout\Helpers\ApiResponseHandler;

//Facade
use Validator;

//Instant Order Processing Notification
class IOPNController extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public function orderStatus($requestData)
    {
        try {
            $validator = Validator::make($requestData, Order::$validationRules['order-status']);

            if ($validator->fails()) {
                return ApiResponseHandler::validationError($validator->errors());
            }

            $order_ref = $requestData['order_ref'];

            $orderResponse = Order::getOrderStatus($order_ref);

            if($orderResponse['error'])
            {
                return ApiResponseHandler::failure($orderResponse['message']);
            }else{
                $response = $orderResponse['body'];

                return ApiResponseHandler::success($response, trans('bSecure::messages.order.status.success'));
            }
        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.order.status.failure'), $e->getTraceAsString());
        }
    }

}

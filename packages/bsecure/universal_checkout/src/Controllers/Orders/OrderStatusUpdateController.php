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

class OrderStatusUpdateController extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public function updateStatus($requestData)
    {
        try {
            $validator = Validator::make($requestData, Order::$validationRules['manual-order-status-update']);

            if ($validator->fails()) {
                return ApiResponseHandler::validationError($validator->errors());
            }

            $payload = [
              'order_ref'=>$requestData['order_ref'],
              'status' => $requestData['status']
            ];

            $orderResponse = Order::updateManualOrderStatus($payload);

            if($orderResponse['error'])
            {
                return ApiResponseHandler::failure($orderResponse['message']);
            }else{
                $response = $orderResponse['body'];

                return ApiResponseHandler::success($response, trans('bSecure::messages.order.status.updated.success'));
            }
        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.order.status.updated.failure'), $e->getTraceAsString());
        }
    }

}

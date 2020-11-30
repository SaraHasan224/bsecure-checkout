<?php

namespace bSecure\UniversalCheckout\Controllers\Orders;

use App\Http\Controllers\Controller;


//Models
use bSecure\UniversalCheckout\Helpers\Constant;
use bSecure\UniversalCheckout\Models\Order;

//Helper
use bSecure\UniversalCheckout\Helpers\AppException;
use bSecure\UniversalCheckout\Helpers\ApiResponseHandler;

//Facade
use Validator;

class OrderStatusUpdateController extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public function updateStatus($order_ref, $status)
    {
        try {

            $validationErrors = $this->_checkForValidationRule($order_ref, $status);

            if (count($validationErrors) > 0) {
                return ApiResponseHandler::validationError($validationErrors);
            }

            $payload = [
              'order_ref' => $order_ref,
              'status' => $status
            ];

            $orderResponse = Order::updateManualOrderStatus($payload);

            if ($orderResponse['error']) {
                return ApiResponseHandler::failure($orderResponse['message']);
            } else {
                $response = $orderResponse['body'];

                return ApiResponseHandler::success($response, trans('bSecure::messages.order.status.updated.success'));
            }
        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.order.status.updated.failure'), $e->getTraceAsString());
        }
    }

    private function _checkForValidationRule($order_ref, $status)
    {
        $errors = [];

        if (empty($order_ref)) {
            $errors[] = trans('bSecure::messages.validation.order_ref.required');
        } else if (empty($status)) {
            $errors[] = trans('bSecure::messages.validation.order_status.required');
        } else if (!in_array($status,Constant::OrderStatus)) {
            $errors[] = trans('bSecure::messages.validation.order_status.not_matched');
        }

        return $errors;
    }

}

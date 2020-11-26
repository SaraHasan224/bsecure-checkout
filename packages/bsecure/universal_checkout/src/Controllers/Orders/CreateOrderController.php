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


class CreateOrderController extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public function create($requestData)
    {
        try {
            $validator = Validator::make($requestData, Order::$validationRules['createOrder']);

            if ($validator->fails()) {
                return ApiResponseHandler::validationError($validator->errors());
            }

            $orderPayload = $this->createOrderDataStructure($requestData);
            $orderResponse = Order::createMerchantOrder($orderPayload);

            if($orderResponse['error'])
            {
                return ApiResponseHandler::failure($orderResponse['message']);
            }else{
                $response = $orderResponse['body'];

                return ApiResponseHandler::success($response, trans('bSecure::messages.order.success'));
            }
        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.order.failure'), $e->getTraceAsString());
        }
    }


    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    private function createOrderDataStructure($requestData)
    {
        $orderItems = [];
        $sub_total_amount = 0;
        $total_discount = 0;
        $orderItems['products'] = [];

        $products = $requestData['products'];


        foreach ($products as $key => $product) {
            $price = $product['price'];
            $sale_price = $product['sale_price'];
            $quantity = $product['quantity'] ?? 1;
            $discount = ($price - $sale_price) * $quantity;
            $sub_total_with_discount = ($sale_price * $quantity);
            $sub_total_without_discount = ($price * $quantity);

            $orderItems['products'][] = [
              "id" => $product['id'],
              "name" => $product['name'],
              "sku" => $product['sku'],
              "quantity" => $quantity,
              "price" => $price,
              "discount" => $discount,
              "sale_price" => $sale_price,
              "sub_total" => $sub_total_with_discount,
              "image" => $product['image'],
              "short_description" => $product['short_description'],
              "description" => $product['description'],
            ];
            $total_discount += $discount;
            $sub_total_amount += $sub_total_without_discount;
        }

        $order_grand_total = $sub_total_amount-$total_discount;

        $orderData['products'] = $orderItems['products'];
        $orderData['order_id'] = $requestData['order_id'];
        $orderData['sub_total_amount'] = $sub_total_amount;
        $orderData['discount_amount'] = $total_discount;
        $orderData['total_amount'] = $order_grand_total;
        $orderData['customer'] = [
          "country_code" => '',
          "phone_number" => '',
          "name" => '',
          "email" => ''
        ];

        return $orderData;
    }
}

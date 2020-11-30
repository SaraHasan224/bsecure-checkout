<?php

namespace bSecure\UniversalCheckout\Controllers\Orders;

use App\Http\Controllers\Controller;

//Models
use bSecure\UniversalCheckout\Models\Order;

//Helper
use bSecure\UniversalCheckout\Helpers\AppException;
use bSecure\UniversalCheckout\Helpers\ApiResponseHandler;

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

        //Customer

        $orderData['customer'] = $this->createCustomerDataStructure($requestData);

        return $orderData;
    }

    private function createCustomerDataStructure($requestData)
    {
        $customerData = $requestData['customer'];

        $auth_code = array_key_exists('auth_code',$customerData) ? $customerData['auth_code'] : '' ;

        if( !empty( $auth_code ) )
        {
            $customer = [
              "auth_code" => $auth_code,
            ];;
        }
        else{
            $customer = [
              "country_code" => array_key_exists('country_code',$customerData) ? $customerData['country_code'] : '',
              "phone_number" => array_key_exists('phone_number',$customerData) ? $customerData['phone_number'] : '',
              "name" => array_key_exists('name',$customerData) ? $customerData['name'] : '',
              "email" => array_key_exists('email',$customerData) ? $customerData['email'] : '',
            ];
        }

        return $customer;
    }
}
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

    protected $validationRule = [
      'order_id' => 'order_id',
      'customer' => 'customer',
      'products' => 'products',
    ];



    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public function create($orderData)
    {
        try {
            $validator = Validator::make($orderData, Order::$validationRules['createOrder']);

            if ($validator->fails()) {
                return ApiResponseHandler::validationError($validator->errors());
            }

            $orderResponse = Order::createMerchantOrder($orderData);

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


    public function _setProductsDataStructure($products)
    {
        $orderData = [
          'products' => null,
          'sub_total_amount' => null,
          'discount_amount' => null,
          'total_amount' => null,
        ];

        if(!empty($products))
        {

            $orderItems = [];
            $sub_total_amount = 0;
            $total_discount = 0;
            $orderItems['products'] = [];

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
            $orderData['sub_total_amount'] = $sub_total_amount;
            $orderData['discount_amount'] = $total_discount;
            $orderData['total_amount'] = $order_grand_total;
        }
        return $orderData;
    }


    public function _setCustomer($customerData)
    {
        $customer = [];
        if(!empty($customerData))
        {
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
        }

        return $customer;
    }

}

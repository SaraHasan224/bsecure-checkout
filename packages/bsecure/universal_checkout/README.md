[![Latest Stable Version](https://poser.pugx.org/bsecure/universal-checkout/v)](//packagist.org/packages/bsecure/universal-checkout) [![Total Downloads](https://poser.pugx.org/bsecure/universal-checkout/downloads)](//packagist.org/packages/bsecure/universal-checkout) [![Latest Unstable Version](https://poser.pugx.org/bsecure/universal-checkout/v/unstable)](//packagist.org/packages/bsecure/universal-checkout) [![License](https://poser.pugx.org/bsecure/universal-checkout/license)](//packagist.org/packages/bsecure/universal-checkout)


bSecure Checkout 
=========================
 Pakistan's first universal checkout solution for ecommerce stores built on woocommerce, magento, shopify and more
## About bSecure Checkout ##
bSecure is a one-click checkout solution for selling your products all across the globe instantly. We bring everything together that’s required to manage and streamline your product checkout for an instant buying experience. A security-centric approach with every transaction encrypted and never compromising on transparency of user needs and expectations.

## Installation
bSecure univeral checkout and SSO Integration

``composer require bSecure/univeral-checkout``

Add provider for bSecure checkout and single-sign-on in app.php

`` bSecure\UniveralCheckout\CreateOrderServiceProvider::class ``

`` bSecure\UniveralCheckout\SSOServiceProvider::class ``

Add alias

`` 'BsecureCheckout' => bSecure\UniveralCheckout\BsecureCheckout::class ``

`` 'BsecureSSO' => bSecure\UniveralCheckout\BsecureSSO::class ``


### Publish the language file.
  ``php artisan vendor:publish --provider="bSecure\UniveralCheckout\CreateOrderServiceProvider"``
  
   ``php artisan vendor:publish --provider="bSecure\UniveralCheckout\SSOServiceProvider"``

It will create a vendor/bSecure folder inside resource/lang folder. If you want to customize the error messages your can overwrite the file.

### Publish the configuration file
  ``php artisan vendor:publish --provider="bSecure\UniveralCheckout\CreateOrderServiceProvider" --tag="config""``

  ``php artisan vendor:publish --provider="bSecure\UniveralCheckout\SSOServiceProvider" --tag="config""``

A file (bSecure.php) will be placed in config folder.

```

return [
  'client_id' => env('BSECURE_CLIENT_ID', ''),
  'client_secret' => env('BSECURE_CLIENT_SECRET',''),

  'environment' => env('BSECURE_ENVIRONMENT'),
];
```


## bSecure Checkout

#### Create Order
To create an order, you need to pass order_id and products in createOrder() 

```
use bSecure\UniveralCheckout\BsecureCheckout;

$order = new BsecureCheckout();
$result =  $order->createOrder($orderPayload);
return $result;
```
Your orderPayload will contain order_id and cart items.
```
array (
  'order_id' => 'your-order-id',
  'products' => 
  array (
    0 => 
    array (
      'id' => 'product-id',
      'name' => 'product-name',
      'sku' => 'product-sku',
      'quantity' => 0,
      'price' => 0,
      'sale_price' => 0,
      'image' => 'product-image',
      'description' => 'product-description',
      'short_description' => 'product-short-description',
    ),
  ),
)
```

In response, it will return order expiry, checkout_url, order_reference and merchant_order_id.
```
array (
  'expiry' => '2020-11-27 10:55:14',
  'checkout_url' => 'bSecure-checkout-url',
  'order_reference' => 'bsecure-reference',
  'merchant_order_id' => 'your-order-id',
) 
```
If you are using a web-solution then simply redirect the user to checkout_url
```
if(!empty($result['checkout_url']))
return redirect($result['checkout_url']); 
```
If you have Android or Ios SDK then initialize your sdk and provide order_reference to it
```
if(!empty($result['order_reference']))
return $result['order_reference']; 
```
When order is created successfully on bSecure, you will be redirected to bSecure SDK or bSecure checkout app where you will process your checkout.

#### Order Updates
To receive order updates, you need to pass order_ref in orderUpdates() 

```
use bSecure\UniveralCheckout\BsecureCheckout;

$order_ref = $order->order_ref;

$orderStatusUpdate = new BsecureCheckout();
$result =  $orderStatusUpdate->orderUpdates($order_ref);
return $result;
```

You will then receive all order related information.
```
array (
    'merchant_order_id' => 'test-order',
    'order_ref' => 'bsecure-reference',
    'order_type' => 'App/Manual',
    'placement_status' => '3',
    'payment_status' => '0',
    'customer' => 
    array (
      'name' => 'xxx',
      'email' => 'xxx',
      'country_code' => xx,
      'phone_number' => 'xxx',
      'gender' => NULL,
      'dob' => NULL,
    ),
    'payment_method' => 
    array (
      'id' => 1,
      'name' => 'Cash on Delivery',
    ),
    'card_details' => NULL,
    'delivery_address' => 
    array (
      'name' => NULL,
      'country' => 'Pakistan',
      'province' => 'Sindh',
      'city' => 'Karachi',
      'area' => 'PECHS',
      'address' => 'Dilkusha Forum, 7 Tariq Rd, Delhi Society Delhi CHS PECHS, Karachi, Karachi City, Sindh, Pakistan',
      'lat' => '24.8784263',
      'long' => '67.0641403',
    ),
    'shipment_method' => 
    array (
      'id' => 1,
      'name' => 'Free Shipping',
      'description' => 'my shipment',
      'cost' => 100,
    ),
    'items' => 
    array (
      0 => 
      array (
        'product_id' => '1',
        'product_name' => 'BAZIC Asst. Size Paint Brush Set (15/Pack)',
        'product_sku' => 'abc-123',
        'product_qty' => 1,
      )
    ),
    'created_at' => '2020-11-26 15:00:34',
    'time_zone' => 'Asia/Karachi',
    'summary' => 
    array (
      'total_amount' => 278.5,
      'sub_total_amount' => 248.5,
      'discount_amount' => 70,
      'shipment_cost' => 100,
    ),
  ),
```

#### Order Updates
To update order status for manually created orders, you need to pass order_ref and status in updateManualOrderStatus() 

```
use bSecure\UniveralCheckout\BsecureCheckout;

$order = new BsecureCheckout();
$result =  $order->updateManualOrderStatus($order_ref,$orderStatus);
return $result;
```


## bSecure Single Sign On (SSO)
Before using bSecure SSO, you will also need to add credentials for the OAuth services your application utilizes. These credentials should be placed in your config/bSecure.php configuration file. For example:

```

return [
  'client_id' => env('BSECURE_CLIENT_ID', ''),
  'client_secret' => env('BSECURE_CLIENT_SECRET',''),

  'environment' => env('BSECURE_ENVIRONMENT'),
];
```
####Routing
Next, you are ready to authenticate users! You will need two routes: one for redirecting the user to the OAuth provider, and another for receiving the customer profile from the provider after authentication. We will access BsecureSSO using the BsecureSSO Facade:

You will need to define routes to your controller methods

```
Route::post('/login/bSecure', 'TestController@redirectToProvider');
Route::post('/login/bSecure/callback', 'TestController@handleProviderCallback');
```

```

<?php

namespace App\Http\Controllers;

use bSecure\UniveralCheckout\BsecureSSO;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Redirect the user to the bSecure authentication page.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function redirectToProvider(Request $request)
    {
        $requestData = $request->all();
        $client = new BsecureSSO();
        $redirect = $client->authenticateClient($requestData);
        return $redirect;
    }

}

```

In response, it will return request_id, merchant_name, store_url.
```
array (
  'request_id' => 'request-id',
  'merchant_name' => 'your-public-company-name',
  'store_url' => 'your-public-company-name',
)
```
Pass this request_id, merchant_name, store_url to your SDK.
 
```

<?php

namespace App\Http\Controllers;

use bSecure\UniveralCheckout\BsecureSSO;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Obtain the user information from bSecure.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function handleProviderCallback(Request $request)
    {
        $requestData = $request->all();
        $client = new BsecureSSO();
        return $client->customerProfile($requestData);
    }
}

```


In response, it will return customer name, email, phone_number, country_code, address book.
```
array (
    'name' => 'customer-name',
    'email' => 'customer-email',
    'phone_number' => 'customer-phone-number',
    'country_code' => customer-phone-code,
    'address' => 
        array (
          'country' => '',
          'state' => '',
          'city' => '',
          'area' => '',
          'address' => '',
          'postal_code' => '',
        ),
)
```

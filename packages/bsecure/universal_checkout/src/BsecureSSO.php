<?php

namespace bSecure\UniveralCheckout;

use bSecure\UniveralCheckout\Controllers\SSO\CustomerVerification;
use bSecure\UniveralCheckout\Controllers\SSO\VerifyClientController;

use Illuminate\Support\Facades\Facade;

class BsecureSSO extends Facade
{
    /*
     *  CLIENT VERIFICATION : SSO Verify Client
    */
    public function authenticateClient($requestData)
    {
        try {
            $client = new VerifyClientController();
            return $client->verifyClient($requestData);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
     *  Customer Verification : Get Customer Profile
    */

    public function customerProfile($requestData)
    {
        try {
            $customer = new CustomerVerification();
            return $customer->verifyCustomer($requestData);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
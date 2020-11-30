<?php

namespace bSecure\UniversalCheckout;

use bSecure\UniversalCheckout\Controllers\SSO\CustomerVerification;
use bSecure\UniversalCheckout\Controllers\SSO\VerifyClientController;

use bSecure\UniversalCheckout\Helpers\Constant;
use Illuminate\Support\Facades\Facade;

class BsecureSSO extends Facade
{
    /*
     *  CLIENT VERIFICATION : SSO Verify Client for web
    */
    public function authenticateWebClient($state = null)
    {
        try {
            $client = new VerifyClientController();
            return $client->verifyClient($state,Constant::APP_TYPE['checkout']);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
     *  CLIENT VERIFICATION : SSO Verify Client for sdk
    */
    public function authenticateSDKClient($state = null)
    {
        try {
            $client = new VerifyClientController();
            return $client->verifyClient($state,Constant::APP_TYPE['sdk']);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
     *  Customer Verification : Get Customer Profile
    */

    public function customerProfile($auth_code = null)
    {
        try {
            $customer = new CustomerVerification();
            return $customer->verifyCustomer($auth_code);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
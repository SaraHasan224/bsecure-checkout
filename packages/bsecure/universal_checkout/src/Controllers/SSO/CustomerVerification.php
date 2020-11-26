<?php

namespace bSecure\UniveralCheckout\Controllers\SSO;

use App\Http\Controllers\Controller;

//Models
use bSecure\UniveralCheckout\Models\Customer;

//Helper
use bSecure\UniveralCheckout\Helpers\AppException;
use bSecure\UniveralCheckout\Helpers\ApiResponseHandler;
use bSecure\UniveralCheckout\Helpers\Helper;

//Facade
use Validator;

class CustomerVerification extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public function verifyCustomer($requestData)
    {
        try {

            $validator = Validator::make($requestData, Customer::$validationRules['verify-customer']);

            if ($validator->fails()) {
                return ApiResponseHandler::validationError($validator->errors());
            }

            $ssoCustomerProfile = $this->createSSOProfileStructure($requestData);

            $ssoResponse = Helper::customerProfile($ssoCustomerProfile);

            if($ssoResponse['error'])
            {
                return ApiResponseHandler::failure($ssoResponse['message']);
            }else{
                $response = $ssoResponse['body'];
                return ApiResponseHandler::success($response, trans('bSecure::messages.customer.verification.success'));
            }

        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.customer.verification.failure'), $e->getTraceAsString());
        }
    }

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    private function createSSOProfileStructure($responseData)
    {
        $sso_client = [];

        $sso_client['code'] = $responseData['code'];

        return $sso_client;
    }
}

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

class VerifyClientController extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public function verifyClient($requestData)
    {
        try {
            $validator = Validator::make($requestData, Customer::$validationRules['verify-client']);

            if ($validator->fails()) {
                return ApiResponseHandler::validationError($validator->errors());
            }

            $ssoPayload = $this->createSSODataStructure($requestData);

            $ssoResponse = Helper::verifyClient($ssoPayload);

            if($ssoResponse['error'])
            {
                return ApiResponseHandler::failure($ssoResponse['message']);
            }else{
                $response = $ssoResponse['body'];
                return ApiResponseHandler::success($response, trans('bSecure::messages.sso_sco.success'));
            }

        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.sso_sco.failure'), $e->getTraceAsString());
        }
    }

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    private function createSSODataStructure($responseData)
    {
        $sso_client = [];

        $sso_client['client_id'] = config('bSecure.client_id');
        $sso_client['scope'] = "profile";
        $sso_client['response_type'] = "code";
        $sso_client['state'] = $responseData['state'];

        return $sso_client;
    }
}

<?php

namespace bSecure\UniveralCheckout\Helpers;

class Constant
{
    const HTTP_RESPONSE_STATUSES = [
      'success'             => 200,
      'failed'              => 400,
      'validationError'     => 422,
      'authenticationError' => 401,
      'authorizationError'  => 403,
      'serverError'         => 500,
    ];

    const AUTH_SERVER_URL = 'https://api-dev.bsecure.app/';

    const API_VERSION = 'v1';

    const API_ENDPOINTS = [
      'oauth'               => Constant::API_VERSION . '/oauth/token',
      'create_order' => Constant::API_VERSION . '/order/create',
      'order_status' => Constant::API_VERSION . '/order/status',
      'manual_order_status_update' => Constant::API_VERSION . '/order/update-status',
      'verify_client' => Constant::API_VERSION . '/sso/verify-client',
      'customer_profile' => Constant::API_VERSION . '/sso/customer/profile',
    ];


}
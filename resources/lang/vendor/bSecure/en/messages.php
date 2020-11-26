<?php

return [
  'general' => [
    'failed' => 'Request Failed',
    'success' => 'Request Successful',
    'validation' => 'Validation Error',
    'crashed' => 'Something went wrong',
    'unauthenticated' => 'Authentication Failed',
    'unauthorized' => 'Authorization Failed',
  ],
  'client' => [
    'invalid' => 'Invalid client id or secret provided',
    'id' => [
      'invalid' => 'Invalid client id provided',
    ],
    'secret' => [
      'invalid' => 'Invalid client secret provided',
    ],
    'environment' => [
      'invalid' => 'Invalid environment or secret keys provided',
    ]
  ],
  'order' => [
    'success' => 'Order placed successfully',
    'failure' => 'Unable to place order. Try again later',
    'status' => [
      'success' => 'Order status updated successfully',
      'failure' => 'Unable to update order status.',
    ]
  ],
  'sso_sco' => [
    'success' => 'Third-party login succeeded.',
    'failure' => 'Third-party login failed, please check the connection with bSecure.',
  ],
  'customer' => [
    'verification' => [
      'success' => 'Customer verified',
      'failure' => 'Customer verification failed',
    ]
  ]

];
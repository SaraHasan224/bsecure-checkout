<?php

return [

  'client_id' => env('BSECURE_CLIENT_ID', ''),
  'client_secret' => env('BSECURE_CLIENT_SECRET',''),

  //use 'production' for live orders and 'sandbox' for testing orders. When left empty or `null` the sandbox environment will be used
  'environment' => env('BSECURE_ENVIRONMENT'),

//  'sentry' => [
//      // Capture Laravel logs in breadcrumbs
//    'logs' => true,
//
//      // Capture SQL queries in breadcrumbs
//    'sql_queries' => true,
//
//      // Capture bindings on SQL queries logged in breadcrumbs
//    'sql_bindings' => true,
//
//      // Capture queue job information in breadcrumbs
//    'queue_info' => true,
//
//      // Capture command information in breadcrumbs
//    'command_info' => true,
//  ],

];

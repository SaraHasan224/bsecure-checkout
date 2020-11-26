<?php

namespace bSecure\UniveralCheckout\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public static $validationRules = [
      'verify-customer' => [
        'code' => 'required',
      ],
      'verify-client' => [
        'state' => 'required',
      ]
    ];
}

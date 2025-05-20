<?php

return [
    'public_key_id'     => env('AMAZON_PAY_PUBLIC_KEY_ID'),
    'merchant_id'       => env('AMAZON_PAY_MERCHANT_ID'),
    'store_id'          => env('AMAZON_PAY_STORE_ID'),
    'private_key_path'  => env('AMAZON_PAY_PRIVATE_KEY_PATH'),
    'region'            => env('AMAZON_PAY_REGION', 'jp'),
    'sandbox'           => env('AMAZON_PAY_SANDBOX', true),
];
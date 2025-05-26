<?php

return [
    'public_key_id'     => env('AMAZON_PAY_PUBLIC_KEY_ID'),
    'merchant_id'       => env('AMAZON_PAY_MERCHANT_ID'),
    'store_id'          => env('AMAZON_PAY_STORE_ID'),
    'private_key_path'  => env('AMAZON_PAY_PRIVATE_KEY_PATH'),
    'region'            => env('AMAZON_PAY_REGION', 'jp'),
    'sandbox'           => env('AMAZON_PAY_SANDBOX', true),
];

/*
AMAZON_PAY_PUBLIC_KEY_ID=SANDBOX-AEZC7YHUHWHU3GP3CKUMV6ZK
AMAZON_PAY_MERCHANT_ID=A2MQAIFB5IWHUJ
AMAZON_PAY_STORE_ID=amzn1.application-oa2-client.aab77b8ffb87409eb6981d5515b33d1a
AMAZON_PAY_PRIVATE_KEY_PATH=storage/app/amazon-pay/private.pem
AMAZON_PAY_REGION=jp
AMAZON_PAY_SANDBOX=true
*/
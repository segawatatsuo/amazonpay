<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AmazonPayService
{
    protected $publicKeyId;
    protected $merchantId;
    protected $storeId;
    protected $privateKey;
    protected $region;
    protected $sandbox;
    protected $host;
    protected $endpoint;

    public function __construct()
    {
        $this->publicKeyId  = config('amazonpay.public_key_id');
        $this->merchantId   = config('amazonpay.merchant_id');
        $this->storeId      = config('amazonpay.store_id');
        $this->region       = config('amazonpay.region', 'jp');
        $this->sandbox      = config('amazonpay.sandbox', true);
        //$this->host         = 'pay-api.amazon.' . $this->region;
        //$this->host = 'sandbox.pay-api.amazon.com';
        $this->host = 'pay-api.amazon.jp';
        //$this->endpoint     = $this->sandbox
        //    ? 'https://pay-api.amazon.' . $this->region . '/sandbox/checkoutSessions'
        //    : 'https://pay-api.amazon.' . $this->region . '/checkoutSessions';

        //$this->endpoint = 'https://sandbox.pay-api.amazon.com/sandbox/checkoutSessions';
        $this->endpoint = 'https://pay-api.amazon.jp/sandbox/checkoutSessions';
        $keyPath = base_path(config('amazonpay.private_key_path'));
        $this->privateKey = file_get_contents($keyPath);
    }

    public function createCheckoutSession(array $payload)
    {

        $method = 'POST';
        $uriPath = $this->sandbox ? '/sandbox/checkoutSessions' : '/checkoutSessions';
        $timestamp = gmdate('Ymd\THis\Z');

        $payloadJson = json_encode($payload, JSON_UNESCAPED_SLASHES);
        $stringToSign = implode("\n", [
            $method,
            $uriPath,
            $this->host,
            $timestamp,
            $payloadJson
        ]);


        // ログ出力（ここで定義済みの変数を出力）
        \Log::debug('Amazon Pay payload:', ['payload' => $payload]);
        \Log::debug('Amazon Pay payloadJson:', ['payloadJson' => $payloadJson]);
        \Log::debug('Amazon Pay stringToSign:', ['stringToSign' => $stringToSign]);



        // 署名を作成
        openssl_sign(
            $stringToSign,
            $signature,
            $this->privateKey,
            OPENSSL_ALGO_SHA256
        );
        $signatureBase64 = base64_encode($signature);

        \Log::debug('Amazon Pay signature:', ['signature' => $signatureBase64]);

        $authorizationHeader = sprintf(
            'AMZN-PAY-RSASSA-PSS PublicKeyId=%s, SignedHeaders=host;x-amz-pay-date, Signature=%s',
            $this->publicKeyId,
            $signatureBase64
        );

        \Log::debug('Amazon Pay endpoint:', ['endpoint' => $this->endpoint]);

        // API リクエスト送信
        $response = Http::withHeaders([
            'content-type'     => 'application/json',
            'x-amz-pay-date'   => $timestamp,
            //'x-amz-pay-host'   => $this->host,
            'host'   => $this->host,
            'authorization'    => $authorizationHeader,
        ])->withBody($payloadJson, 'application/json')
            ->post($this->endpoint, $payload);



        $body = $response->body();
        \Log::debug('Amazon Pay response:', ['body' => is_string($body) ? $body : json_encode($body)]);

        return $response->json();
    }
}

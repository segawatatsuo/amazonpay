<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AmazonPayService;
use Illuminate\Support\Facades\Log;

class AmazonPayController extends Controller
{
    protected $amazonPayService;

    public function __construct(AmazonPayService $amazonPayService)
    {
        $this->amazonPayService = $amazonPayService;
    }

    // 支払い開始（Checkout Session 作成）
    /*
    public function checkout()
    {
        $payload = [
            'webCheckoutDetails' => [
                'checkoutReviewReturnUrl' => route('amazonpay.return'),
            ],
            'storeId' => config('amazonpay.store_id'),
            'paymentDetails' => [
                'paymentIntent' => 'Authorize',
                'chargeAmount' => [
                    'amount' => '1000',
                    'currencyCode' => 'JPY',
                ],
            ],
            'merchantMetadata' => [
                'merchantReferenceId' => 'ORDER-' . uniqid(),
                'merchantStoreName' => 'AmazonPay Sandbox TestApp',
                'noteToBuyer' => 'ご注文ありがとうございます。',
            ],
        ];

        $response = $this->amazonPayService->createCheckoutSession($payload);
        Log::debug('Amazon Pay response:', $response);  // ログにレスポンスを出力

        if (isset($response['webCheckoutDetails']['checkoutResultReturnUrl'])) {
            return redirect($response['webCheckoutDetails']['checkoutResultReturnUrl']);
        }

        if (isset($response['webCheckoutDetails']['amazonPayRedirectUrl'])) {
            return redirect($response['webCheckoutDetails']['amazonPayRedirectUrl']);
        }

        return back()->with('error', 'Amazon Pay の開始に失敗しました。');
    }
    */

public function checkout()
{
    $payload = [
        'webCheckoutDetails' => [
            'checkoutReviewReturnUrl' => route('amazonpay.return'),
        ],
        'storeId' => config('amazonpay.store_id'),
        'paymentDetails' => [
            'paymentIntent' => 'Authorize',
            'chargeAmount' => [
                'amount' => '1000',
                'currencyCode' => 'JPY',
            ],
        ],
        'merchantMetadata' => [
            'merchantReferenceId' => 'ORDER-' . uniqid(),
            'merchantStoreName' => 'AmazonPay Sandbox TestApp',
            'noteToBuyer' => 'ご注文ありがとうございます。',
        ],
    ];

    $response = $this->amazonPayService->createCheckoutSession($payload);

    if (isset($response['checkoutSessionId'])) {
        return view('amazonpay.button', [
            'checkoutSessionId' => $response['checkoutSessionId'],
        ]);
    }

    return back()->with('error', 'Amazon Pay セッション作成に失敗しました。');
}



    // 戻りURL処理（サンドボックス用）
    public function handleReturn(Request $request)
    {
        return view('amazonpay.return', [
            'params' => $request->all(),
        ]);
    }
}

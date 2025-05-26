<h2>Amazon Pay テスト支払い</h2>

<div id="AmazonPayButton"></div>

<script src="https://static-fe.payments-amazon.com/checkout.js"></script>
<script>
    amazon.Pay.renderButton('#AmazonPayButton', {
        amazonCheckoutSessionId: '{{ $checkoutSessionId }}',
        merchantId: '{{ config("amazonpay.merchant_id") }}',
        sandbox: true
    });
</script>

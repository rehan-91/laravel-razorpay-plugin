<?php

namespace RazorpayPlugin;

use Razorpay\Api\Api;
use Illuminate\Support\Str;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );
    }

    public function createOrder(float $amount, string $currency = 'INR', string $receipt = null, array $notes = []): array
    {
        $receipt = $receipt ?: Str::uuid()->toString();

        $order = $this->api->order->create([
            'receipt'         => $receipt,
            'amount'          => $amount * 100,
            'currency'        => $currency,
            'payment_capture' => 1,
            'notes'           => $notes,
        ]);

        return [
            'order_id' => $order['id'],
            'amount'   => $order['amount'],
            'currency' => $order['currency'],
            'receipt'  => $order['receipt'],
        ];
    }
}

<?php

namespace RazorpayPlugin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RazorpayPlugin\RazorpayService;
use Illuminate\Support\Facades\Log;

class RazorpayController extends Controller
{
    protected $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $order = $this->razorpay->createOrder($validated['amount']);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $generatedSignature = hash_hmac(
            'sha256',
            $request->razorpay_order_id . "|" . $request->razorpay_payment_id,
            config('razorpay.secret')
        );

        if (hash_equals($generatedSignature, $request->razorpay_signature)) {
            Log::info('Razorpay Payment Verified', $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully.',
            ]);
        }

        Log::warning('Razorpay Signature Mismatch', $request->all());

        return response()->json([
            'success' => false,
            'message' => 'Payment verification failed.',
        ], 400);
    }
}

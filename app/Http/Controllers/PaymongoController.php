<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymongoController extends Controller
{
    public function createCheckout(Request $request)
    {
        $amount = $request->input('amount');   // in PHP pesos

        if (!$amount) {
            return response()->json(['error' => 'Amount required'], 400);
        }

        // Amount in centavos
        $amountCentavos = intval($amount * 100);

        $payload = [
            'data' => [
                'attributes' => [
                    'payment_method_types' => ['card','gcash','grab_pay'],  // choose allowed methods
                    'line_items' => [
                        [
                            'name' => $request->input('name') ?? 'Order',
                            'quantity' => 1,
                            'amount' => $amountCentavos,
                            'currency' => 'PHP',
                            // optional: 'description', 'images' ...
                        ]
                    ],
                    'description' => $request->input('description') ?? 'Order payment',
                    'success_url' => url('/payment/success'),
                    'cancel_url' => url('/payment/cancel'),
                    // optionally: 'send_email_receipt' => true/false
                ]
            ]
        ];

        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->post('https://api.paymongo.com/v1/checkout_sessions', $payload);

        return response()->json($response->json());
    }
    public function success()
    {
        return view('payment.success');
    }
}

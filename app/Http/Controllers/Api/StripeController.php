<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('constant.STRIPE_SECRET_KEY'));
        
        $amount = $request->input('amount', 1000); 

        $baseUrl = config('app.url'); 

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => 'Test Product',
                    ],
                    'unit_amount' => $amount, // $10.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $baseUrl . 'payment-success',
            'cancel_url' => $baseUrl . 'payment-cancelled'
        ]);
        // dd($session);

        return response()->json(['id' => $session->id,'url' => $session->url]);
 
    }

    public function handleWebhook(Request $request)
    {
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); // get this from Stripe dashboard
        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        dd($endpointSecret,$payload,$sigHeader);
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        // if ($event->type === 'checkout.session.completed') {
        //     $session = $event->data->object;

        //     Payment::updateOrCreate(
        //         ['session_id' => $session->id],
        //         [
        //             'email' => $session->customer_email,
        //             'amount' => $session->amount_total,
        //             'payment_status' => $session->payment_status,
        //             'payment_intent' => $session->payment_intent,
        //         ]
        //     );
        // }

        return response('Webhook handled', 200);
    }

    public function getSessionDetails(Request $request)
    {
        $sessionId = $request->sessionId;
        // dd($sessionId);
        if (!$sessionId) {
            return response()->json(['error' => 'Missing session_id'], 400);
        }
        // Set your Stripe Secret Key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Retrieve the Stripe Checkout session
            $session = Session::retrieve($sessionId);

            // Optionally retrieve the payment intent if available
            $paymentIntent = $session->payment_intent
                ? PaymentIntent::retrieve($session->payment_intent)
                : null;

            return response()->json([
                'id' => $session->id,
                'email' => $session->customer_email,
                'amount' => $session->amount_total,
                'currency' => $session->currency,
                'status' => $session->payment_status,
                'payment_intent_id' => $session->payment_intent,
                'created' => date('Y-m-d H:i:s', $session->created),
                'payment_method' => $paymentIntent?->payment_method ?? null,
                'payment_intent_status' => $paymentIntent?->status ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to retrieve payment info',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

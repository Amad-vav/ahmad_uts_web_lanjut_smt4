<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\StripeClient;
use App\Models\Donation;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            return response('Invalid payload', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if (isset($session->payment_status) && $session->payment_status === 'paid') {
                $meta = $session->metadata ?? null;
                $sessionId = $session->id ?? null;

                if ($sessionId) {
                    // Avoid duplicates
                    $exists = Donation::where('stripe_session_id', $sessionId)->exists();
                    if (!$exists) {
                        Donation::create([
                            'mosque_id' => $meta->mosque_id ?? null,
                            'name' => $meta->name ?? 'Anonim',
                            'email' => $meta->email ?? null,
                            'amount' => $meta->amount ?? 0,
                            'message' => $meta->message ?? null,
                            'stripe_session_id' => $sessionId,
                        ]);
                    }
                }
            }
        }

        return response('OK', 200);
    }
}

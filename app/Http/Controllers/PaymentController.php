<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Donation;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'mosque_id' => 'required|exists:mosques,id',
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string',
        ]);

        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            return response()->json(['error' => 'Stripe secret key not configured'], 500);
        }

        $stripe = new StripeClient($stripeSecret);

        try {
            $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'idr',
                    'product_data' => ['name' => 'Donasi untuk Masjid #'.$data['mosque_id']],
                    'unit_amount' => (int)round($data['amount'] * 100),
                ],
                'quantity' => 1,
            ]],
            'success_url' => url('/donate/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/'),
            'metadata' => [
                'mosque_id' => $data['mosque_id'],
                'name' => $data['name'],
                'email' => $data['email'] ?? '',
                'amount' => $data['amount'],
                'message' => $data['message'] ?? '',
            ],
        ]);

        return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect('/')->with('error', 'No session');
        }

        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            return redirect('/')->with('error', 'Stripe secret key not configured');
        }

        $stripe = new StripeClient($stripeSecret);
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if ($session && $session->payment_status === 'paid') {
            $meta = $session->metadata;
            $sessionId = $session->id ?? null;

            if ($sessionId) {
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

            return redirect('/')->with('success', 'Terima kasih! Pembayaran berhasil dan donasi dicatat.');
        }

        return redirect('/')->with('error', 'Pembayaran tidak terselesaikan.');
    }
}

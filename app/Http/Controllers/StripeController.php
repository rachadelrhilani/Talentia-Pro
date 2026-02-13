<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'mad',
                    'product_data' => [
                        'name' => 'Activation Compte Premium',
                    ],
                    'unit_amount' => 50000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        $user = auth()->user();

        $user->update([
            'is_premium' => true,
            'premium_expires_at' => now()->addDays(30),
        ]);

        return redirect()->route('dashboard')->with('success', 'Paiement réussi ! Vous êtes Premium pour 30 jours.');
    }
    public function cancel()
    {
        return redirect()->route('dashboard')->with('info', 'Le paiement a été annulé.');
    }
}

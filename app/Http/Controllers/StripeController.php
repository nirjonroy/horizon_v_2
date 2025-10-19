<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Cart is empty');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        // Build Stripe line items
        $lineItems = [];
        foreach ($cart as $courseId => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => (int) round(((float) $item['price']) * 100), // in cents
                ],
                'quantity' => $item['quantity'] ?? 1,
            ];
        }

        // Build absolute URLs based on current host to avoid APP_URL mismatches
        $baseUrl = $request->getSchemeAndHttpHost();
        $successUrl = $baseUrl . route('stripe.success', [], false) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = $baseUrl . route('stripe.cancel', [], false);

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            // Append the session id so we can verify and store the order
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
{
    $sessionId = $request->query('session_id');
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.view')->with('error', 'No items found for order');
    }

    // Calculate totals
    $subtotal = collect($cart)->reduce(function ($carry, $item) {
        $qty = $item['quantity'] ?? 1;
        return $carry + ((float) $item['price'] * $qty);
    }, 0.0);
    $tax = round($subtotal * 0.05, 2);
    $discount = 0.0;
    $total = round($subtotal + $tax - $discount, 2);

    $status = 'paid';
    $paymentIntentId = null;

    try {
        if ($sessionId) {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $stripeSession = \Stripe\Checkout\Session::retrieve($sessionId);
            $status = $stripeSession->payment_status ?? 'paid';
            $paymentIntentId = $stripeSession->payment_intent ?? null;
        }
    } catch (\Throwable $e) {
        // Still proceed
    }

    // Save order in DB
    try {
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'items' => array_values($cart),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
            'currency' => 'usd',
            'status' => $status,
            'stripe_session_id' => $sessionId,
            'stripe_payment_intent_id' => $paymentIntentId,
        ]);
    } catch (\Throwable $e) {
        return redirect()->route('cart.view')->with('error', 'Failed to save order: ' . $e->getMessage());
    }

    // ---- 📧 Send Emails ----
    $user = auth()->user();

    // To Student
    try {
        \Mail::to($user->email)->send(new \App\Mail\StudentThanksMail($user, $order));
    } catch (\Exception $e) {
        \Log::error('Failed to send student mail: ' . $e->getMessage());
    }

    // To Admin
    try {
        \Mail::to('imad@thehorizonsunlimited.com')->send(new \App\Mail\NewOrderMail($user, $order));
    } catch (\Exception $e) {
        \Log::error('Failed to send admin mail: ' . $e->getMessage());
    }

    // Clear cart
    session()->forget('cart');

    return view('frontend.payment-success');
}

    public function cancel()
    {
        return view('frontend.payment-cancel');
    }
}

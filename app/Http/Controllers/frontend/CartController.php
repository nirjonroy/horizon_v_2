<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PremiumCourse;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        if(!auth()->check()) {
            return redirect()->route('login')->with('error', 'Login to add to cart.');
        }

        $course = PremiumCourse::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $id,
                'title' => $course->title, // <-- changed from name
                'price' => $course->price,
                'image' => $course->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Course added to cart!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        // dd($cart);   
        // Subtotal (supports quantity; defaults to 1)
        $subtotal = collect($cart)->reduce(function ($carry, $item) {
            $qty = $item['quantity'] ?? 1;
            return $carry + ((float)$item['price'] * $qty);
        }, 0.0);

        // Example computations
        $taxRate  = 0.05;                         // 5% tax (adjust as needed)
        $tax      = round($subtotal * $taxRate, 2);
        $discount = 0;                            // plug your discount logic here
        $total    = round($subtotal + $tax - $discount, 2);

        return view('user.cart', compact('cart', 'subtotal', 'tax', 'discount', 'total'));
        // return view('user.cart', compact('cart'));
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Course removed from cart!');
    }

    public function checkout()
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.view')->with('error', 'Your cart is empty!');
    }

    // Totals
    $subtotal = collect($cart)->reduce(function ($carry, $item) {
        $qty = $item['quantity'] ?? 1;
        return $carry + ((float)$item['price'] * $qty);
    }, 0.0);

    $tax      = round($subtotal * 0.05, 2);
    $discount = 0;
    $total    = round($subtotal + $tax - $discount, 2);

    return view('user.checkout', compact('cart', 'subtotal', 'tax', 'discount', 'total'));
}

}

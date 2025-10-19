@extends('frontend.app')

@section('content')
<section class="bg-gray-100 py-12">
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-blue-800 mb-6">Checkout</h2>

        <!-- Order Summary -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Order Summary</h3>
            <ul class="divide-y divide-gray-200 mt-4">
                @foreach($cart as $item)
                    <li class="flex justify-between py-2">
                        <span>{{ $item['title'] }} × {{ $item['quantity'] ?? 1 }}</span>
                        <span>${{ number_format(($item['price'] * ($item['quantity'] ?? 1)), 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 border-t pt-4 text-gray-700">
                <p class="flex justify-between">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </p>
                <p class="flex justify-between">
                    <span>Tax</span>
                    <span>${{ number_format($tax, 2) }}</span>
                </p>
                <p class="flex justify-between font-bold text-blue-800">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </p>
            </div>
        </div>

        <!-- Stripe Checkout Button -->
        <form method="POST" action="{{ route('stripe.checkout') }}">
            @csrf
            <button type="submit"
                class="w-full bg-green-600 text-white py-3 mt-6 rounded-xl font-semibold hover:bg-green-700 transition duration-300">
                Pay with Stripe ( ${{ number_format($total, 2) }} )
            </button>
        </form>
    </div>
</section>
@endsection

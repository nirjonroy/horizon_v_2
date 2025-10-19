@extends('frontend.app')

@section('content')
<section class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Page Title -->
        <h2 class="text-3xl font-bold text-blue-800 mb-8 text-center">
            Your Cart
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Cart Items -->
            <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Selected Courses</h3>
                
                <div class="divide-y">
                    @forelse ($cart as $id => $item)
                        <div class="flex items-center justify-between py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80' }}" 
                                     alt="{{ $item['title'] }}" 
                                     class="w-20 h-20 object-cover rounded-md border"/>
                                <div>
                                    <h4 class="text-lg font-semibold text-blue-800">{{ $item['title'] }}</h4>
                                    <p class="text-sm text-gray-500">{{ $item['instructor'] ?? 'Instructor' }} • {{ $item['duration'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-blue-800">${{ number_format($item['price'], 2) }}</p>
                                <a href="{{ route('cart.remove', $id) }}" 
                                   class="text-red-600 text-sm hover:underline mt-1">Remove</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 py-6 text-center">Your cart is empty.</p>
                    @endforelse
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Order Summary</h3>

                <div class="flex justify-between text-gray-600 mb-2">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600 mb-2">
                    <span>Tax</span>
                    <span>${{ number_format($tax, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600 mb-2">
                    <span>Discount</span>
                    <span>-${{ number_format($discount, 2) }}</span>
                </div>
                <hr class="my-3">
                <div class="flex justify-between text-lg font-bold text-blue-800 mb-6">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>

                @if(count($cart))
                <!-- Checkout Button -->
                <a href="{{ route('checkout') }}" 
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center gap-2">
                    <!-- Checkout Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                         stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                    </svg>
                    Proceed to Checkout
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

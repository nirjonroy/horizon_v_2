@extends('frontend.app')

@section('content')
<section class="bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <aside class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col items-center">
                <img src="https://e7.pngegg.com/pngimages/84/165/png-clipart-united-states-avatar-organization-information-user-avatar-service-computer-wallpaper-thumbnail.png" alt="User" class="w-20 h-20 rounded-full border-4 border-blue-500 mb-3">
                <h3 class="text-lg font-bold text-gray-800">{{ Auth::user()->name }}</h3>
                <p class="text-gray-500 text-sm mb-6">{{ Auth::user()->email }}</p>
            </div>
        </aside>

        <!-- Orders Table -->
        <main class="md:col-span-3 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold text-blue-800 mb-4">My Orders</h2>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-2 px-3">Order ID</th>
                            <th class="py-2 px-3">Course</th>
                            <th class="py-2 px-3">Amount</th>
                            <th class="py-2 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($orders as $order)
                        <tr>
                            <td class="py-2 px-3">{{ $order->id }}</td>
                            <td class="py-2 px-3">
                               @php
    $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
    echo isset($items[0]['title']) ? $items[0]['title'] : 'N/A';
@endphp

                            </td>
                            <td class="py-2 px-3">${{ $order->total }}</td>
                            <td class="py-2 px-3 text-green-600 font-semibold">{{ ucfirst($order->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</section>
@endsection

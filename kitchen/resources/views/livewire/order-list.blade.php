<div class="bg-white p-4 rounded-lg shadow">
    <h3 class="text-xl font-bold mb-4 text-gray-800">{{ ucfirst($status) }} - {{ $orders->count() }}</h3>
    <ul class="space-y-2">
        @foreach ($orders as $order)
            <li wire:key={{$order['id'].'-'.$order['updated_at']}} class="flex items-center p-2 bg-gray-100 rounded">
                <img src="{{ $order->recipe->image }}" alt="{{ $order->recipe->name }}" class="w-12 h-12 object-cover rounded mr-4">
                <div>
                    <p class="font-bold text-gray-700">{{ $order->recipe->name }}</p>
                    <p class="text-sm text-gray-600">Para: {{ $order->customer_name }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>

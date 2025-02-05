<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use App\Models\Order;

class OrderProcessorService
{
    public function requestIngredients(int $orderId): void
    {
        $order = Order::with('recipe')->findOrFail($orderId);

        $data = [
            "ingredients" => $order->recipe->ingredients,
            "order_id" => $orderId,
        ];

        Queue::connection("rabbitmq")->pushRaw(
            json_encode([
                "uuid" => Str::uuid(),
                "job" => "App\\Jobs\\ProcessRawRabbitMQPayload",
                "data" => $data,
                "class" => "App\\Services\\OrderProcessorService"
            ]),
            "ingredient_request"
        );

        Log::info("Ingredients request submitted for order {$orderId}: " . json_encode($data));
    }
}

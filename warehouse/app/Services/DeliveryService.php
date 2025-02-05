<?php

namespace App\Services;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

class DeliveryService
{
    /**
     * @param int $orderId
     * @param array $ingredients
     * @return void
     */
    public function sendToKitchen(int $orderId, array $ingredients): void
    {
        $message = [
            'order_id' => $orderId,
            'ingredients' => $ingredients,
            'status' => 'delivered'
        ];

        Queue::connection("rabbitmq")->pushRaw(
            json_encode([
                "uuid" => Str::uuid(),
                "job" => "App\\Jobs\\ProcessRawRabbitMQPayload",
                "data" => $message,
                "class" => "App\\Services\\OrderPreparation"
            ]),
            "ingredient_delivery"
        );
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

class UpdateStatusService
{
    /**
     * @param int $orderId
     * @param string $status
     * @return void
     */
    public function sendToNotifications(int $orderId, string $status): void
    {
        $message = [
            'order_id' => $orderId,
            'status' => $status
        ];

        Queue::connection("rabbitmq")->pushRaw(
            json_encode([
                "uuid" => Str::uuid(),
                "job" => "App\\Jobs\\ProcessRawRabbitMQPayload",
                "data" => $message,
                "class" => "App\\Actions\\UpdateStatus"
            ]),
            "notifications_queue"
        );
    }
}

<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;

class OrderPreparation
{
    /**
     * @param array $data
     * @return void
     */
    public function process(array $data): void
    {
        $orderId = $data['order_id'];
        $order = Order::query()->find($orderId);
        $order->status = OrderStatus::PROCESSING;
        $order->save();
    }
}

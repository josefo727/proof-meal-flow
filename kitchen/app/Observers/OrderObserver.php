<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Jobs\ProcessOrderStatusTransitionJob;
use App\Models\Order;
use App\Jobs\ProcessOrderJob;
use App\Services\UpdateStatusService;

class OrderObserver
{
    /**
     * @param Order $order
     * @return void
     */
    public function created(Order $order): void
    {
        ProcessOrderJob::dispatch($order->id)
            ->onQueue('default');
    }

    /**
     * @param Order $order
     * @return void
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            if ($order->status !== OrderStatus::PROCESSING) {
                app(UpdateStatusService::class)
                    ->sendToNotifications($order->id, $order->status->value);
            } else {
                ProcessOrderStatusTransitionJob::dispatch($order)
                    ->onQueue('default');
            }
        }
    }
}

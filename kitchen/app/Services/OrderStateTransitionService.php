<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderStateTransitionService
{
    protected const STATES = [
        'processing' => 'ready',
        'ready' => 'delivered',
    ];

    public function handle(Order $order): void
    {
        if (!isset(self::STATES[$order->status->value])) {
            return;
        }

        foreach (self::STATES as $currentState => $nextState) {
            if ($order->status->value === $currentState) {
                sleep(env('PROCESSING_DELAY', 5));
                $this->transitionState($order, $nextState);
            }
        }
    }

    protected function transitionState(Order $order, string $nextState): void
    {
        $order->update(['status' => $nextState]);
    }
}

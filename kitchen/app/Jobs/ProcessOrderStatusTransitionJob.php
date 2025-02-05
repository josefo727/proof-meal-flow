<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\OrderStateTransitionService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrderStatusTransitionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        app(OrderStateTransitionService::class)->handle($this->order);
    }
}

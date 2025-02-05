<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Services\OrderProcessorService;
use App\Services\UpdateStatusService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected int $orderId) {}

    public function handle(UpdateStatusService $updateStatusService, OrderProcessorService $orderProcessorService): void
    {
        $updateStatusService->sendToNotifications($this->orderId, OrderStatus::PENDING->value);

        sleep(env('PROCESSING_DELAY', 5));

        $orderProcessorService->requestIngredients($this->orderId);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->setupRabbitMQ();
    }

    private function setupRabbitMQ(): void
    {
        $rabbitConnection = Queue::connection('rabbitmq');

        $rabbitConnection->declareQueue("ingredient_delivery", true);
        $rabbitConnection->declareQueue("notifications_queue", true);

        $rabbitConnection->declareExchange("warehouse_exchange", "direct", true);
        $rabbitConnection->declareExchange("notifications_exchange", "fanout", true);

        $rabbitConnection->bindQueue("ingredient_delivery", "warehouse_exchange", "deliver_ingredient");
        $rabbitConnection->bindQueue("notifications_queue", "notifications_exchange", "");
    }
}

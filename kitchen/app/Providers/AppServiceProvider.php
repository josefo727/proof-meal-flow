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

        // Declare queues
        $rabbitConnection->declareQueue('ingredient_request', true);
        $rabbitConnection->declareQueue('notifications_queue', true);

        // Declare exchanges
        $rabbitConnection->declareExchange('kitchen_exchange', 'direct', true);
        $rabbitConnection->declareExchange('notifications_exchange', 'fanout', true);

        // Bind queues to exchanges
        $rabbitConnection->bindQueue('ingredient_request', 'kitchen_exchange', 'request_ingredient');
        $rabbitConnection->bindQueue('notifications_queue', 'notifications_exchange', '');
    }
}

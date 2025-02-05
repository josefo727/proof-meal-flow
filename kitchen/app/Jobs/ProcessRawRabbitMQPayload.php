<?php

namespace App\Jobs;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Log;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob as BaseJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProcessRawRabbitMQPayload extends BaseJob implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * @return void
     * @throws BindingResolutionException
     * @throws \Exception
     */
    public function fire(): void
    {
        try {
            $payload = json_decode($this->getRawBody(), true);

            $class = $payload['class'] ?? '';
            $data = $payload['data'] ?? [];

            if (!isset($class)) {
                Log::error('The payload does not contain all the necessary fields.');
                $this->delete();
                return;
            }

            if (!class_exists($class)) {
                Log::error("The class [{$class}] does not exist.");
                $this->delete();
                return;
            }

            (new $class())->process($data);

        } catch (\Exception $e) {
            Log::error('ProcessRawRabbitMQPayload: ' . $e->getMessage());
        }

        $this->delete();
    }
}

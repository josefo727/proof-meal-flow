<?php

namespace App\Adapters;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;

class PurchasesAdapter
{
    /**
     * @var string|Repository|Application|mixed|null
     */
    protected null|string $urlApi = null;

    public function __construct()
    {
        $this->urlApi = config('services.purchases.url_api');
    }

    /**
     * @param array $ingredients
     * @return array
     */
    public function purchase(array $ingredients): array
    {
        $response = Http::post($this->urlApi . '/api/purchases', [
            'ingredients' => $ingredients,
        ]);

        sleep(env('PROCESSING_DELAY', 5));

        return $response->json();
    }
}

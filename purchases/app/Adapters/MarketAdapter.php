<?php

namespace App\Adapters;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;

class MarketAdapter
{
    /**
     * @var string|Repository|Application|mixed|null
     */
    protected null|string $apiMarket;

    public function __construct()
    {
        $this->apiMarket = config('market.url');
    }

    /**
     * @param array $ingredients
     * @return array
     */
    public function buyIngredients(array $ingredients): array
    {
        $responses = Http::pool(fn ($pool) => collect($ingredients)
            ->map(fn ($ingredient) => $pool->get($this->apiMarket, [
                'ingredient' => $ingredient,
            ]))
        );

        $results = [];
        foreach ($responses as $index => $response) {
            $ingredient = $ingredients[$index];
            if ($response->successful()) {
                $results[$ingredient] = $response->json('quantitySold', 0);
            } else {
                $results[$ingredient] = 0;
            }
        }

        return $results;
    }
}


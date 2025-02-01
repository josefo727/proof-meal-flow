<?php

namespace App\Services;

use App\Adapters\MarketAdapter;
use App\Models\Purchase;

class PurchaseService
{
    /**
     * @var MarketAdapter
     */
    private MarketAdapter $marketAdapter;

    public function __construct(MarketAdapter $marketAdapter)
    {
        $this->marketAdapter = $marketAdapter;
    }

    /**
     * @param array $ingredients
     * @return array
     */
    public function buyIngredients(array $ingredients): array
    {
        $pendingIngredients = $ingredients;
        $results = [];

        while (!empty($pendingIngredients)) {
            $responses = $this->marketAdapter->buyIngredients($pendingIngredients);

            $pendingIngredients = [];

            foreach ($responses as $ingredient => $quantitySold) {
                if ($quantitySold > 0) {
                    Purchase::query()->create([
                        'ingredient' => $ingredient,
                        'quantity' => $quantitySold,
                        'purchased_at' => now(),
                    ]);

                    $results[$ingredient] = $quantitySold;
                } else {
                    $pendingIngredients[] = $ingredient;
                }
            }
        }

        return $results;
    }
}


<?php

namespace App\Services;

use App\Adapters\PurchasesAdapter;

class IngredientPurchaseService
{
    /**
     * @var PurchasesAdapter|null
     */
    protected null|PurchasesAdapter $purchasesAdapter;

    public function __construct()
    {
        $this->purchasesAdapter = new PurchasesAdapter();
    }

    /**
     * @param array $ingredients
     * @return array
     */
    public function purchase(array $ingredients): array
    {
        return $this->purchasesAdapter->purchase($ingredients);
    }
}

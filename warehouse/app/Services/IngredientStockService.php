<?php

namespace App\Services;

use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IngredientStockService
{
    /**
     * @param array $ingredients
     * @return array
     */
    public function validateAndReserve(array $ingredients): array
    {
        try {
            return DB::transaction(function () use ($ingredients) {
                $missingQuery = Ingredient::query()
                    ->whereIn('name', $ingredients)
                    ->where('stock', '=', 0);

                $missingNames = $missingQuery->pluck('name')->toArray();

                if (!empty($missingNames)) {
                    Ingredient::query()
                        ->whereIn('name', $missingNames)
                        ->increment('reserved');
                }

                Ingredient::query()
                    ->whereIn('name', $ingredients)
                    ->where('stock', '>', 0)
                    ->decrement('stock');

                return $missingNames;
            });
        } catch (\Exception $e) {
            Log::error('IngredientStockService: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * @param array $purchasedIngredients
     * @return void
     */
    public function updateStock(array $purchasedIngredients): void
    {
        foreach ($purchasedIngredients as $ingredient => $quantity) {
            $item = Ingredient::query()->where('name', $ingredient)->first();
            $item->stock += $quantity;
            $item->save();
        }
    }

    /**
     * @param array $missingIngredients
     * @return void
     */
    public function finalizeOrder(array $missingIngredients): void
    {
        Ingredient::query()
            ->whereIn('name', $missingIngredients)
            ->update([
                'reserved' => DB::raw('reserved - 1'),
                'stock' => DB::raw('stock - 1'),
            ]);
    }
}

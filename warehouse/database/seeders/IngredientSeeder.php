<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = config('ingredients.items');

        foreach ($ingredients as $ingredient) {
            Ingredient::query()
                ->updateOrCreate(
                    ['name' => $ingredient],
                    ['stock' => 5, 'reserved' => 0]
                );
        }
    }
}

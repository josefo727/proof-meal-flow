<?php

namespace App\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Recipe;
use Faker\Factory;

class CreateOrderAction
{
    public function execute(): Order
    {
        $recipe = Recipe::query()->inRandomOrder()->first();

        $faker = Factory::create();

        return Order::query()->create([
            'customer_name' => $faker->name,
            'recipe_id' => $recipe->id,
            'status' => OrderStatus::PENDING,
        ]);
    }
}

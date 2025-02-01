<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Mockery;
use App\Services\PurchaseService;
use App\Adapters\MarketAdapter;

class PurchaseServiceTest extends TestCase
{
    public function testBuyIngredientsWhenAllAreSoldImmediately(): void
    {
        $ingredients = ['tomato', 'onion', 'cheese'];

        $marketAdapterMock = Mockery::mock(MarketAdapter::class);
        $marketAdapterMock->shouldReceive('buyIngredients')
            ->once()
            ->with($ingredients)
            ->andReturn([
                'tomato' => 5,
                'onion' => 3,
                'cheese' => 2,
            ]);

        $purchaseService = new PurchaseService($marketAdapterMock);

        $results = $purchaseService->buyIngredients($ingredients);

        $this->assertDatabaseHas('purchases', [
            'ingredient' => 'tomato',
            'quantity' => 5,
        ]);
        $this->assertDatabaseHas('purchases', [
            'ingredient' => 'onion',
            'quantity' => 3,
        ]);
        $this->assertDatabaseHas('purchases', [
            'ingredient' => 'cheese',
            'quantity' => 2,
        ]);

        $this->assertEquals([
            'tomato' => 5,
            'onion' => 3,
            'cheese' => 2,
        ], $results);
    }

    public function testBuyIngredientsWhenSomeArePending(): void
    {
        $ingredients = ['apple', 'banana'];

        $marketAdapterMock = Mockery::mock(MarketAdapter::class);

        $marketAdapterMock->shouldReceive('buyIngredients')
            ->once()
            ->with($ingredients)
            ->andReturn([
                'apple' => 3,
                'banana' => 0, // Queda pendiente
            ]);

        $marketAdapterMock->shouldReceive('buyIngredients')
            ->once()
            ->with(['banana'])
            ->andReturn([
                'banana' => 2,
            ]);

        $purchaseService = new PurchaseService($marketAdapterMock);

        $results = $purchaseService->buyIngredients($ingredients);

        $this->assertDatabaseHas('purchases', [
            'ingredient' => 'apple',
            'quantity' => 3,
        ]);
        $this->assertDatabaseHas('purchases', [
            'ingredient' => 'banana',
            'quantity' => 2,
        ]);

        $this->assertEquals([
            'apple' => 3,
            'banana' => 2,
        ], $results);

    }
}

<?php

namespace Tests\Feature\Controllers\Api;

use App\Services\PurchaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testPurchaseControllerReturnsIngredientsWithPositiveQuantities(): void
    {
        $ingredients = ['tomato', 'onion', 'cheese'];

        $mockedResult = [
            'tomato' => 5,
            'onion' => 3,
            'cheese' => 2,
        ];

        $purchaseServiceMock = Mockery::mock(PurchaseService::class);
        $purchaseServiceMock->shouldReceive('buyIngredients')
            ->once()
            ->with($ingredients)
            ->andReturn($mockedResult);

        $this->app->instance(PurchaseService::class, $purchaseServiceMock);

        $response = $this->postJson('/api/purchases', [
            'ingredients' => $ingredients,
        ]);

        $response->assertStatus(200);

        $response->assertJson($mockedResult);

        foreach ($mockedResult as $quantity) {
            $this->assertGreaterThan(0, $quantity, 'Las cantidades deben ser mayores a cero.');
        }
    }
}

<?php

namespace Tests\Unit\Adapters;

use Tests\TestCase;
use App\Adapters\MarketAdapter;
use Illuminate\Support\Facades\Http;

class MarketAdapterTest extends TestCase
{
    public function testBuyIngredientsSuccessfulResponses(): void
    {
        $ingredients = ['tomato', 'onion', 'cheese'];

        Http::fake(function ($request) {
            return Http::response(['quantitySold' => 5], 200);
        });

        $adapter = new MarketAdapter();

        $results = $adapter->buyIngredients($ingredients);

        $this->assertIsArray($results);
        $this->assertEquals([
            'tomato' => 5,
            'onion' => 5,
            'cheese' => 5,
        ], $results);
    }

    public function testBuyIngredientsHandlesFailedResponses(): void
    {
        $ingredients = ['tomato', 'onion', 'cheese'];

        Http::fake(function () {
            return Http::response(null, 500);
        });

        $adapter = new MarketAdapter();

        $results = $adapter->buyIngredients($ingredients);

        $this->assertIsArray($results);
        $this->assertEquals([
            'tomato' => 0,
            'onion' => 0,
            'cheese' => 0,
        ], $results);
    }

    public function testBuyIngredientsReturnsZeroWhenEmptyResponse(): void
    {
        $ingredients = ['tomato'];

        Http::fake(function ($request) {
            return Http::response([], 200);
        });

        $adapter = new MarketAdapter();

        $results = $adapter->buyIngredients($ingredients);

        $this->assertIsArray($results);
        $this->assertEquals([
            'tomato' => 0,
        ], $results);
    }
}

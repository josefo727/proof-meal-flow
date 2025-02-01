<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredientRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testValidIngredientsPassValidation(): void
    {
        $response = $this->postJson('/api/purchases', [
            'ingredients' => ['tomato', 'onion', 'cheese'],
        ]);

        $response->assertStatus(200);
    }

    public function testInvalidIngredientsFailValidation(): void
    {
        $response = $this->postJson('/api/purchases', [
            'ingredients' => ['invalid_ingredient', 'another_invalid'],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ingredients.0', 'ingredients.1']);
    }

    public function testEmptyIngredientsFailValidation(): void
    {
        $response = $this->postJson('/api/purchases', [
            'ingredients' => [],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ingredients']);
    }

    public function testMissingIngredientsKeyFailsValidation(): void
    {
        $response = $this->postJson('/api/purchases', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ingredients']);
    }

    public function testIngredientsWithMinItemsValidation(): void
    {
        $response = $this->postJson('/api/purchases', [
            'ingredients' => ['onion'],
        ]);

        $response->assertStatus(200);
    }
}

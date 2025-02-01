<?php

namespace Tests\Unit\Rules;

use App\Rules\ValidIngredient;
use Tests\TestCase;

class ValidIngredientTest extends TestCase
{
    public function testValidIngredientPasses()
    {
        $rule = new ValidIngredient();

        $failCalled = false;
        $fail = function () use (&$failCalled) {
            $failCalled = true;
        };

        $rule->validate('ingredient', 'tomato', $fail);

        $this->assertFalse($failCalled, 'La validación falló para un ingrediente válido.');
    }

    public function testInvalidIngredientFails()
    {
        $rule = new ValidIngredient();

        $failCalled = false;
        $fail = function () use (&$failCalled) {
            $failCalled = true;
        };

        $rule->validate('ingredient', 'invalid_ingredient', $fail);

        $this->assertTrue($failCalled, 'La validación pasó para un ingrediente no válido.');
    }

    public function testValidIngredientWithDifferentCaseFails()
    {
        $rule = new ValidIngredient();

        $failMessage = null;
        $fail = function ($message) use (&$failMessage) {
            $failMessage = $message;
        };

        $rule->validate('ingredient', 'Tomato', $fail);

        $this->assertEquals('El ingrediente Tomato no es válido.', $failMessage);
    }

    public function testEmptyIngredientFails()
    {
        $rule = new ValidIngredient();

        $failMessage = null;
        $fail = function ($message) use (&$failMessage) {
            $failMessage = $message;
        };

        $rule->validate('ingredient', '', $fail);

        $this->assertEquals('El ingrediente  no es válido.', $failMessage);
    }
}

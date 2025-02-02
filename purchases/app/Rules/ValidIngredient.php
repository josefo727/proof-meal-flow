<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIngredient implements ValidationRule
{
    /**
     * @var array|string[]
     */
    private array $validIngredients = [];

    public function __construct()
    {
        $this->validIngredients = config('ingredients.items');
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, $this->validIngredients)) {
            $fail("El ingrediente {$value} no es válido.");
        }
    }
}

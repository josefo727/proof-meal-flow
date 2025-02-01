<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidIngredient;

class IngredientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => ['required', 'string', new ValidIngredient],
        ];
    }
}

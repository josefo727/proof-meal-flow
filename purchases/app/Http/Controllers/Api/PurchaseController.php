<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IngredientRequest;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;

class PurchaseController
{
    /**
     * @var PurchaseService
     */
    protected PurchaseService $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    /**
     * @param IngredientRequest $request
     * @return JsonResponse
     */
    public function __invoke(IngredientRequest $request): JsonResponse
    {
        $ingredients = $request->input('ingredients');

        $result = $this->purchaseService->buyIngredients($ingredients);

        return response()->json($result, 200);
    }
}

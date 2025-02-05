<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrderProcessorService
{
    /**
     * @var IngredientStockService|null
     */
    protected null|IngredientStockService $ingredientStockService;

    /**
     * @var IngredientPurchaseService|null
     */
    protected null|IngredientPurchaseService $ingredientPurchaseService;

    /**
     * @var DeliveryService|null
     */
    protected null|DeliveryService $deliveryService;

    /**
     * @var UpdateStatusService|null
     */
    protected null|UpdateStatusService $updateStatusService;

    public function __construct() {
        $this->ingredientStockService = new IngredientStockService();
        $this->ingredientPurchaseService = new IngredientPurchaseService();
        $this->deliveryService = new DeliveryService();
        $this->updateStatusService = new UpdateStatusService();
    }

    /**
     * @param array $data
     * @return void
     */
    public function process(array $data): void
    {
        $ingredients = $data['ingredients'];
        $orderId = $data['order_id'];

        $missingIngredients = $this->ingredientStockService->validateAndReserve($ingredients);

        if (!empty($missingIngredients)) {
            DB::table('orders')->where('id', $orderId)->update(['status' => 'awaiting']);
            $this->updateStatusService->sendToNotifications($orderId, 'awaiting');
            $purchasedIngredients = $this->ingredientPurchaseService->purchase($missingIngredients);
            $this->ingredientStockService->updateStock($purchasedIngredients);
            $this->ingredientStockService->finalizeOrder($missingIngredients);
        }

        $this->deliveryService->sendToKitchen($orderId, $ingredients);
        $this->updateStatusService->sendToNotifications($orderId, 'processing');
    }
}

<?php

namespace App\Actions;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StartNewSessionAction
{
    /**
     * @return void
     */
    public function execute(): void
    {
        try {
            DB::beginTransaction();
            Order::query()->truncate();

            DB::table('ingredients')
                ->update([
                    'stock' => 5,
                    'reserved' => 0
                ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }
}

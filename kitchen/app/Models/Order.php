<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return class-string[]
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    /**
     * @return BelongsTo
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Scope a query to filter results by a given status.
     *
     * @param Builder $query The query builder instance.
     * @param string $status The status to filter by.
     * @return Builder The modified query builder instance.
     */
    public static function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}

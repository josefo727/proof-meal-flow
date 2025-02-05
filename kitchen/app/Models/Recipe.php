<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Recipe extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
        ];
    }

    /**
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn () => '/images/' . str_pad($this->id, 2, '0', STR_PAD_LEFT) . '.jpg'
        );
    }
}

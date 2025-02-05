<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name', 'stock', 'reserved'];
}

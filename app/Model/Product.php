<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 */
class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['name', 'price'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];
}

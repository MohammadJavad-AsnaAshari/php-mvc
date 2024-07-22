<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class Category extends Model
{
    protected string $table = 'categories';

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'category_product',
            'category_id',
            'product_id'
        );
    }
}
<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;
use Mj\PocketCore\Exceptions\ServerException;

class Order extends Model
{
    protected string $table = 'orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
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

    public function attachProduct(int $productId, int $quantity)
    {
        $sql = "INSERT INTO order_product (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'order_id' => $this->id,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }
}
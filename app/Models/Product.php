<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;
use Mj\PocketCore\Exceptions\ServerException;

class Product extends Model
{
    protected string $table = 'products';

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'product_like', 'product_id', 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class, 'category_product', 'product_id', 'category_id'
        );
    }

    public function getImageURL()
    {
        if ($this->image) {
            return "/storage/app/product/$this->image";
        }

        return APP_PATH . 'public/images/p8.png';
    }

    public function attachCategories(int $category)
    {
        try {
            $this->query(
                "INSERT INTO category_product (category_id, product_id) VALUES (:category_id, :product_id)",
                [
                    'category_id' => $category,
                    'product_id' => $this->id
                ]
            );
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());

            // Throw an exception to propagate the error
            throw new ServerException($e);
        }
    }

    public function detachAllCategories()
    {
        $categoryIds = $this->getCategoryIds();

        if (empty($categoryIds)) {
            dd('here');
            return;
        }

        $query = "DELETE FROM category_product WHERE product_id = ? AND category_id IN (" . implode(',', array_fill(0, count($categoryIds), '?')) . ")";
        $statement = $this->pdo->prepare($query);
        $statement->execute(array_merge([$this->id], $categoryIds));
    }

    public function getCategoryIds()
    {
        $categoryIds = [];
        $categories = $this->categories();

        foreach ($categories as $category) {
            $categoryIds[] = $category->id;
        }

        return $categoryIds;
    }
}
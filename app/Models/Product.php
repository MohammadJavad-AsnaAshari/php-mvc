<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class Product extends Model
{
    protected string $table = 'products';

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getImageURL()
    {
        if ($this->image) {
            return "/storage/app/product/$this->image";
        }

        return APP_PATH . 'public/images/p8.png';
    }
}
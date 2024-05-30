<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class Comment extends Model
{
    protected string $table = 'comments';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
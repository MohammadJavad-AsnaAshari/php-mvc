<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class User extends Model
{
    protected string $table = 'users';

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }
}
<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class User extends Model
{
    protected string $table = 'users';

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
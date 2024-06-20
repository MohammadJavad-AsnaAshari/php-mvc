<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class Permission extends Model
{
    protected string $table = 'permissions';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class Role extends Model
{
    protected string $table = 'roles';

    public function users()
    {
    return $this->belongsToMany(User::class);
    }
}
<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;
use Mj\PocketCore\Exceptions\ServerException;

class Payment extends Model
{
    protected string $table = 'payments';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
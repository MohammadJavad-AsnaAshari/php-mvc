<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class ContactUs extends Model
{
    protected string $table = 'contact_us';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
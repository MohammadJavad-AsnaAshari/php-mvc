<?php

namespace App\Http\Controllers;

use App\Models\User;
use Mj\PocketCore\Controller;

class UserController extends Controller
{
    public function create(): string
    {
        $data = [
            'name' => 'name 1',
            'email' => 'example1@gmail.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ];

        $user = new User();
        $user->create($data);

        return 'user created!';
    }
}
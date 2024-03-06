<?php

namespace App\Http\Controllers;

use App\Models\User;
use Mj\PocketCore\Controller;

class UserController extends Controller
{
    private User $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function create(): string
    {
        $data = [
            'name' => 'name 1',
            'email' => 'example1@gmail.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ];
        $this->user->create($data);

        return 'user created!';
    }
}
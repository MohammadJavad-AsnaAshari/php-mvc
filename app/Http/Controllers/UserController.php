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

    public function update(int $id): string
    {
        $data = [
            'name' => 'name update 1',
            'email' => 'example.update1@gmail.com',
            'password' => password_hash('password-update', PASSWORD_DEFAULT),
        ];
        $this->user->update($id, $data);

        return "user {$id} updated!";
    }
}
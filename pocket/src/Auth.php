<?php

namespace Mj\PocketCore;

use App\Models\User;

class Auth
{
    public function check(): bool|null
    {
        return session()->get('auth_user');
    }

    public function login($user): void
    {
        session()->set('auth_user', $user->id);
    }

    public function logout(): void
    {
        session()->remove('auth_user');
    }

    public function user()
    {
        $userId = session()->get('auth_user');
        if ($userId) {
            return (new User())->find($userId);
        }

        return null;
    }
}
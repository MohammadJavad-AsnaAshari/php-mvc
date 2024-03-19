<?php

namespace App\Http\Controllers\Auth;

use Mj\PocketCore\Controller;

class LoginController extends Controller
{
    public function loginView()
    {
        return $this->render('auth.login');
    }

    public function login()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'email' => 'required|email||max:255|exists:users,email',
                'password' => 'required|min:6||max:255',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/auth/login');
        }
    }
}
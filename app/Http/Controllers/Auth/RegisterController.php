<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Mj\PocketCore\Controller;

class RegisterController extends Controller
{
    public function signUpView()
    {
        return $this->render('auth.signUp');
    }

    public function loginView()
    {
        return $this->render('auth.login');
    }

    public function signUp()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'email' => 'required|email||max:255|unique:users,email',
                'password' => 'required|min:6||max:255',
                'confirm_password' => 'required|same:password',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/auth/sign-up');
        }

        $validatedData = $validation->getValidatedData();
        unset($validatedData['confirm_password']);

        $user = new User();
        $user->create([
            ...$validatedData,
            'password' => password_hash($validatedData['password'], PASSWORD_DEFAULT)
        ]);

        return redirect('/auth/login');
    }
}
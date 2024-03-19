<?php

namespace App\Http\Controllers\Auth;

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
                'email' => 'required|email||max:255',
                'password' => 'required|min:6||max:255',
                'confirm_password' => 'required|same:password',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/auth/sign-up');
        } else {
            // validation passes
            echo "Success!";
        }
    }
}
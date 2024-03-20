<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Mj\PocketCore\Controller;

class RegisterController extends Controller
{
    public function registerView()
    {
        return $this->render('auth.register');
    }

    public function register()
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
            return redirect('/auth/register');
        }

        $validatedData = $validation->getValidatedData();
        unset($validatedData['confirm_password']);

        (new User())->create([
            ...$validatedData,
            'password' => password_hash($validatedData['password'], PASSWORD_DEFAULT)
        ]);

        return redirect('/auth/login');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Mj\PocketCore\Controller;
use Rakit\Validation\ErrorBag;

class LoginController extends Controller
{
    public function loginView()
    {
        if (!auth()->check()) {
            // Check if the user was redirected to the login page from a previous page
            $previousUrl = $_SERVER['HTTP_REFERER'];

            // Store the previous URL in the session
            session()->set('url.previous', $previousUrl);

            return $this->render('auth.login');
        }

        return redirect('/');
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

        $validatedData = $validation->getValidatedData();

        $user = (new User())->find($validatedData['email'], 'email');

        if (!password_verify($validatedData['password'], $user->password)) {
            $errors = new ErrorBag();
            $errors->add('password', 'check-password', "your password is not correct!");

            return redirect('/auth/login')->withErrors($errors);
        }

        auth()->login($user);

        // Retrieve the previous URL from the session and redirect the user to that URL
        $previousUrl = session()->get('url.previous');

        return redirect($previousUrl ?? '/');
    }
}
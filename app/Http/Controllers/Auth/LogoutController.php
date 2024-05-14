<?php

namespace App\Http\Controllers\Auth;

use Mj\PocketCore\Controller;

class LogoutController extends Controller
{
    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }
}
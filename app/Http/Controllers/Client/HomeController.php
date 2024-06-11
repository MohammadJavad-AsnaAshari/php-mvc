<?php

namespace App\Http\Controllers\Client;

use Mj\PocketCore\Controller;

class HomeController extends Controller
{
    public function index(): string
    {
        return $this->render('client.home');
    }

    public function aboutUs()
    {
        return view('client.about-us');
    }
}
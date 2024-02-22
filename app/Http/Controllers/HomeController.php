<?php

namespace App\Http\Controllers;

use Mj\PocketCore\Controller;

class HomeController extends Controller
{
    public function index(): string
    {
        return $this->render('home');
    }
}
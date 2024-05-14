<?php

namespace App\Http\Controllers;

use Mj\PocketCore\Controller;

class HomeController extends Controller
{
    public function indexHome(): string
    {
        return $this->render('client.home');
    }

    public function indexShop(): string
    {
        return $this->render('client.shop');
    }
}
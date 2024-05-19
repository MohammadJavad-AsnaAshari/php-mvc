<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Mj\PocketCore\Controller;

class HomeController extends Controller
{
    public function indexHome(): string
    {
        return $this->render('client.home');
    }

    public function indexShop(): string
    {
        $products = (new Product());

        if (request()->has('search')) {
            $search = request('search');
            $products = $products->where('name', $search, 'LIKE');
        }

        $products = $products->get();

        return $this->render('client.shop', compact('products'));
    }
}
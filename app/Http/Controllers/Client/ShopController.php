<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Dotenv\Validator;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Request;
use Rakit\Validation\Validation;

class ShopController extends Controller
{
    public function index(): string
    {
        $products = new Product();

        if (request()->has('search')) {
            $search = request('search');
            $products = $products->where('name', $search, 'LIKE');
        }

        $products = $products->get();

        return $this->render('client.shop', compact('products'));
    }

    public function show(int $product)
    {
        $product = (new Product())->where('id', $product)->first();

        return view('client.single-shop', compact('product'));
    }

    public function popular()
    {
        return view('client.popular');
    }
}
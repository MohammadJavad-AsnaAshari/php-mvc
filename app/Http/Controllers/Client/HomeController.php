<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Mj\PocketCore\Controller;

class HomeController extends Controller
{
    public function index(): string
    {
        $sql = "SELECT products.*, COUNT(DISTINCT CONCAT(product_like.product_id, product_like.user_id)) as likes
            FROM products
            LEFT JOIN product_like ON products.id = product_like.product_id
            GROUP BY products.id
            ORDER BY likes DESC
            LIMIT 4";
        $products = (new Product())->query($sql);

        return $this->render('client.home', compact('products'));
    }

    public function aboutUs()
    {
        return view('client.about-us');
    }

    public function contactUs()
    {
        return view('client.contact');
    }
}
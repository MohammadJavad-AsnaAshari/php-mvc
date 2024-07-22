<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Mj\PocketCore\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = (new Category())->get();

        return view('client.categories.index', compact('categories'));
    }

    public function show(string $category)
    {
        $category = (new Category())->where('name', $category)->first();
        $products = $category->products();

        return view('client.categories.show', compact('category', 'products'));
    }
}
<?php

namespace App\Http\Controllers;

use Mj\PocketCore\Request;

class ArticleController
{
    public function dynamic(Request $request, string $id)
    {
        var_dump($request);
        return "article dynamic page. id: $id";
    }

    public function index(Request $request)
    {
        var_dump($request);
        return 'article page';
    }

    public function create()
    {
        $root = '../public/article.html';
        include_once $root;
    }

    public function store(Request $request)
    {
        return 'hello world! this is post method!';
    }
}
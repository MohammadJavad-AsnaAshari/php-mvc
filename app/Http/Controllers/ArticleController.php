<?php

namespace App\Http\Controllers;

class ArticleController
{
    public function dynamic($id)
    {
        return "article dynamic page. id: $id";
    }

    public function index()
    {
        return 'article page';
    }

    public function create()
    {
        $root = '../public/article.html';
        include_once $root;
    }

    public function store()
    {
        return 'hello world! this is post method!';
    }
}
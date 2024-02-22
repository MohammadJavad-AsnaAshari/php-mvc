<?php

namespace App\Http\Controllers;

use Mj\PocketCore\Request;
use Rakit\Validation\Validator;

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

    public function store(Request $request, Validator $validator)
    {
        // make it
        $validation = $validator->make($request->all(), [
            'title' => 'required|min:5'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            echo "<pre>";
            print_r($errors->firstOfAll());
            echo "</pre>";
            exit;
        } else {
            // validation passes
            echo "Success!";
        }

        return $request->query('id');
    }
}
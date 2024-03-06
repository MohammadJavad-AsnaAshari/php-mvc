<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Request;

class ArticleController extends Controller
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

    public function create(): string
    {
        $data = [
            'title' => 'This is article 1',
            'body' => 'This is article body 1',
        ];

        $article = (new Article());
        $article->create($data);

        return 'article created!';
    }

    public function store(Request $request)
    {
        $validation = $this->validate($request->all(),[
           'title' => 'required|min:5'
        ]);

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
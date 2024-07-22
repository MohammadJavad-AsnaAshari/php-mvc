<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\Client\Dashboard\UserPanelController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ShopController;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Mj\PocketCore\Router;

Router::get('/', [HomeController::class, 'index']);
Router::get('/about-us', [HomeController::class, 'aboutUs']);
Router::get('/contact-us', [HomeController::class, 'contactUs']);

Router::get('/shop', [ShopController::class, 'index']);
Router::get('/shop/{product}', [ShopController::class, 'show']);
Router::post('/shop/{product}/like', [ShopController::class, 'like']);
Router::post('/shop/{product}/unlike', [ShopController::class, 'unlike']);
Router::get('/popular', [ShopController::class, 'popular']);

Router::get('/categories', [CategoryController::class, 'index']);
Router::get('/categories/{category}', [CategoryController::class, 'show']);

Router::post('/shop/{productId}/comments', [CommentController::class, 'store'], ['auth']);

Router::get('/auth/register', [RegisterController::class, 'registerView'], ['guest']);
Router::post('/auth/register', [RegisterController::class, 'register'], ['guest']);
Router::get('/auth/login', [LoginController::class, 'loginView'], ['guest']);
Router::post('/auth/login', [LoginController::class, 'login'], ['guest']);
Router::get('/auth/logout', [LogoutController::class, 'logout']);

Router::get('/user-panel/{userId}', [UserPanelController::class, 'show'], ['auth']);
Router::get('/user-panel/edit/{userId}', [UserPanelController::class, 'edit'], ['auth']);
Router::post('/user-panel/update', [UserPanelController::class, 'update'], ['auth']);
Router::post('/user-panel/delete', [UserPanelController::class, 'delete'], ['auth']);



// -------------------------------------------------- test --------------------------------------------------
Router::get('/test/user/articles', function () {
    $user = auth()->user();
    $articles = $user->articles()->get();

    foreach($articles as $article){
        echo $article->title . "<br>";
    }
});

Router::get('/test/product/comments/{product}', function ($product) {
    $product = (new Product())->find($product);
    $comments = $product->comments()->get();

    foreach ($comments as $comment) {
        echo $comment->comment . "<br>";
    }
});

Router::get('/test/comment/user/{comment}', function ($comment) {
    $comment = (new Comment())->find($comment);

    dd($comment->user()->first());
});

Router::get('/test/comment/product/{comment}', function ($comment) {
    $comment = (new Comment())->find($comment);

    dd($comment->product()->first());
});

Router::get('/test/role/admin' , function() {
    try {
        $user = (new User())->find(1);
        $roles = $user->roles();
        foreach ($roles as $role) {
            echo $role->name . "<br>";
        }
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
});

Router::get('/test/user/admin', function () {
    try {
        $role = (new Role())->find(1);
        $users = $role->users();
        foreach ($users as $user) {
            echo $user->name . "<br>";
        }
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
});

Router::get('/test/where_in', function() {
    $users = (new User())->whereIn('id', [2, 1])->get();

    foreach ($users as $user) {
        echo $user->name . "<br>";
    }
});
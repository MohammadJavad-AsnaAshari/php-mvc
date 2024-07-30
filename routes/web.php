<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\Client\Dashboard\UserPanelController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ShopController;
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

Router::get('/cart', [CartController::class, 'index'], ['auth']);
Router::post('/cart/store', [CartController::class, 'storeProduct'], ['auth']);
Router::post('/cart/quantity/update', [CartController::class, 'updateQuantity'], ['auth']);
Router::post('/cart/delete', [CartController::class, 'delete'], ['auth']);

Router::get('/user-panel/orders', [OrderController::class, 'index'], ['auth']);
Router::get('/user-panel/orders/{orderId}', [OrderController::class, 'show'], ['auth']);
Router::post('/cart/orders', [OrderController::class, 'store'], ['auth']);
Router::post('/payment', [OrderController::class, 'payment'], ['auth']);
<?php

use App\Http\Controllers\Admin\Dashboard\AdminPanelController;
use App\Http\Controllers\Admin\Users\UserController;
use Mj\PocketCore\Router;

Router::get('/admin-panel', [AdminPanelController::class, 'index'], ['auth']);

Router::get('/admin-panel/users', [UserController::class, 'index'], ['auth']);
Router::get('/admin-panel/users/{userId}', [UserController::class, 'show'], ['auth']);
Router::get('/admin-panel/users/create', [UserController::class, 'create'], ['auth']);
Router::post('/admin-panel/users/store', [UserController::class, 'store'], ['auth']);
Router::get('/admin-panel/users/edit/{userId}', [UserController::class, 'edit'], ['auth']);
Router::post('/admin-panel/users/update', [UserController::class, 'update'], ['auth']);
Router::post('/admin-panel/users/delete', [UserController::class, 'delete'], ['auth']);
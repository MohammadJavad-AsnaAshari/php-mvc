<?php

use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Comments\CommentController;
use App\Http\Controllers\Admin\Dashboard\AdminPanelController;
use App\Http\Controllers\Admin\Permissions\PermissionController;
use App\Http\Controllers\Admin\Products\ProductController;
use App\Http\Controllers\Admin\Roles\RoleController;
use App\Http\Controllers\Admin\Users\UserController;
use Mj\PocketCore\Router;

Router::get('/admin-panel', [AdminPanelController::class, 'index'], ['auth', 'admin']);

Router::get('/admin-panel/users', [UserController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/users/admin', [UserController::class, 'admin'], ['auth', 'admin']);
Router::get('/admin-panel/users/{userId}', [UserController::class, 'show'], ['auth', 'admin']);
Router::get('/admin-panel/users/create', [UserController::class, 'create'], ['auth', 'admin']);
Router::get('/admin-panel/users/edit/{userId}', [UserController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/users/store', [UserController::class, 'store'], ['auth', 'admin']);
Router::post('/admin-panel/users/update', [UserController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/users/delete', [UserController::class, 'delete'], ['auth', 'admin']);

Router::get('/admin-panel/permissions', [PermissionController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/permissions/{permissionId}', [PermissionController::class, 'show'], ['auth', 'admin']);
Router::get('/admin-panel/permissions/create', [PermissionController::class, 'create'], ['auth', 'admin']);
Router::get('/admin-panel/permissions/edit/{permissionId}', [PermissionController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/permissions/store', [PermissionController::class, 'store'], ['auth', 'admin']);
Router::post('/admin-panel/permissions/update', [PermissionController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/permissions/delete', [PermissionController::class, 'delete'], ['auth', 'admin']);

Router::get('/admin-panel/products', [ProductController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/products/create', [ProductController::class, 'create'], ['auth', 'admin']);
Router::post('/admin-panel/products/store', [ProductController::class, 'store'], ['auth', 'admin']);
Router::get('/admin-panel/products/edit/{productId}', [ProductController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/products/update', [ProductController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/products/delete', [ProductController::class, 'delete'], ['auth', 'admin']);

Router::get('/admin-panel/comments', [CommentController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/comments/edit/{commentId}', [CommentController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/comments/update', [CommentController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/comments/delete', [CommentController::class, 'delete'], ['auth', 'admin']);

Router::get('/admin-panel/categories', [CategoryController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/categories/create', [CategoryController::class, 'create'], ['auth', 'admin']);
Router::post('/admin-panel/categories/store', [CategoryController::class, 'store'], ['auth', 'admin']);
Router::get('/admin-panel/categories/edit/{categoryId}', [CategoryController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/categories/update', [CategoryController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/categories/delete', [CategoryController::class, 'delete'], ['auth', 'admin']);
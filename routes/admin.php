<?php

use App\Http\Controllers\Admin\Dashboard\AdminPanelController;
use App\Http\Controllers\Admin\Permissions\PermissionController;
use App\Http\Controllers\Admin\Products\ProductController;
use App\Http\Controllers\Admin\Rules\RuleController;
use App\Http\Controllers\Admin\Users\UserController;
use Mj\PocketCore\Router;

Router::get('/admin-panel', [AdminPanelController::class, 'index'], ['auth', 'admin']);

Router::get('/admin-panel/users', [UserController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/users/{userId}', [UserController::class, 'show'], ['auth', 'admin']);
Router::get('/admin-panel/users/create', [UserController::class, 'create'], ['auth', 'admin']);
Router::get('/admin-panel/users/edit/{userId}', [UserController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/users/store', [UserController::class, 'store'], ['auth', 'admin']);
Router::post('/admin-panel/users/update', [UserController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/users/delete', [UserController::class, 'delete'], ['auth', 'admin']);

Router::get('/admin-panel/roles', [RuleController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/roles/{roleId}', [RuleController::class, 'show'], ['auth', 'admin']);
Router::get('/admin-panel/roles/create', [RuleController::class, 'create'], ['auth', 'admin']);
Router::get('/admin-panel/roles/edit/{roleId}', [RuleController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/roles/store', [RuleController::class, 'store'], ['auth', 'admin']);
Router::post('/admin-panel/roles/update', [RuleController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/roles/delete', [RuleController::class, 'delete'], ['auth', 'admin']);

Router::get('/admin-panel/permissions', [PermissionController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/permissions/{roleId}', [PermissionController::class, 'show'], ['auth', 'admin']);
Router::get('/admin-panel/permissions/create', [PermissionController::class, 'create'], ['auth', 'admin']);
Router::get('/admin-panel/permissions/edit/{roleId}', [PermissionController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/permissions/store', [PermissionController::class, 'store'], ['auth', 'admin']);
Router::post('/admin-panel/permissions/update', [PermissionController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/permissions/delete', [PermissionController::class, 'delete'], ['auth', 'admin']);

Router::get('/admin-panel/products', [ProductController::class, 'index'], ['auth', 'admin']);
Router::get('/admin-panel/products/create', [ProductController::class, 'create'], ['auth', 'admin']);
Router::post('/admin-panel/products/store', [ProductController::class, 'store'], ['auth', 'admin']);
Router::get('/admin-panel/products/edit/{productId}', [ProductController::class, 'edit'], ['auth', 'admin']);
Router::post('/admin-panel/products/update', [ProductController::class, 'update'], ['auth', 'admin']);
Router::post('/admin-panel/products/delete', [ProductController::class, 'delete'], ['auth', 'admin']);
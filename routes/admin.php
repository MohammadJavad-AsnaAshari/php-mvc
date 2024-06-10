<?php

use App\Http\Controllers\Admin\Dashboard\AdminPanelController;
use App\Http\Controllers\Admin\Rules\RuleController;
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

Router::get('/admin-panel/roles', [RuleController::class, 'index'], ['auth']);
Router::get('/admin-panel/roles/{roleId}', [RuleController::class, 'show'], ['auth']);
Router::get('/admin-panel/roles/create', [RuleController::class, 'create'], ['auth']);
Router::get('/admin-panel/roles/edit/{roleId}', [RuleController::class, 'edit'], ['auth']);
Router::post('/admin-panel/roles/store', [RuleController::class, 'store'], ['auth']);
Router::post('/admin-panel/roles/update', [RuleController::class, 'update'], ['auth']);
Router::post('/admin-panel/roles/delete', [RuleController::class, 'delete'], ['auth']);
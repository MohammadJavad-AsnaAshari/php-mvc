<?php

use App\Http\Controllers\Admin\AdminController;
use Mj\PocketCore\Router;

Router::get('/admin', [AdminController::class, 'index'], ['auth']);
Router::get('/admin/users', 'admin.users.all');
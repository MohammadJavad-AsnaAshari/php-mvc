<?php

use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Comments\CommentController;
use App\Http\Controllers\Admin\Dashboard\AdminPanelController;
use App\Http\Controllers\Admin\Database\DatabaseController;
use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Permissions\PermissionController;
use App\Http\Controllers\Admin\Products\ProductController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\ContactUs\ContactUsController;
use Mj\PocketCore\Router;

Router::get('/admin-panel', [AdminPanelController::class, 'index'], ['auth', 'admin']);

Router::get('/admin-panel/users', [UserController::class, 'index'], ['auth', 'user-index']);
Router::get('/admin-panel/users/admin', [UserController::class, 'admin'], ['auth', 'admin']);
Router::get('/admin-panel/users/{userId}', [UserController::class, 'show'], ['auth', 'user-read']);
Router::get('/admin-panel/users/create', [UserController::class, 'create'], ['auth', 'user-create']);
Router::get('/admin-panel/users/edit/{userId}', [UserController::class, 'edit'], ['auth', 'user-edit']);
Router::post('/admin-panel/users/store', [UserController::class, 'store'], ['auth', 'user-create']);
Router::post('/admin-panel/users/update', [UserController::class, 'update'], ['auth', 'user-edit']);
Router::post('/admin-panel/users/delete', [UserController::class, 'delete'], ['auth', 'user-delete']);
Router::get('/admin-panel/users/export/{as}', [UserController::class, 'export'], ['auth', 'user-export']);

Router::get('/admin-panel/permissions', [PermissionController::class, 'index'], ['auth', 'permission-index']);
Router::get('/admin-panel/permissions/create', [PermissionController::class, 'create'], ['auth', 'permission-create']);
Router::get('/admin-panel/permissions/edit/{permissionId}', [PermissionController::class, 'edit'], ['auth', 'permission-edit']);
Router::post('/admin-panel/permissions/store', [PermissionController::class, 'store'], ['auth', 'permission-create']);
Router::post('/admin-panel/permissions/update', [PermissionController::class, 'update'], ['auth', 'permission-edit']);
Router::post('/admin-panel/permissions/delete', [PermissionController::class, 'delete'], ['auth', 'permission-delete']);
Router::get('/admin-panel/permissions/export/{as}', [PermissionController::class, 'export'], ['auth', 'permission-export']);

Router::get('/admin-panel/products', [ProductController::class, 'index'], ['auth', 'product-index']);
Router::get('/admin-panel/products/create', [ProductController::class, 'create'], ['auth', 'product-create']);
Router::post('/admin-panel/products/store', [ProductController::class, 'store'], ['auth', 'product-create']);
Router::get('/admin-panel/products/edit/{productId}', [ProductController::class, 'edit'], ['auth', 'product-edit']);
Router::post('/admin-panel/products/update', [ProductController::class, 'update'], ['auth', 'product-edit']);
Router::post('/admin-panel/products/delete', [ProductController::class, 'delete'], ['auth', 'product-delete']);
Router::get('/admin-panel/products/export/{as}', [ProductController::class, 'export'], ['auth', 'product-export']);

Router::get('/admin-panel/comments', [CommentController::class, 'index'], ['auth', 'comment-index']);
Router::get('/admin-panel/comments/edit/{commentId}', [CommentController::class, 'edit'], ['auth', 'comment-edit']);
Router::post('/admin-panel/comments/update', [CommentController::class, 'update'], ['auth', 'comment-edit']);
Router::post('/admin-panel/comments/delete', [CommentController::class, 'delete'], ['auth', 'comment-delete']);
Router::get('/admin-panel/comments/export/{as}', [CommentController::class, 'export'], ['auth', 'comment-export']);

Router::get('/admin-panel/contact-us', [ContactUsController::class, 'index']);

Router::get('/admin-panel/categories', [CategoryController::class, 'index'], ['auth', 'category-index']);
Router::get('/admin-panel/categories/create', [CategoryController::class, 'create'], ['auth', 'category-create']);
Router::post('/admin-panel/categories/store', [CategoryController::class, 'store'], ['auth', 'category-create']);
Router::get('/admin-panel/categories/edit/{categoryId}', [CategoryController::class, 'edit'], ['auth', 'category-edit']);
Router::post('/admin-panel/categories/update', [CategoryController::class, 'update'], ['auth', 'category-edit']);
Router::post('/admin-panel/categories/delete', [CategoryController::class, 'delete'], ['auth', 'category-delete']);
Router::get('/admin-panel/categories/export/{as}', [CategoryController::class, 'export'], ['auth', 'category-export']);

Router::get('/admin-panel/orders', [OrderController::class, 'index'], ['auth', 'order-index']);
Router::get('/admin-panel/orders/{orderId}', [OrderController::class, 'show'], ['auth', 'order-index']);
Router::get('/admin-panel/orders/export/{as}', [OrderController::class, 'exportAll'], ['auth', 'order-export']);
Router::get('/admin-panel/orders/export/{orderId}/{as}', [OrderController::class, 'exportShow'], ['auth', 'order-export']);

Router::get('/admin-panel/database/backup', [DatabaseController::class, 'backupIndex'], ['auth', 'database-backup']);
Router::post('/admin-panel/database/backup', [DatabaseController::class, 'backupDownload'], ['auth', 'database-backup']);
Router::get('/admin-panel/database/recovery', [DatabaseController::class, 'recoveryIndex'], ['auth', 'database-recovery']);
Router::post('/admin-panel/database/recovery', [DatabaseController::class, 'recoveryUpload'], ['auth', 'database-recovery']);

Router::get('/admin/create', [UserController::class, 'createAdmin']);
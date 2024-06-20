<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Mj\PocketCore\Controller;

class AdminPanelController extends Controller
{
    public function index()
    {
        $usersCount = (new User())->count();
        $productsCount = (new Product())->count();
        $commentsCount = (new Comment())->count();

        return view('admin.dashboard.index',
            compact('usersCount', 'productsCount', 'commentsCount')
        );
    }
}
<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\Product;
use App\Models\User;
use Mj\PocketCore\Controller;

class AdminPanelController extends Controller
{
    public function index()
    {
        $usersCount = (new User())->count();
        $productsCount = (new Product())->count();

        return view('admin.dashboard.index', compact('usersCount', 'productsCount'));
    }
}
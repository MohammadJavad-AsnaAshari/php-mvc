<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Mj\PocketCore\Controller;

class AdminPanelController extends Controller
{
    public function index()
    {
        $usersCount = (new User())->count();
        $productsCount = (new Product())->count();
        $categoriesCount = (new Category())->count();
        $ordersCount = (new Order())->count();

        return view('admin.dashboard.index',
            compact('usersCount', 'productsCount', 'categoriesCount', 'ordersCount')
        );
    }
}
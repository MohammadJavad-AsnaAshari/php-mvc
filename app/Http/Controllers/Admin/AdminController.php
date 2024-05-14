<?php

namespace App\Http\Controllers\Admin;

use Mj\PocketCore\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return $this->render('admin.index');
    }
}
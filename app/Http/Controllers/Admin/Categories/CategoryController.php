<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Models\Category;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Exceptions\ServerException;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = (new Category())->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = (new Category())->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'parent_id' => 'numeric',
                'name' => 'required|min:3|max:255',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/categories/create');
        }

        $validatedData = $validation->getValidatedData();

        try {
            $category = new Category();
            $category->create($validatedData);

            return redirect('/admin-panel/categories');
        } catch (\Exception $e) {
            error_log($e->getMessage());

            // Throw an exception to stop further execution
            throw new ServerException('The process not successfully!');
        }
    }

    public function edit(int $categoryId)
    {
        throw new ServerException();
    }

    public function update()
    {

    }

    public function delete()
    {
        throw new ServerException();
    }
}
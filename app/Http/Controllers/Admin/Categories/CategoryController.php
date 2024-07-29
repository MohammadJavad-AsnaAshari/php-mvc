<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Models\Category;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Exceptions\NotFoundException;
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
                'name' => 'required|min:3|max:255|unique:categories,name',
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
        $selfCategory = (new Category())->find($categoryId);

        return view('admin.categories.edit', compact('selfCategory'));
    }

    public function update()
    {
        if (request()->has('category_id')) {
            $categoryId = request()->input('category_id');
            $category = (new Category())->find($categoryId);
            $validation = $this->validate(
                request()->all(),
                [
                    'name' => 'required|min:3|max:255|unique:categories,name,' . $category->name,
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/categories/edit/' . $categoryId);
            }

            $validatedData = $validation->getValidatedData();

            try {
                $category->update($categoryId, $validatedData);

                return redirect('/admin-panel/categories');
            } catch (\Exception $e) {
                error_log($e->getMessage());

                // Throw an exception to stop further execution
                throw new ServerException();
            }
        }

        throw new NotFoundException('This category not fount!');
    }

    public function delete()
    {
        if (request()->has('category_id')) {
            $categoryId = request()->input('category_id');
            (new Category())->delete($categoryId);

            return redirect('/admin-panel/categories');
        }

        throw new NotFoundException('This category not fount!');
    }
}
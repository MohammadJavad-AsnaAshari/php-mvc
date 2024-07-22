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
        $sql = "SELECT c1.id, c2.name as parent_name, c1.name, c1.created_at
                FROM categories as c1
                LEFT JOIN categories as c2 ON c1.parent_id = c2.id";
        $categories = (new Category())->query($sql);

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
//                'parent_id' => 'numeric',
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

        $sql = "SELECT c1.id, c1.name
                FROM categories as c1
                LEFT JOIN categories as c2 ON c1.parent_id = c2.id";
        $categories = (new Category())->get();

        return view('admin.categories.edit', compact('selfCategory', 'categories'));
    }

    public function update()
    {
        if (request()->has('category_id')) {
            $categoryId = request()->input('category_id');
            $category = (new Category())->find($categoryId);
            $validation = $this->validate(
                request()->all(),
                [
//                    'parent_id' => 'numeric',
                    'name' => 'required|min:3|max:255|unique:categories,name,' . $category->name,
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/categories/edit/' . $categoryId);
            }

            $validatedData = $validation->getValidatedData();

            // Check if the selected parent category is a descendant of the current category
//            $parentId = $validatedData['parent_id'];
//            $descendants = $this->getCategoryDescendants($categoryId);
//            if ($parentId !== null) {
//                foreach ($descendants as $child) {
//                    if ($child['id'] == $parentId) {
//                        throw new ServerException("You can't chosen category's children");
//                    }
//                }
//            }

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

//    private function getCategoryDescendants($categoryId, $descendants = [])
//    {
//        $children = (new Category())->where('parent_id', $categoryId)->get();
//
//        foreach ($children as $child) {
//            $descendants[] = [
//                'id' => $child->id,
//            ];
//            $descendants = array_merge($descendants, $this->getCategoryDescendants($child->id, $descendants));
//        }
//
//        return $descendants;
//    }
}
<?php

namespace App\Http\Controllers\Admin\Products;

use App\Models\Product;
use Mj\PocketCore\Controller;


class ProductController extends Controller
{
    public function index()
    {
        $sql = "SELECT products.*, COUNT(product_like.id) as likes
                FROM products
                LEFT JOIN product_like ON products.id = product_like.product_id
                GROUP BY products.id";

        $products = (new Product())->query($sql);

        return view('admin.products.index', compact('products'));
    }

    public function show(int $userId)
    {

    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'description' => 'required|max:255',
                'specification' => 'required|max:255',
                'price' => 'required|numeric|min:0',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/products/create');
        }

        $validatedData = $validation->getValidatedData();

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move('storage/app/product', $imageName);

            // Save the image name in the database
            $validatedData['image'] = $imageName;
        }
        (new Product())->create([...$validatedData]);

        return redirect('/admin-panel/products');
    }

    public function edit(int $productId)
    {
        $product = (new Product())->find($productId);

        return view('admin.products.edit', compact('product'));
    }

    public function update()
    {
        if (request()->has('product_id')) {
            $product = (new Product())->find(request()->input('product_id'));
            $validation = $this->validate(
                request()->all(),
                [
                    'name' => 'required|min:3|max:255',
                    'description' => 'required|max:255',
                    'specification' => 'required|max:255',
                    'price' => 'required|numeric|min:0',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/products/update');
            }

            $validatedData = $validation->getValidatedData();

            if (request()->hasFile('image')) {
                $image = request()->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Delete the old image file if it exists
                if ($product->image) {
                    $oldImagePath = 'storage/app/product/' . $product->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image->move('storage/app/product', $imageName);

                // Save the image name in the database
                $validatedData['image'] = $imageName;
            }
            (new Product())->update($product->id, [...$validatedData]);

            return redirect('/admin-panel/products');
        }

        return redirect('/admin-panel/products');
    }

    public function delete()
    {
        if (request()->has('product_id')) {
            $productId = request()->input('product_id');
            (new Product())->delete($productId);

            return redirect('/admin-panel/products');
        }

        return redirect('/admin-panel/products');
    }
}
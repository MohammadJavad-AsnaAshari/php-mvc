<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Dotenv\Validator;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Request;
use Rakit\Validation\Validation;

class HomeController extends Controller
{
    public function indexHome(): string
    {
        return $this->render('client.home');
    }

    public function indexShop(): string
    {
        $products = new Product();

        if (request()->has('search')) {
            $search = request('search');
            $products = $products->where('name', $search, 'LIKE');
        }

        $products = $products->get();

        return $this->render('client.shop', compact('products'));
    }

    public function productEdit(int $product)
    {
        if ($product = (new Product())->where('id', $product)->first()) {
            return $this->render('product.edit', compact('product'));
        }

        return 'this product does not exist!';
    }

    public function productUpdate(Request $request, int $product)
    {
        $productModel = new Product();
        $product = $productModel->where('id', $product)->first();

        if (!$product) {
            // Handle the case where the product doesn't exist
            return redirect('/shop');
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
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
            $data['image'] = $imageName;
        }

        // Save the updated data to the database
        $product->update($product->id, $data);

        // Redirect the user to a page that displays the updated product
        return redirect('/shop');
    }
}
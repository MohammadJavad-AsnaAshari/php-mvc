<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Models\User;
use Dotenv\Validator;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Request;
use Rakit\Validation\Validation;

class ShopController extends Controller
{
    public function index(): string
    {
        $products = new Product();

        if (request()->has('search')) {
            $search = request('search');
            $products = $products->where('name', $search, 'LIKE');
        }

        $products = $products->get();

        return $this->render('client.shop', compact('products'));
    }

    public function show(int $product)
    {
        $product = (new Product())->where('id', $product)->first();
        $productLikes = is_null($product->likes()) ? 0 : count($product->likes());

        return view('client.single-shop', compact('product', 'productLikes'));
    }

    public function popular()
    {
        return view('client.popular');
    }

    public function like(int $product)
    {
        $product = (new Product())->where('id', $product)->first();
        $liker = auth()->user();

        if ($product && $liker) {
            if (!$liker->likesPost($product->id)) {
                $pivotModel = new User();
                $pivotModel->from('product_like');
                $pivotModel->create([
                    'user_id' => $liker->id,
                    'product_id' => $product->id,
                ]);
            }
        }

        return redirect("/shop/$product->id");
    }

    public function unlike(int $product)
    {
        $product = (new Product())->where('id', $product)->first();
        $liker = auth()->user();

        if ($product && $liker) {
            if ($liker->likesPost($product->id)) {
                $pivotModel = new User();
                $pivotModel->from('product_like');
                $pivotModel->where('user_id', $liker->id)->where('product_id', $product->id);
                $pivotResult = $pivotModel->first();
                $pivotModel->delete($pivotResult->id);
            }
        }

        return redirect("/shop/$product->id");
    }
}
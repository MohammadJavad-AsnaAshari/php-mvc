<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Exceptions\NotFoundException;

class CartController extends Controller
{
    public function index()
    {
        $cartKey = $this->getCartKey();
        $products = session()->get($cartKey, []);

        return view('client.carts.index', compact('products'));
    }

    public function storeProduct()
    {
        if (request()->has('product_id')) {
            $productId = request()->input('product_id');
            $product = (new Product())->find($productId);

            if ($product) {
                $cartKey = $this->getCartKey();
                $cart = session()->get($cartKey, []);

                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity']++;
                } else {
                    $cart[$productId] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image,
                        'price' => $product->price,
                        'quantity' => 1
                    ];
                }
                session()->set($cartKey, $cart);

                return redirect('/cart');
            }
        }

        throw new NotFoundException('This product does not exist!');
    }


    public function updateQuantity()
    {
        if (request()->has('product_id') && request()->has('quantity')) {
            $productId = request()->input('product_id');
            $quantity = request()->input('quantity');

            $cartKey = $this->getCartKey();
            $cart = session()->get($cartKey, []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                session()->set($cartKey, $cart);

                return redirect('/cart');
            }
        }

        throw new NotFoundException('Product not found in cart!');
    }

    public function delete()
    {
        if (request()->has('product_id')) {
            $productId = request()->input('product_id');

            $cartKey = $this->getCartKey();
            $cart = session()->get($cartKey, []);

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->set($cartKey, $cart);

                return redirect('/cart');
            }
        }

        throw new NotFoundException('Product not found in cart!');
    }

    private function getCartKey()
    {
        // Get the currently authenticated user's ID
        $userId = auth()->user()->id;

        return 'cart_user_' . $userId;
    }
}
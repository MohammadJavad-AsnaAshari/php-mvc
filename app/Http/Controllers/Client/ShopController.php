<?php

namespace App\Http\Controllers\Client;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Mj\PocketCore\Controller;

class ShopController extends Controller
{
    public function index(): string
    {
        $products = new Product();
        $orderBy = 'DESC';

        if (!request()->has('products') || request('products') !== 'all') {
            $products->limit(8);
        }

        if (request()->has('search')) {
            $search = request('search');
            $products = $products->where('name', $search, 'LIKE');
        }

        if (request()->has('order-by')) {
            $param = strtoupper(request('order-by'));
            if ($param === 'ASC' || $param === 'DESC') {
                $orderBy = $param;
            }
        }

        $products = $products->orderBy('created_at', $orderBy)->get();

        return $this->render('client.shop', compact('products'));
    }

    public function show(int $product)
    {
        $product = (new Product())->where('id', $product)->first();
        $productLikes = is_null($product->likes()) ? 0 : count($product->likes());

        $sql = "SELECT comments.*, users.name as user_name
            FROM comments
            INNER JOIN users ON comments.user_id = users.id
            WHERE comments.product_id = :product_id
            ORDER BY comments.created_at DESC";

        $comments = (new Comment())->query($sql, ['product_id' => $product->id]);

        return view('client.single-shop', compact('product', 'productLikes', 'comments'));
    }

    public function popular()
    {
        $sql = "SELECT products.*, COUNT(product_like.id) as likes
            FROM products
            LEFT JOIN product_like ON products.id = product_like.product_id
            GROUP BY products.id
            ORDER BY likes DESC
            LIMIT 4";
        $products = (new Product())->query($sql);

        return view('client.popular', compact('products'));
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
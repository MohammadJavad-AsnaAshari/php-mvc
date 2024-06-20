<?php

namespace App\Http\Controllers\Client;

use App\Models\Comment;
use App\Models\Product;
use Mj\PocketCore\Controller;

class CommentController extends Controller
{
    public function store(int $productId)
    {
        $product = (new Product())->find($productId);

        if ($product) {
            $validation = $this->validate(
                request()->all(),
                [
                    'comment' => 'required|min:3|max:255',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect("/shop/$productId/comments");
            }

            $validatedData = $validation->getValidatedData();

            $comment = (new Comment());
            $comment->create([
                'user_id' => auth()->user()->id,
                'product_id' => $product->id,
                'comment' => $validatedData['comment'],
            ]);

            return redirect("/shop/$productId");
        }

        return redirect("/shop/$productId");
    }
}
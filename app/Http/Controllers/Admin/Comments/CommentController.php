<?php

namespace App\Http\Controllers\Admin\Comments;

use App\Models\Comment;
use App\Models\Product;
use Mj\PocketCore\Controller;

class CommentController extends Controller
{
    public function index()
    {
        $sql = "SELECT comments.*, users.name as user_name, products.name as product_name
            FROM comments
            INNER JOIN users ON comments.user_id = users.id
            INNER JOIN products ON comments.product_id = products.id
            ORDER BY comments.created_at DESC";

        $comments = (new Comment())->query($sql);

        return view('admin.comments.index', compact('comments'));
    }

    public function edit(int $commentId)
    {
        $comment = (new Comment())->find($commentId);

        return view('admin.comments.edit', compact('comment'));
    }

    public function update()
    {
        if (request()->has('comment_id')) {
            $commentId = request()->input('comment_id');
            $comment = (new Comment())->find($commentId);
            $validation = $this->validate(
                request()->all(),
                [
                    'comment' => 'required|min:3|max:255',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/comments/edit/' . $commentId);
            }

            $validatedData = $validation->getValidatedData();
            $comment->update($commentId, $validatedData);

            return redirect('/admin-panel/comments');
        }

        return redirect('/admin-panel/comments');
    }

    public function delete()
    {
        if (request()->has('comment_id')) {
            $commentId = request()->input('comment_id');
            (new Comment())->delete($commentId);

            return redirect('/admin-panel/comments');
        }

        return redirect('/admin-panel/comments');
    }
}
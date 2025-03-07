<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'recipe_id' => 'required|integer',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->recipe_id = $request->recipe_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return response()->json([
            'message' => 'Successfully created comment!',
            'comment' => $comment
        ], 201);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found!'
            ], 404);
        }

        if ($comment->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized!'
            ], 401);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Successfully deleted comment!'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CommentController extends Controller
{
    /**
     * Comment on Post: Create an endpoint for commenting on a post.
     */
    public function store(Request $request, $post_id, $blog_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'content' => 'required|string',
                'user_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'data' => $validator->errors()
                ], 400);
            }

            $post = Post::where('blog_id', $blog_id)->find($post_id);
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }

            if (!$post) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found',
                ], 404);
            }

            $post = Post::findOrFail($post_id);
            $comment = $post->comments()->create([
                'post_id' => $post_id,
                'user_id' => $request->user_id,
                'content' => $request->content,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Comment added successfully',
                'data' => $comment
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Comment: Create an endpoint for deleting a comment.
     */
    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);

            if (!$comment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Comment not found',
                ], 404);
            }

            $comment->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Comment deleted successfully',
                'data' => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

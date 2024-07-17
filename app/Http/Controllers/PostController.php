<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class PostController extends Controller
{
    /**
     * View All Posts: Create an endpoint to fetch all posts under a specific blog.
     */
    public function index($blog_id)
    {
        try {
            $blog = Blog::findOrFail($blog_id);
            $posts = $blog->posts;

            return response()->json([
                'status' => 'success',
                'message' => count($posts) . ' Posts returned',
                'data' => $posts
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create Post: Create an endpoint to create a new post under a specific blog.
     */
    public function store(Request $request, $blog_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'photo_url' => 'nullable|url'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'data' => $validator->errors()
                ], 400);
            }

            $blog = Blog::findOrFail($blog_id);
            $post = $blog->posts()->create([
                'blog_id' => $blog_id,
                'title' => $request->title,
                'content' => $request->content,
                'photo_url' => $request->photo_url
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $post
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show Post: Create an endpoint to fetch details of a specific post.
     */
    public function show($blog_id, $post_id)
    {
        try {
            $blog = Blog::findOrFail($blog_id);
            $post = $blog->posts()->with('comments')->findOrFail($post_id);

            if (!$post) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $post
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Post: Create an endpoint to update an existing post.
     */
    public function update(Request $request, $blog_id, $post_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'photo_url' => 'nullable|url'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'data' => $validator->errors()
                ], 400);
            }

            $blog = Blog::findOrFail($blog_id);
            $post = $blog->posts()->findOrFail($post_id);

            if (!$post) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found'
                ], 404);
            }

            $post->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Post updated successfully',
                'data' => $post
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Post: Create an endpoint to delete a post.
     */
    public function destroy($blog_id, $post_id)
    {
        try {
            $blog = Blog::findOrFail($blog_id);
            $post = $blog->posts()->findOrFail($post_id);

            if (!$post) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found',
                ], 404);
            }

            $post->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Post deleted successfully',
                'data' => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Post: Create an endpoint to delete a post.
     */
    public function like(Request $request, $blog_id, $post_id)
    {
        try {
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

            $user->toggleLike($post);

            $message = $user->hasLiked($post) == 1 ? 'Post liked' : 'Post unliked';


            return response()->json([
                'status' => 'success',
                'message' => $message,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to complete action',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

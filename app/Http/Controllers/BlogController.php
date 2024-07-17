<?php

// app/Http/Controllers/BlogController.php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class BlogController extends Controller
{

    /**
     * View All Blogs: Create an endpoint to fetch all blogs.
     */
    public function index()
    {
        try {
            $blogs = Blog::all();

            return response()->json([
                'status' => 'success',
                'data' => $blogs
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve blogs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create Blog: Create an endpoint to create a new blog.
     */
    public function store(Request $request)
    {

        // return $request;
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'photo_url' => 'nullable|url'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'data' => $validator->errors()
                ], 400);
            }

            $blog = Blog::create($request->all());

            return response()->json([
                'status' => 'success',
                'data' => $blog
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show Blog: Create an endpoint to fetch details of a specific blog and its posts.
     */
    public function show($id)
    {
        try {
            // $blog = Blog::with('posts', 'comments')->find($id);
            $blog = Blog::find($id);

            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'data' => 'Blog not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $blog
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Blog: Create an endpoint to update an existing blog.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'data' => $validator->errors()
                ], 400);
            }

            $blog = Blog::find($id);

            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found'
                ], 404);
            }

            $blog->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Blog updated successfully',
                'data' => $blog
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Blog: Create an endpoint to delete a blog.
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::find($id);

            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'data' => 'Blog not found'
                ], 404);
            }

            $blog->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Blog deleted successfully',
                'data' => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

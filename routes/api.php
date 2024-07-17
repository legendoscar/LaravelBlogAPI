<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


/* organizations */
Route::group([
    'middleware' => ['api'],
    'prefix' => 'blogs'
], function ($router) {
    Route::get('/', [BlogController::class, 'index']);
    Route::post('/create', [BlogController::class, 'store']);
    Route::get('/{id}', [BlogController::class, 'show']);
    Route::put('/{id}/update', [BlogController::class, 'update']);
    Route::delete('/{id}/delete', [BlogController::class, 'destroy']);
});



Route::prefix('blogs/{blog_id}')->group(function () {
    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
    Route::post('posts/{post_id}/like', [PostController::class, 'like']);
    Route::post('posts/{post_id}/comment', [CommentController::class, 'store']);
});


// Route::apiResource('blogs', BlogController::class);


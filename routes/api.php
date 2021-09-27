<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/external-books/{book}', [BookController::class, 'external_books']);

Route::prefix('v1')->group(function () {
    // Route::get('posts', 'Api\ApiController@posts');
    // Route::get('posts/{news}', 'Api\ApiController@read');
    // Route::get('category{type}', 'Api\ApiController@category');
    // Route::get('category/{category}', 'Api\ApiController@post_category');
    // Route::get('catname/{cat}', 'Api\ApiController@get_by_catname');
});



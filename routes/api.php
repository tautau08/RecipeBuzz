<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterCOntroller;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'app'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::post('recipe/create', [RecipeController::class, 'create']);
    Route::post('recipe/edit/{id}', [RecipeController::class, 'edit']);
    Route::post('recipe/delete/{id}', [RecipeController::class, 'delete']);

    Route::post('comment/create', [CommentController::class, 'create']);
    Route::post('comment/delete/{id}', [CommentController::class, 'delete']);

    Route::post('rating/create', [RatingController::class, 'create']);

});


// Todo : following codes do not need to be accessed by authenticated users

Route::group([

    'prefix' => 'app'

], function ($router) {

    Route::post('register', [RegisterCOntroller::class, 'register']);
    Route::get('recipe/all', [RecipeController::class, 'getAll']);
    Route::get('recipe/show/{id}', [RecipeController::class, 'getSingleRecipe']);
});
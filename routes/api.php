<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;

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

Route::get('/fetchIndexArticles', [ArticleController::class, 'fetchIndexArticles']);
Route::get('/fetchIndexCategories', [CategoryController::class, 'fetchIndexCategories']);
Route::get('/fetchCategoryArticles/{slug}', [ArticleController::class, 'fetchCategoryArticles']);
Route::get('/fetchArticlesFromPermalink/{permalink}', [ArticleController::class, 'fetchArticlesFromPermalink']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', MeController::class);

    Route::get('/fetchAllTags', [TagController::class, 'fetchAllTags']);
    Route::get('/fetchSelectorTags', [TagController::class, 'fetchSelectorTags']);
    Route::patch('/updateTag/{tag}', [TagController::class, 'update']);
    Route::delete('/deleteTag/{tag}', [TagController::class, 'destroy']);

    Route::get('/fetchAllArticles', [ArticleController::class, 'fetchAllArticles']);
    Route::get('/fetchArticle/{article}', [ArticleController::class, 'fetchArticles']);
    Route::post('/storeArticle', [ArticleController::class, 'store']);
    Route::patch('/updateArticle/{article}', [ArticleController::class, 'update']);
    Route::delete('/deleteArticle/{article}', [ArticleController::class, 'destroy']);
    Route::patch('/visibleArticle/{article}', [ArticleController::class, 'visible']);

    Route::get('/fetchAllCategories', [CategoryController::class, 'fetchAllCategories']);
    Route::get('/fetchSelectorCategories', [CategoryController::class, 'fetchSelectorCategories']);
    Route::post('/storeCategory', [CategoryController::class, 'store']);
    Route::patch('/updateCategory/{category}', [CategoryController::class, 'update']);
    Route::delete('/deleteCategory/{category}', [CategoryController::class, 'destroy']);

    Route::get('/fetchAllImages', [ImageController::class, 'fetchAllImages']);
    Route::get('/fetchSelectorImage', [ImageController::class, 'fetchSelectorImage']);
    Route::post('/storeImage', [ImageController::class, 'store']);
    Route::delete('/deleteImage/{image}', [ImageController::class, 'destroy']);
});

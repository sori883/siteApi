<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', MeController::class);

    Route::get('/fetchAllTags', [TagController::class, 'fetchAllTags']);

    Route::get('/fetchAllArticles', [ArticleController::class, 'fetchAllArticles']);
    Route::get('/fetchArticle/{article}', [ArticleController::class, 'fetchArticles']);
    Route::post('/storeArticle', [ArticleController::class, 'store']);
    Route::patch('/updateArticle/{article}', [ArticleController::class, 'update']);
    Route::delete('/deleteArticle/{article}', [ArticleController::class, 'destroy']);
    Route::patch('/visibleArticle/{article}', [ArticleController::class, 'visible']);

    Route::get('/fetchAllCategories', [CategoryController::class, 'fetchAllCategories']);
    Route::post('/storeCategory', [CategoryController::class, 'store']);
    Route::delete('/deleteCategory/{category}', [CategoryController::class, 'destroy']);
});

Route::post('/forgot', [ForgotController::class, 'forgot']);
Route::post('/reset', [PasswordResetController::class, 'reset']);

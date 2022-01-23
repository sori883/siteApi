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
    Route::post('/storeArticle', [ArticleController::class, 'store']);
    Route::delete('/deleteArticle/{article}', [ArticleController::class, 'destroy']);

    Route::get('/fetchAllCategories', [CategoryController::class, 'fetchAllCategories']);
});

Route::post('/forgot', [ForgotController::class, 'forgot']);
Route::post('/reset', [PasswordResetController::class, 'reset']);

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\TagController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => ['guest:sanctum']
], function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
});

Route::post('auth/verify', [AuthController::class, 'verifyCode'])->middleware(['auth:sanctum']);

Route::middleware('guest:sanctum')->get('/users', function (Request $request) {
    return User::get();
});

Route::group([
    'middleware' => ['auth:sanctum', 'code.verify']
], function () {
    Route::get('stats', [StatisticController::class, 'stats']);

    Route::get('posts/trash', [PostController::class, 'trash']);
    Route::patch('posts/{post}/restore', [PostController::class, 'restore']);

    Route::apiResources([
        'tags' => TagController::class,
        'posts' => PostController::class,
    ]);
});

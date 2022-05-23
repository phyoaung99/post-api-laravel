<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ForgotController;
use App\Http\Controllers\API\PassportAuthController;

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

Route::get('register-page',[PassportAuthController::class,'registerPage']);
Route::get('login-page',[PassportAuthController::class,'loginPage']);
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('logout', [PassportAuthController::class, 'logout']);

Route::get('post-list', function(){
    return view('posts.index');
});
Route::get('reset/{token}',[ForgotController::class, 'resetLink']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', PostController::class);
    Route::get('get-user', [PassportAuthController::class, 'userInfo']);
    Route::get('/search', [PostController::class, 'search']);
    Route::get('export', [PostController::class, 'export']);
    Route::post('import',[PostController::class, 'import']);
    Route::post('reset', [ForgotController::class, 'reset']);
    Route::post('forgot', [ForgotController::class, 'forgot']);
});

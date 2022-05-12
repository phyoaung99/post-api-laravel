<?php
use App\Models\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ForgotController;
use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

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
    Route::post('forgot', [ForgotController::class, 'forgot']);
    Route::post('reset', [ForgotController::class, 'reset']);
});

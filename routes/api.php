<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\RabbitMqController;

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

Route::post('/publish',[RabbitMqController::class,'publishMessage']);
Route::get('/consume',[RabbitMqController::class,'consumeMessage']);


Route::group(['prefix' => 'auth'], function () {
    Route::post('/login',[LoginController::class,'login']);
    Route::post('/register',[RegisterController::class,'register']);
    Route::post('/user-email-exists',[LoginController::class,'userEmailExists']);
    Route::post('/send-activation-email',[RegisterController::class,'sendActivationEmail']);
    Route::get('user/activation/{token}', [RegisterController::class,'activateUser'])->name('user.activate');
    Route::post('/reset',[ResetPasswordController::class,'sendResetpasswordEmail']);
    Route::post('/password',[ResetPasswordController::class,'resetPassword']);
    Route::post('/validate-password-reset',[ResetPasswordController::class,'authorizePasswordReset']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/check',[AuthController::class,'check']);
        Route::post('/logout',[LoginController::class,'logout']);

    });

});

Route::get('/sql', [LoginController::class, 'sqlMapTest']);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('event:clear');
    Artisan::call('event:cache');
    $data = ['message' => 'Application cache has been cleared'];
    return response()->json($data, 200);
});

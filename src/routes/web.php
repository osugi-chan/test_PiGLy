<?php

use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightTargetController;
use App\Http\Controllers\WeightLogController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*新規会員登録：URL(register/step1)設定*/
Route::group(['middleware' => config('fortify.middleware', ['guest'])], function () {
    Route::get('/register/step1',[RegisterUserController::class,'create']);
    /*新規会員登録処理*/
    Route::post('/register/step1',[RegisterUserController::class,'store']);
});

/*目標体重設定：URL(register/step2)設定*/
Route::group(['middleware' => config('fortify.middleware', ['web'])], function (){
    Route::get('/register/step2',[WeightTargetController::class,'create']);
    /*目標体重登録処理*/
    Route::post('/register/step2',[WeightTargetController::class,'store'])
    ->name('weight_target.store');
});

/*ログイン：URL(/login)設定*/
Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest'])
    ->name('login');

    /*ログイン処理*/
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest']);
});

/*ログアウト：URL(/logout)設定*/
Route::post('/logout',[LogoutController::class,'logout'])
->middleware('auth')
->name('logout');


/*管理ページのアクセス設定*/
Route::middleware(['web','auth'])->group(function(){
    Route::get('/weight_logs',[WeightLogController::class,'index']);
    Route::post('/weight_logs/search',[WeightLogController::class,'search']);
    Route::post('/weight_logs/create',[WeightLogController::class,'store']);

    /*目標体重変更ページ遷移と更新設定*/
    Route::get('/weight_logs/goal_setting',[WeightTargetController::class,'edit']);
    Route::put('/weight_logs/goal_setting',[WeightTargetController::class,'update']);

    /*体重詳細画面遷移設定と更新設定*/
    Route::get('/weight_logs/{weightLogId}',[WeightLogController::class,'edit']);
    Route::post('/weight_logs/{weightLogId}/update',[WeightLogController::class,'update']);

    /*体重ログの削除処理*/
    Route::get('/weight_logs/{weightLogId}/delete',[WeightLogController::class,'destroy']);
});


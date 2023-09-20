<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\isAdminMiddleware;
use App\Http\Middleware\onlyAdminsMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('dashboard');
    }else{
        return view('welcome');
    }

})->name('home');

Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/login',function () {
    if (Auth::check()) {
        return redirect('dashboard');
    }else{
        return view('welcome');
    }

});
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboardShow'])->name('dashboard');
    Route::get('/order', [AdminDashboardController::class, 'order'])->name('order')->middleware(onlyAdminsMiddleware::class);

    Route::get('/profile', [UserDashboardController::class, 'profilePage'])->name('profilePage');
    Route::get('/ordersHistory', [UserDashboardController::class, 'ordersHistory'])->name('ordersHistory');
    Route::post('/profile/changePassword', [UserDashboardController::class, 'changePassword'])->name('changePassword');
    Route::post('/profile/changeInfo', [UserDashboardController::class, 'changeInfo'])->name('changeInfo');


    Route::post('/addLoc', [AdminDashboardController::class, 'addLoc'])->name('addLoc')->middleware(isAdminMiddleware::class);
    Route::post('/addComp', [AdminDashboardController::class, 'addComp'])->name('addComp')->middleware(isAdminMiddleware::class);
    Route::post('/addUser', [AdminDashboardController::class, 'addUser'])->name('addUser')->middleware(isAdminMiddleware::class);
    Route::post('/addUserExcel', [AdminDashboardController::class, 'addUserExcel'])->name('addUserExcel')->middleware(isAdminMiddleware::class);
    Route::post('/addFood', [AdminDashboardController::class, 'addFood'])->name('addFood')->middleware(onlyAdminsMiddleware::class);
    Route::post('/addFoodExcel', [AdminDashboardController::class, 'addFoodExcel'])->name('addFoodExcel')->middleware(isAdminMiddleware::class);

    Route::get('/exportExc', [AdminDashboardController::class, 'exportExc'])->name('exportExc')->middleware(onlyAdminsMiddleware::class);
    Route::get('/exportExcNew', [AdminDashboardController::class, 'exportExcNew'])->name('exportExcNew')->middleware(onlyAdminsMiddleware::class);
    Route::get('/exportExcAccounting', [AdminDashboardController::class, 'exportExcAccounting'])->name('exportExcAccounting')->middleware(onlyAdminsMiddleware::class);


    Route::post('/submitOrder', [UserDashboardController::class, 'submitOrder'])->name('submitOrder');
    Route::post('/deleteOrder', [UserDashboardController::class, 'deleteOrder'])->name('deleteOrder');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
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


Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::put('/admin/marques/{marque}', [AdminController::class, 'updateMarque'])->name('admin.marques.update');
    Route::post('/admin/addmarque', [AdminController::class, 'addmarque'])->name('admin.addmarque');
    Route::delete('/admin/marques/{marque}', [AdminController::class, 'deleteMarque'])->name('admin.marques.delete');
    Route::put('/admin/cars/{car}', [AdminController::class, 'updateCarStatus'])->name('admin.car.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

});

Route::get('marque/logo/{filename}', function ($filename) {
    $path = storage_path('app/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('marque.logo');




Route::get('/addcars', [UserController::class, 'addcar']);
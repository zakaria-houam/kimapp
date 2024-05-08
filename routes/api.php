<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use App\Http\Controllers\UserController;


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





Route::post('/addusers', [UserController::class, 'store']);
Route::get('/loginusers', [UserController::class, 'login']);


Route::get('/viewcars', [UserController::class, 'viewcars']);
Route::delete('/deletespecificcar/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/search/{keyword}', [UserController::class, 'search']);
Route::get('/marques', [UserController::class, 'viewmarques']);
Route::get('/cars/filter', [UserController::class, 'filter']);
Route::put('/modifycar/{id}', [UserController::class, 'modifyCar'])->middleware('auth:sanctum');
Route::delete('/deleteuser/{id}', [UserController::class, 'deleteUser'])->middleware('auth:sanctum');


Route::get('/marques-with-cars', [UserController::class, 'indexWithCars']);



Route::post('/addcars', [UserController::class, 'addcar'])->middleware('auth:sanctum');
Route::post('/addmarque', [UserController::class, 'addmarque']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    
    return $request->user()->json();
});
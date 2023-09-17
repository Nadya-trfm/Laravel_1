<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(ClientController::class)->prefix('client')->group(function () {
    Route::get('/getAll', 'getAll');
    Route::post('/create', 'create');
    Route::put('/update/{id}', 'update');
    Route::get('/update/{id}', 'edit');
    Route::delete('/delete/{id}', 'delete');
});



Route::controller(AddressController::class)->prefix('address')->group(function () {
    Route::get('/getAll', 'getAll');
    Route::post('/create', 'create');
    Route::put('/update/{id}', 'update');
    Route::get('/update/{id}', 'edit');
    Route::delete('/delete/{id}', 'delete');
});

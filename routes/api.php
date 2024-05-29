<?php

use App\Http\Controllers\BagiBonusController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('bagi-bonus')->name('bagi-bonus.')->group(function () {
    Route::get('/', [BagiBonusController::class, 'index'])->name('index');
    Route::post('/', [BagiBonusController::class, 'store'])->name('store');
    Route::get('/{id}', [BagiBonusController::class, 'show'])->name('show');
    Route::put('/{id}', [BagiBonusController::class, 'update'])->name('update');
    Route::delete('/{id}', [BagiBonusController::class, 'delete'])->name('delete');
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TypeController;
 
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

Route::resource('columns', ColumnController::class);
Route::resource('documents', DocumentController::class);
Route::get('documents/{id}/download', [DocumentController::class, 'download'])->name('download-document');
Route::resource('types', TypeController::class);

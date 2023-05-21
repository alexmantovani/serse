<?php

use App\Http\Controllers\MissingTranslationController;
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

// http://127.0.0.1:8000/api/contact/index
Route::prefix('/translation')->group(function() {
    // Route::get('/index', [ContactController::class, 'index'])->middleware('auth:api');
    Route::post('/missing', [MissingTranslationController::class, 'receiveMissing']);//->middleware('auth:api');
});

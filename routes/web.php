<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/accredit/get/{token}', [App\Http\Controllers\AccreditController::class, 'get'])->name('accredit.get');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/accredit', App\Http\Controllers\AccreditController::class);
    Route::get('/accredit/download/{token}', [App\Http\Controllers\AccreditController::class, 'download'])->name('accredit.download');
    Route::get('/accredit/tutorial/{type}', [App\Http\Controllers\AccreditController::class, 'tutorial'])->name('accredit.tutorial');
    Route::get('/accredit/resend/{token}', [App\Http\Controllers\AccreditController::class, 'resend'])->name('accredit.resend');
    Route::get('/accredit/show/{token}', [App\Http\Controllers\AccreditController::class, 'show'])->name('accredit.show');
});

require __DIR__.'/auth.php';

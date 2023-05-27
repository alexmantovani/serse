<?php

use App\Http\Controllers\DashboardController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/accredit/get/{token}', [App\Http\Controllers\AccreditController::class, 'get'])->name('accredit.get');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/accredit/report', [App\Http\Controllers\AccreditController::class, 'report'])->name('accredit.report');
    Route::resource('/accredit', App\Http\Controllers\AccreditController::class);
    Route::get('/accredit/download/{token}', [App\Http\Controllers\AccreditController::class, 'download'])->name('accredit.download');
    Route::get('/accredit/tutorial/{type}', [App\Http\Controllers\AccreditController::class, 'tutorial'])->name('accredit.tutorial');
    Route::get('/accredit/resend/{token}', [App\Http\Controllers\AccreditController::class, 'resend'])->name('accredit.resend');
    Route::get('/accredit/show/{token}', [App\Http\Controllers\AccreditController::class, 'show'])->name('accredit.show');
    Route::post('/accredit/upload', [App\Http\Controllers\AccreditController::class, 'upload'])->name('accredit.upload');

    // Mostra la pagina per caricamento delle traduzioni ricevute da intradoc
    Route::get('/missing/load', [App\Http\Controllers\MissingTranslationController::class, 'load'])->name('missing.load');
    // Esegue l'upload del file con le traduzioni tradotte
    Route::post('/missing/upload', [App\Http\Controllers\MissingTranslationController::class, 'upload'])->name('missing.upload');

    Route::get('/missing/serial/{serial}', [App\Http\Controllers\MissingTranslationController::class, 'indexSerial'])->name('missing.serial');

    Route::get('/missing/send', [App\Http\Controllers\MissingTranslationController::class, 'send'])->name('missing.send');
    Route::get('/missing/verify', [App\Http\Controllers\MissingTranslationController::class, 'verifyBeforeSend'])->name('missing.verify');
    Route::get('/missing/index', [App\Http\Controllers\MissingTranslationController::class, 'index'])->name('missing.index');
    Route::get('/missing/show/{id}', [App\Http\Controllers\MissingTranslationController::class, 'show'])->name('missing.show');
    Route::delete('/missing/destroy/{id}', [App\Http\Controllers\MissingTranslationController::class, 'destroy'])->name('missing.destroy');

    // Route::get('/translation/index', [App\Http\Controllers\TranslationController::class, 'index'])->name('translation.index');
    Route::resource('/translation', App\Http\Controllers\TranslationController::class);

});

require __DIR__.'/auth.php';

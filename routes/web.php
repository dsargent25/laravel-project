<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\PastWeekDataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'chirps'], function () {
    Route::get('/', [ChirpController::class, 'index'])->name('chirps.index');
    Route::post('/', [ChirpController::class, 'store'])->name('chirps.store');
    Route::get('/{chirp}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
    Route::put('/{chirp}', [ChirpController::class, 'update'])->name('chirps.update');
    Route::delete('/{chirp}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
    Route::get('/latest', [ChirpController::class, 'latest'])->name('chirps.latest');
});

require __DIR__.'/auth.php';

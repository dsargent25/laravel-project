<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\CommentController;
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
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('chirps/', [ChirpController::class, 'index'])->name('chirps.index');
Route::post('chirps/', [ChirpController::class, 'store'])->name('chirps.store');
Route::get('chirps/{chirp}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
Route::put('chirps/{chirp}', [ChirpController::class, 'update'])->name('chirps.update');
Route::delete('chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
Route::get('chirps/latest', [ChirpController::class, 'latest'])->name('chirps.latest');
Route::get('chirps/all', [ChirpController::class, 'all'])->name('chirps.all');
Route::get('chirps/profile', [ChirpController::class, 'profile'])->name('chirps.profile');
Route::get('chirps/user/{id}', [ChirpController::class, 'user'])->name('chirps.user');

Route::get('chirps/{chirp}/comments', [CommentController::class, 'index'])->name('chirps.comments.index');
Route::post('chirps/{chirp}/comments', [CommentController::class, 'store'])->name('chirps.comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

require __DIR__.'/auth.php';

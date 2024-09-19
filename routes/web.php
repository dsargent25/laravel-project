<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['middleware' => ['auth']], function(){
    Route::get('chirps/', [ChirpController::class, 'index'])->name('chirps.index');
    Route::post('chirps/', [ChirpController::class, 'store'])->name('chirps.store');
    Route::get('chirps/{chirp}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
    Route::put('chirps/{chirp}', [ChirpController::class, 'update'])->name('chirps.update');
    Route::delete('chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
    Route::get('chirps/latest', [ChirpController::class, 'latest'])->name('chirps.latest');

});

//Logically separated, but create groups to reuse /chirps

Route::group(['middleware' => ['auth']], function(){

    //Route for Displaying All Chirpers
    Route::get('users/', [UserController::class, 'index'])->name('user.index');
    //End of Route for Displaying All Chirpers

    //Route for Displaying a Chirper's Profile
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    //End of Route for Displaying a Chirper's Profile

    //Routes for Following/Unfollowing
    Route::post('user/{user}/follow', [UserController::class,'follow'])->name('user.follow');
    Route::post('user/{user}/unfollow', [UserController::class,'unfollow'])->name('user.unfollow');
    //End of Routes for Following/Unfollowing

    //Routes for Creating, Storing, and Destroying Comments
    Route::get('chirps/{chirp}/comments/create', [CommentController::class, 'create'])->name('chirps.comments.create');
    Route::post('chirps/{chirp}/comments', [CommentController::class, 'store'])->name('chirps.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    //End of Routes for Creating, Storing, and Destroying Comments

});

require __DIR__.'/auth.php';

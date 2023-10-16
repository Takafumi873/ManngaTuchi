<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ReviewController;
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
Route::group(['middleware' =>['auth']], function(){
Route::get('/', [ComicController::class, 'index'])->name('index');
Route::get('/posts/create/{comic}', [ComicController::class, 'create'])->name('create-post'); 
Route::get('/posts/{comic}', [ComicController::class, 'show'])->name('show-post'); 
Route::post('/posts/', [ReviewController::class, 'store'])->name('store-review'); 
Route::post('/posts/like', [ComicController::class, 'like'])->name('comics.like');
Route::delete('/posts/{review}', [ComicController::class, 'delete'])->name('delete-review'); 
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

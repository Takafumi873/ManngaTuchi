<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ReviewController;

Route::get('/', [ComicController::class, 'index'])->name('home'); 
Route::get('/posts/create/{comic}', [ComicController::class, 'create'])->name('create-post'); 
Route::get('/posts/{comic}', [ComicController::class, 'show'])->name('show-post'); 
Route::post('/posts/', [ReviewController::class, 'store'])->name('store-review'); 
Route::delete('/posts/{review}', [ComicController::class, 'delete'])->name('delete-review'); 

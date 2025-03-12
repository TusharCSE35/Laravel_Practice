<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome', ['posts'=> Post::all()]);
})->name('home');

Route::get('/create', [PostController::class, 'create']);

Route::post('/store', [PostController::class, 'ourfilestore'])->name('store');

Route::get('/edit/{id}', [PostController::class, 'editData'])->name('edit');

Route::post('/update/{id}', [PostController::class, 'updatePost'])->name('updatePost');
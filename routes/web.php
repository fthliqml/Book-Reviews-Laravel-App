<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

// automatically register route for CRUD and connect to controller method
Route::resource('books', BookController::class)
    ->only(['index', 'show']);

/*
 Route::get('books', [BookController::class, 'index'])->name('books.index');
 Route::get('books/create', [BookController::class, 'create'])->name('books.create');
 Route::post('books', [BookController::class, 'store'])->name('books.store');
 Route::get('books/{product}/edit', [BookController::class, 'edit'])->name('books.edit');
 Route::put('books/{product}', [BookController::class, 'update'])->name('books.update');
 Route::delete('books/{product}', [BookController::class, 'destroy'])->name('books.destroy');
 */

Route::resource('books.reviews', ReviewController::class)
    ->scoped(['review' => 'book'])
    ->only(['create', 'store']);

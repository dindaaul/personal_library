<?php

use App\Http\Controllers\BookBrowseController;
use App\Http\Controllers\BookCollectionController;
use App\Http\Controllers\BookReadController;
use App\Http\Controllers\BookSearchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Book Search routes
    Route::get('/search', [BookSearchController::class, 'index'])->name('search.index');
    Route::get('/search/results', [BookSearchController::class, 'search'])->name('search.results');

    // Book Browse routes
    Route::get('/browse', [BookBrowseController::class, 'index'])->name('browse.index');

    // Book Collection CRUD routes (using explicit IDs)
    Route::get('/collection', [BookCollectionController::class, 'index'])->name('collection.index');
    Route::post('/collection', [BookCollectionController::class, 'store'])->name('collection.store');
    Route::get('/collection/{id}/edit', [BookCollectionController::class, 'edit'])->name('collection.edit');
    Route::put('/collection/{id}', [BookCollectionController::class, 'update'])->name('collection.update');
    Route::delete('/collection/{id}', [BookCollectionController::class, 'destroy'])->name('collection.destroy');

    // Read book (using book ID)
    Route::get('/read/{id}', [BookReadController::class, 'show'])->name('read.show');
});

require __DIR__ . '/auth.php';

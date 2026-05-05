<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DownloadController;
use App\Models\Book;
use App\Support\LibraryCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home', [
        'stats' => LibraryCatalog::stats(),
        'featuredBooks' => LibraryCatalog::featuredBooks(),
        'categories' => LibraryCatalog::categories(),
    ]);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');
    Route::get('/register', [AuthController::class, 'createRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

    Route::get('/books/{book:slug}/download/pdf', [DownloadController::class, 'pdf'])->name('books.download.pdf');
    Route::get('/books/{book:slug}/download/epub', [DownloadController::class, 'epub'])->name('books.download.epub');
});

Route::redirect('/books', '/catalog');

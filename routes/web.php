<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;


Route::name('articles.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('{slug}', [ArticleController::class, 'show'])->name('show');
});

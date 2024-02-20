<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;




Route::get('/', HomeController::class)->name('home');
Route::get('/library', [BookController::class,'index'])->name('books.bookLibrary');



Route::get('download',[PdfController::class,'downloadpdf'])->name('Books.pdf');


Route::redirect('/dashboard', '/');

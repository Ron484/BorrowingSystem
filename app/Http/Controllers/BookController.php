<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{

    public function index()
    {

        $mostBorrowedBooks = Book::mostBorrowed();

        return view('books.bookLibrary',
            [
                'books' => Book::orderByDesc('created_at')->take(3)->get(),

                'borrowedBooks' => $mostBorrowedBooks,

                'categories' => Category::withCount('books')->orderByDesc('books_count')->take(12)->get(),

            ]
        );
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use PDF;


class PdfController extends Controller
{
    public function downloadPdf()
    {
        $books = Book::all();

        $BookDetails= [
        'Books'=>$books

        ];

        $pdf = PDF::loadView('pdf.booksListPdf',$BookDetails);

       return $pdf->download('Books_List.pdf');
    }

}

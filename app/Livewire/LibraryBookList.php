<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination; 

use App\Models\Category;

class LibraryBookList extends Component
{
    use WithPagination;

    public $category = '';

    protected $queryString = ['category'];

    public function getBooksProperty()
{
    $query = Book::RecentlyAdded();
    
    if ($this->category) {
        $query->whereHas('category', function ($query) {
            $query->where('name', $this->category);
        });
    }

    return $query->paginate(3);
}

    public function render()
    {
        $categories = Category::all();

        return view('livewire.library-book-list', compact('categories'));
    }

    public function resetFilter()
    {
        $this->category = '';
    }
}

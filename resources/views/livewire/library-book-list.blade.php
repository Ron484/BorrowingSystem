<div>
    @foreach ($this->books as $book)
        <x-books.book-content :book="$book"/>
    @endforeach

    <div class="p-10 my-3">
        {{$this->books->onEachSide(1)->links()}}
    </div>
</div>
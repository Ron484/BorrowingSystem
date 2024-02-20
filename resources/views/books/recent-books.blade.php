<div class=" bg-white rounded-xl mt-8 shadow-md p-4 overflow-hidden " style="width: 290px;">


    <h3 class="text-xl font-semibold text-gray-700 mb-3 font-roboto" style="color: rgb(176, 211, 49);">Most Borrowed Books</h3>
    <div class="space-y-4">
        @foreach ($borrowedBooks as $book)
            <a wire:navigate href="{{ route('books.bookLibrary',  ['category' => $book->category->name]) }}" class="flex group">
                <div class="flex-shrink-0">
                    <img src="{{ $book->getImage() }}" class="h-14 w-20 rounded object-cover">
                </div>
                <div class="flex-grow pl-3">
                    <h5 class="text-md leading-5 block font-roboto font-semibold transition group-hover:text-blue-500" style="color: rgb(120, 151, 5);">
                        {{ $book->title }}
                    </h5>
                    

                </div>
            </a>
        @endforeach

    </div>
</div>

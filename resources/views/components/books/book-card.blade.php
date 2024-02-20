<div>
    @props(['book'])
   

 <div class="bg-white rounded-xl shadow-md p-4 h-98  overflow-hidden ">

 <div class="flex-1 mb-4" >
    <a wire:navigate href="{{ route('books.bookLibrary') }}">
         <div class="aspect-w-3 aspect-h-98 pl-2 " >
            <img class="object-cover rounded-xl" style="height: 250px;"src="{{ $book->getImage()  }}" alt="{{ $book->title }}">
        </div>
    </a>

      </div>

            <div class="mt-3  ">
            <a wire:navigate href="{{ route('books.bookLibrary') }}" class="text-xm font-bold text-gray-900">{{ $book->title }}</a>
            <p class="text-gray-600 text-xs"> by {{ $book->author }}</p>
        </div>
    </div>

</div>


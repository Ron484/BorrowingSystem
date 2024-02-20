<div style="width: 290px;" class=" bg-white rounded-xl shadow-md min-h-96 p-2 overflow-hidden ">

    <h3 class="text-xl pt-1 font-semibold text-gray-700 mb-3 font-roboto" style="color: rgb(176, 211, 49);">Categories</h3>
    <div class="space-y-3 ">
        @foreach ($categories as $category)
            <a href="{{ route('books.bookLibrary', ['category' => $category->name]) }}"
                class="flex leading-4 items-center font-semibold text-sm uppercase transition hover:text-pink-500" style="color: rgb(120, 151, 5);">
                <span>{{ $category->name }}</span>
                <p class="ml-auto font-normal">({{ $category->books()->count() }})</p>
            </a>
        @endforeach

        @if ($category)
            <a href="{{ route('books.bookLibrary') }}" wire:click.prevent="resetFilter"
                class="flex leading-4 items-center   font-semibold text-gray-700 mb-3 font-roboto hover:text-pink-500" style="color: rgb(176, 211, 49);">
                Show All Books
            </a>
        @endif

    </div>
</div>

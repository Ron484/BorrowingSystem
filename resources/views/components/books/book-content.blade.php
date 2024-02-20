@props(['book'])


<div class="bg-white rounded-xl shadow-md p-2 h-100 overflow-hidden md:col-span-1 col-span-1 mb-6">

    <div class="flex">

        <div class="w-1/3 p-4 pt-8">
            <a wire:navigate href="{{ route('books.bookLibrary', $book->title) }}"
                class="block rounded-md overflow-hidden">
                <img src="{{ $book->getImage() }}"
                    class="w-full h-98 object-cover transform hover:scale-110 transition duration-500">

            </a>
        </div>

        <div class="w-2/3 p-4 pb-3">
            <a wire:navigate href="{{ route('books.bookLibrary', $book->title) }}">
                <h2 class="block text-2xl font-semibold text-gray-700 hover:text-pink-500 transition font-roboto"
                    style="color: rgb(176, 211, 49);">
                    {{ $book->title }}
                </h2>
            </a>
            <p class=" text-sm mt-2" style="color: rgb(120, 151, 5);">
                {{ strip_tags($book->description) }}
            </p>
            <div class="mt-3 flex space-x-4">
                <div class="flex text-sm items-center" style="color: #ffd17c">
                    <span class="mr-2 text-xs">
                        <i class="far fa-user" style="color: #ffb108"></i>
                    </span>
                    {{ $book->author }}
                </div>
                <div class="flex  text-sm items-center " style="color: #ffd17c">
                    <span class="mr-2 text-xs">
                        <i class="fa-solid fa-globe" style="color: #ffb108" ;></i>
                    </span>
                    {{ $book->publisher }}
                </div>
            </div>
            <div class="mt-3 flex flex-wrap">
                <span class="inline-block rounded-full px-3 py-1 text-sm font-semibold  mr-2 mb-2"
                    style="background-color: #ffcc88; color: #ffffff;">Category:{{ $book->category->name }}</span>
                @if ($book->pages)
                    <span class="inline-block  rounded-full px-3 py-1 text-sm font-semibold  mr-2 mb-2"
                        style="background-color:  #ffcc88; color: #ffffff;">Pages: {{ $book->pages }}</span>
                @endif
            </div>
        </div>

    </div>
</div>

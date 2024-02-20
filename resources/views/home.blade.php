<x-app-layout>

    @Section('hero')
        <div class="w-full  h-80 bg-cover bg-auto  relative"
            style="background-image: url('{{ asset('image/hero5.jpeg') }}') ; background-color: transparent;">

            <div class="absolute inset-0 bg-black opacity-30"></div>
            <div class="absolute inset-0 flex flex-col justify-center items-center text-white">
                <h1 class="text-2xl md:text-3xl lg:text-5xl font-bold text-center">
                    Welcome to <span style="color: rgb(255, 190, 13);"> LICERIA</span> System
                </h1>
                <p class="text-lg mt-1">Best Book Borrowing System in the universe</p>
            </div>
        </div>
    @endsection
    <div class="mt-28">


        <div class="mb-10">
            <div class="mb-16">
                <div class="w-full">
                    <div class="grid grid-cols-5 gap-10 w-full">
                        @foreach($RecentlyAddedBooks as $book)
                        <div class="md:col-span-1 col-span-3">
                            <x-books.book-card :book="$book" />

                        </div>
                        @endforeach
                    </div>
                </div>
                <a class="mt-10 block text-center text-lg  font-semibold" href="http://127.0.0.1:8000/library" style="color: rgb(176, 211, 49);">
                    More Books</a>
            </div>
        </div>
    </div>

</x-app-layout>

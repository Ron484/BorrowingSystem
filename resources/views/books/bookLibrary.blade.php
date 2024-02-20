<body>
    <x-app-layout>


        <main class="py-12 bg-white-100 min-h-screen">

            <div class="container  mx-auto px-4 flex flex-wrap lg:flex-nowrap">

                <!-- left sidebar -->
                <div class="w-4/12 py-12 mx-2">

                    <!-- categories -->

                    @include('books.category-list')

                    <!-- end categories -->

                    <!-- recent BOOK -->
                    @include('books.recent-books')


                </div>


                <!-- Main content -->
                <div class="w-9/12 xl:w-7/12 lg:w-9/12 mx-auto py-12 pr-30">
                    <livewire:library-book-list />
                </div>

            </div>


        </main>

    </x-app-layout>
</body>

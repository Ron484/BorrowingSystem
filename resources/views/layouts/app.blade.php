<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Font Awesome  -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        

        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <script src="{{asset('js/homeFunction.js')}}"></script> --}}


        <!-- Styles -->
        @livewireStyles
    

    </head>
    <body class="font-sans antialiased">
        <x-banner />

         
            @include('layouts.shared.header')

            @yield('hero')

            <main class="container mx-auto px-5 flex flex-grow">
               {{ $slot }}
              
        

               
            </main>
        
            @include('layouts.shared.footer')



        @stack('modals')

        @livewireScripts
    </body>
</html>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Perpustakaan PNJ'))</title>
        <meta name="description" content="@yield('meta_description', 'Perpustakaan PNJ adalah katalog digital kampus untuk mencari, membaca, dan mengunduh koleksi buku.')">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="min-h-screen bg-[#fffdf5] text-slate-800 antialiased transition-colors duration-300 dark:bg-[#14110a] dark:text-slate-100">
        @include('partials.navbar')

        <main>
            @yield('content')
        </main>

        @include('partials.footer')
        @stack('scripts')
    </body>
</html>

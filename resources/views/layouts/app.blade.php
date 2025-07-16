<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles dari Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles dari public (tambahan) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Tempat untuk menambahkan CSS halaman -->

    <!-- CSS Bootstrap dan Template -->
        <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    @stack('style')
</head>
<body class="font-sans antialiased">

    <div class="min-h-screen bg-white dark:bg-white flex">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Konten Utama --}}
        <div class="flex-1">
            {{-- Jika ada header (opsional) --}}
            @isset($header)
                <header class="bg-white dark:bg-white borders-b">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Konten yang di-yield dari setiap halaman --}}
            <main class="p-6">
                @yield('main')
            </main>
        </div>
    </div>

    <!-- Script dari public (tambahan) -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    {{-- Tempat untuk menambahkan script halaman --}}
    @stack('scripts')
</body>
</html>

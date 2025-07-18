<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Penting untuk responsive --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles dari Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles dari public (tambahan) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- CSS Bootstrap dan Template -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    {{-- Tambahan CSS untuk background dan konten --}}
    <style>
        body {
            background: url('{{ asset('img/background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }
        .main-content {
            background: rgba(255,255,255,0.95);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>

    @stack('style')
</head>
<body class="font-sans antialiased">

    <div class="container-fluid">
        <div class="row no-gutters">
            <!-- Sidebar -->
            <nav class="col-12 col-md-3 col-lg-2 bg-light p-0">
                @include('components.sidebar')
            </nav>

            <!-- Konten Utama -->
            <div class="col-12 col-md-9 col-lg-10">
                @isset($header)
                    <header class="bg-white border-bottom">
                        <div class="px-3 py-3">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="p-3">
                    @yield('main')
                </main>
            </div>
        </div>
    </div>

    <!-- Script dari public -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    @stack('scripts')
</body>
</html>

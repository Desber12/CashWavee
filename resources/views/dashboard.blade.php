{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CashWave</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white h-screen shadow-md">
        <h1 class="text-2xl font-bold mt-8 ml-20">CashWave</h1>
        <nav class="mt-4">
            <ul>
                <li><a href="/dashboard" class="block py-2 px-4 hover:bg-gray-200 mt-5 ml-1">DASHBOARD</a></li>
                <li><a href="{{ route('user.index') }}" class="block py-2 px-4 hover:bg-gray-200">User</a></li>
                <li><a href="{{ route('produk.index') }}" class="block py-2 px-4 hover:bg-gray-200">Produk</a></li>
                <li><a href="{{ route('orders.index') }}" class="block py-2 px-4 hover:bg-gray-200">Order</a></li>
                <li><a href="{{ route('logout') }}" class="block py-2 px-4 hover:bg-red-200 text-red-600">Logout</a></li>
            </ul>
        </nav>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        {{ $header ?? '' }}
    
    </main>

</body>
</html>

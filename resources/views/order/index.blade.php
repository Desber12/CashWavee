<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            Daftar Pesanan
        </h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('orders.create') }}"
               class="px-4 py-2 bg-red-500 text-white rounded">
                Tambah Pesanan
            </a>
        </div>

        <table class="w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-black px-4 py-2">ID</th>
                    <th class="border border-black px-4 py-2">Nama User</th>
                    <th class="border border-black px-4 py-2">Total Harga</th>
                    <th class="border border-black px-4 py-2">Status</th>
                    <th class="border border-black px-4 py-2">Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="border border-black px-4 py-2">{{ $order->id }}</td>
                        <td class="border border-black px-4 py-2">{{ $order->user->name }}</td>
                        <td class="border border-black px-4 py-2">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="border border-black px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="border border-black px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

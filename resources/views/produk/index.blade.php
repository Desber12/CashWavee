<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-black leading-tight">
            Daftar Produk
        </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('produk.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-4 py-2 rounded shadow inline-block">
            + Tambah Produk
        </a>

        @if(session('success'))
            <div class="mt-4 text-green-600 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto mt-6">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border border-gray-300 px-4 py-2">Gambar</th>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Harga</th>
                        <th class="border border-gray-300 px-4 py-2">Stok</th>
                        <th class="border border-gray-300 px-4 py-2">Kategori</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $produk)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">
                                @if ($produk->gambar)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" class="w-16 h-16 object-cover">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $produk->nama_produk }}</td>
                            <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $produk->stok }}</td>
                            <td class="border px-4 py-2">{{ $produk->kategori }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="{{ route('produk.edit', $produk) }}"
                                   class="text-indigo-600 hover:underline">Edit</a>
                                |
                                <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                            class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Tidak ada produk ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

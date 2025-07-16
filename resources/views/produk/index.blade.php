<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-black leading-tight">
            Daftar Produk
        </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('produk.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow inline-block">
            + Tambah Produk
        </a>
    </div>

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="mt-4 text-green-600 font-medium px-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto mt-6 px-6">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Kategori</th>
                    <th class="border border-gray-300 px-4 py-2">Harga</th>
                    <th class="border border-gray-300 px-4 py-2">Gambar</th>
                    <th class="border border-gray-300 px-4 py-2">Stok</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $produks)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $produks->nama_produk }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $produks->kategori }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            Rp {{ number_format($produks->harga, 0, ',', '.') }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($produks->gambar)
                                <img src="{{ asset('storage/'.$produks->gambar) }}" alt="Gambar Produk"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400 italic">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $produks->stok }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2 space-x-2">
                            <a href="{{ route('produk.edit', $produks->id) }}"
                               class="text-indigo-600 hover:underline">Edit</a>
                            |
                            <form action="{{ route('produk.destroy', $produks->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Tidak ada produk ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $produk->links() }}
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Produk</h2>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label>Nama Produk:</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="border rounded w-full" required>
            </div>

            <div>
                <label>Harga:</label>
                <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" class="border rounded w-full" required>
            </div>

            <div>
                <label>Stok:</label>
                <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="border rounded w-full" required>
            </div>

            <div>
                <label>Kategori:</label>
                <select name="kategori" class="border rounded w-full" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="makanan" {{ $produk->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ $produk->kategori == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ $produk->kategori == 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
            </div>

            <div>
                <label>Gambar:</label>
                <input type="file" name="gambar" class="border rounded w-full">
                @if ($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" class="w-20 h-20 mt-2 object-cover">
                @endif
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
        </form>
    </div>
</x-app-layout>

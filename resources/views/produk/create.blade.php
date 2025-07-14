<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Produk</h2>
    </x-slot>

    <div class="p-4">
        <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="w-full border rounded px-3 py-2">
                @error('nama_produk') <div class="text-red-500">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Harga</label>
                <input type="number" name="harga" value="{{ old('harga') }}" class="w-full border rounded px-3 py-2">
                @error('harga') <div class="text-red-500">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}" class="w-full border rounded px-3 py-2">
                @error('stok') <div class="text-red-500">{{ $message }}</div> @enderror
            </div>

            {{-- Tambahkan Kategori --}}
            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <select name="kategori" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="makanan" {{ old('kategori') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('kategori') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ old('kategori') == 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
                @error('kategori') <div class="text-red-500">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Gambar Produk</label>
                <input type="file" name="gambar" class="w-full">
                @error('gambar') <div class="text-red-500">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>

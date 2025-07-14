<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pesanan
        </h2>
    </x-slot>

    <div class="p-6">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            {{-- Pilih Pengguna --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Pilih Pengguna</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Pengguna --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Produk dan Jumlah --}}
            <div id="produk-list">
                <div class="flex space-x-4 mb-4">
                    <select name="produk_id[]" required class="border p-2 w-1/2">
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                        @endforeach
                    </select>

                    <input type="number" name="quantity[]" placeholder="Jumlah" class="border p-2 w-1/2" required min="1">
                </div>
            </div>

            {{-- Total Harga --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Total Harga</label>
                <input type="number" name="total_harga" step="0.01" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="pending">Pending</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            {{-- Tombol Submit --}}
            <div class="mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan Pesanan
                </button>
                <a href="{{ route('orders.index') }}" class="ml-4 text-blue-600 hover:underline">Kembali</a>
            </div>
        </form>
    </div>
    <script>
    function hitungTotalHarga() {
        let total = 0;
        document.querySelectorAll('#produk-list .flex').forEach((row) => {
            const select = row.querySelector('.produk-select');
            const quantityInput = row.querySelector('.quantity-input');
            const harga = parseInt(select.options[select.selectedIndex].dataset.harga || 0);
            const qty = parseInt(quantityInput.value || 0);
            total += harga * qty;
        });
        document.getElementById('total-harga').value = total;
    }

    // Jalankan saat halaman pertama dimuat
    hitungTotalHarga();

    // Jalankan setiap kali select produk atau quantity berubah
    document.querySelectorAll('.produk-select, .quantity-input').forEach((el) => {
        el.addEventListener('change', hitungTotalHarga);
        el.addEventListener('input', hitungTotalHarga);
    });
</script>

</x-app-layout>

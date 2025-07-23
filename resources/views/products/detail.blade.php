@extends('layouts.app') <!-- jika kamu pakai layout, atau bisa hapus baris ini -->

@section('content')
<div class="container">
    <h1>Detail Produk</h1>
    <div>
        <p><strong>Nama Produk:</strong> {{ $produk->nama }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
        <p><strong>Stok:</strong> {{ $produk->stok }}</p>
        <p><strong>Deskripsi:</strong> {{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}</p>
    </div>
    <a href="{{ url('/produk') }}">← Kembali ke daftar produk</a>
</div>
@endsection

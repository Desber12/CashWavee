<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produk = DB::table('produk')
            ->when($request->input('name'), function ($query, $name) {
                // pastikan kolomnya sesuai dengan tabel di database
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // variabel yang dikirim: $produk
        return view('produk.index', compact('produk'));
    }


    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('pages.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:produk',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/produk', $filename);
        $data = $request->all();

        $category = DB::table('categories')->where('id', $request->category_id)->first();

        $produk = new \App\Models\produk;
        $produk->name = $request->name;
        $produk->price = (int) $request->price;
        $produk->stock = (int) $request->stock;
        $produk->category = $category->name;
        $produk->category_id = $request->category_id;
        $produk->image = $filename;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'produk successfully created');
    }

    public function edit($id)
    {
        $produk = \App\Models\produk::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.produk.edit', compact('produk', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $produk = \App\Models\produk::findOrFail($id);
        $category = DB::table('categories')->where('id', $request->category_id)->first();
        $data['category'] = $category->name;
        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'produk successfully updated');
    }

    public function destroy($id)
{
    // Hapus data terkait di tabel _items
    DB::table('order_produk')->where('produk_id', $id)->delete();

    // Hapus produk dari tabel produk
    $produk = \App\Models\produk::findOrFail($id);
    $produk->delete();

    return redirect()->route('produk.index')->with('success', 'produk successfully deleted');
}

}

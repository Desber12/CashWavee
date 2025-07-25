<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('products.index', compact('products'));

    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|min:3|unique:products',
        'price' => 'required|integer',
        'stock' => 'required|integer',
        'category_id' => 'required',
        'image' => 'required|image|mimes:png,jpg,jpeg'
    ]);

    // Simpan gambar ke storage/app/public/products
    $path = $request->file('image')->store('products', 'public');

    $category = DB::table('categories')->where('id', $request->category_id)->first();

    $product = new \App\Models\Product;
    $product->name = $request->name;
    $product->price = (int) $request->price;
    $product->stock = (int) $request->stock;
    $product->category = $category->name;
    $product->category_id = $request->category_id;
    $product->image = $path;
    $product->save();

    return redirect()->route('product.index')->with('success', 'Product successfully created');
}


    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);
        $category = DB::table('categories')->where('id', $request->category_id)->first();
        $data['category'] = $category->name;
        $product->update($data);
        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
    // Hapus data terkait di tabel order_produk
    DB::table('order_produk')->where('produk_id', $id)->delete();

    // Hapus produk dari tabel products
    $product = \App\Models\Product::findOrFail($id);
    $product->delete();

    return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }

}

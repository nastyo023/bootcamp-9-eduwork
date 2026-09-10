<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter Pencarian Nama Produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('product_category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10);
        $categories = ProductCategory::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price'               => 'required|numeric|min:0',
            'stock'               => 'required|integer|min:0',
            'description'         => 'nullable|string',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = 'products/default.png'; 
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . Str::random(5),
            'product_category_id' => $request->product_category_id,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'description'         => $request->description,
            'image'               => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Toleransi pembacaan baik 'product_category_id' maupun 'category_id'
        $categoryId = $request->input('product_category_id') ?? $request->input('category_id');
        $request->merge(['product_category_id' => $categoryId]);

        $request->validate([
            'name'                => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price'               => 'required|numeric|min:0',
            'stock'               => 'required|integer|min:0',
            'description'         => 'nullable|string',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'product_category_id.required' => 'Kategori produk wajib dipilih.',
            'product_category_id.exists'   => 'Kategori yang dipilih tidak valid.',
        ]);

        $data = [
            'name'                => $request->name,
            'product_category_id' => $request->product_category_id,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'description'         => $request->description,
        ];

        // Perbarui slug jika nama produk mengalami perubahan
        if ($product->name !== $request->name) {
            $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);
        }

        // Kelola penggantian gambar
        if ($request->hasFile('image')) {
            if ($product->image && $product->image !== 'products/default.png' && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image && $product->image !== 'products/default.png' && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
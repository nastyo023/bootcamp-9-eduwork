<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori sekaligus menangani Form Edit Inline.
     */
    public function index(Request $request)
    {
        $query = ProductCategory::withCount('products');

        // Filter Pencarian Nama Kategori
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10);

        // Jika tombol Edit diklik (URL: /admin/categories?edit=ID)
        $category = null;
        if ($request->filled('edit')) {
            $category = ProductCategory::find($request->edit);
        }

        return view('admin.categories.index', compact('categories', 'category'));
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Redirect langsung ke index jika route edit dipanggil biasa.
     */
    public function edit($category)
    {
        $id = $category instanceof ProductCategory ? $category->id : $category;
        return redirect()->route('admin.categories.index', ['edit' => $id]);
    }

    /**
     * Perbarui data kategori.
     */
    public function update(Request $request, $category)
    {
        if (!$category instanceof ProductCategory) {
            $category = ProductCategory::findOrFail($category);
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_categories', 'name')->ignore($category->id),
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori dari database.
     */
    public function destroy($category)
    {
        if (!$category instanceof ProductCategory) {
            $category = ProductCategory::findOrFail($category);
        }

        // Cek jika kategori masih memiliki produk terkait
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::withCount(['products'])
                        // ->with([
                        //     'products' => function($query) {
                        //         $query->where('stock', '>', 50);
                        //     }
                        // ])
                        ->withSum('products', 'stock')
                        ->get();
        return view('dashboards.product-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
        ]);

        if(ProductCategory::where('name', $request->name)->exists()) {
            return back()->withErrors(['name' => 'The category name already exists.'])->withInput();
        }

        $slug = Str::slug($request->name); // example: "Electronics and Accessories" becomes "electronics-and-accessories"

        ProductCategory::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return back()->with('success', 'Product category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50'
        ]);

        if(ProductCategory::where('name', $request->name)->where('id', '!=', $productCategory->id)->exists()) {
            return back()->withErrors(['name' => 'The category name "' . $request->name . '" already exists.'])->withInput();
        }

        $slug = Str::slug($request->name);

        $productCategory->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return back()->with('success', 'Product category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        if($productCategory->products()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with associated products.']);
        }
        
        $productCategory->delete();
        return back()->with('success', 'Product category deleted successfully.');
    }
}
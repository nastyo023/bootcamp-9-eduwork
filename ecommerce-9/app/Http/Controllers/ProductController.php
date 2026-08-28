<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('productCategory');

        if($request->has('search') && $request->search != '') {
            $products = $products->where('name', 'like', '%' . $request->search . '%')
                        ->orWhereHas('productCategory', function($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->search . '%');
                        });
        }

        if($request->has('order_by') && $request->order_by != '' && in_array($request->order_by, ['name', 'price', 'stock'])) {
            $orderDirection = $request->has('order_direction') && in_array($request->order_direction, ['asc', 'desc']) ? $request->order_direction : 'asc';
            $products = $products->orderBy($request->order_by, $orderDirection);
        }else{
            $products = $products->orderBy('id', 'desc');
        }
        
        $products = $products->paginate(10);
        return view('dashboards.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategory::select('id', 'name')->get();
        return view('dashboards.products.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate input
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:1000',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'image' => 'required|string', // Base64 image
        ]);

        $imagePath = null;
        
        // Handle base64 cropped image
        if ($request->image && strpos($request->image, 'data:image') === 0) {
            // Extract base64 data
            $imageData = substr($request->image, strpos($request->image, ',') + 1);
            $imageData = base64_decode($imageData);
            
            // Generate unique filename
            $filename = 'product_' . time() . '_' . uniqid() . '.webp';
            // $path = public_path('app/public/products');
            
            // // Create directory if it doesn't exist
            // if (!file_exists($path)) {
            //     mkdir($path, 0755, true);
            // }
            
            // // Save the image
            // file_put_contents($path . '/' . $filename, $imageData);
            $imagePath = 'products/' . $filename;
            Storage::disk('images')->put($imagePath, $imageData);
        }

        // Create product
        Product::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->input('name')),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->product_category_id,
            'image' => 'images/' . $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
                        ->with('productCategory')
                        ->firstOrFail();
        $productRecommendations = Product::where('product_category_id', $product->product_category_id)
                                ->where('id', '!=', $product->id)
                                ->inRandomOrder()
                                ->where('stock', '>', 0)
                                ->take(4)
                                ->get();
        $in_stock = $product->stock > 0;
        return view('products.show', compact('product', 'productRecommendations', 'in_stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Product $product)
    public function edit(string $id)
    {
        $product = Product::find($id);

        if(!$product) {
            return redirect()->route('products.index')->withErrors(['error' => 'Product with id ' . $id . ' not found.']);
        }
        
        $productCategories = ProductCategory::all();
        return view('dashboards.products.edit', compact('product', 'productCategories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($request->all());
        // Validate input
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:1000',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|string', // Base64 image
        ]);

        $imagePath = $product->image; // Keep existing image path by default
        
        // Handle base64 cropped image
        if ($request->image && strpos($request->image, 'data:image') === 0) {
            $imagePath = str_replace('images/', '', $imagePath); // Remove 'images/' prefix to get the actual path in the storage disk
            if(Storage::disk('images')->exists($imagePath)) {
                Storage::disk('images')->delete($imagePath);
            }
            // Extract base64 data
            $imageData = substr($request->image, strpos($request->image, ',') + 1);
            $imageData = base64_decode($imageData);
            
            // Generate unique filename
            $filename = 'product_' . time() . '_' . uniqid() . '.webp';
            $imagePath = 'products/' . $filename;
            Storage::disk('images')->put($imagePath, $imageData);
            $imagePath = 'images/' . $imagePath;
        }

        // Create product
        $product->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->input('name')),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->product_category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product with id ' . $product->id . ' updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->orderItems()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete product with associated order items.']);
        }

        if($product->cartItems()->count() > 0) {
            $product->cartItems()->delete(); // Delete associated cart items
        }

        // Delete the product image from storage
        $imagePath = str_replace('images/', '', $product->image); // Remove 'images/' prefix to get the actual path in the storage disk
        if(Storage::disk('images')->exists($imagePath)) {
            Storage::disk('images')->delete($imagePath);
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product with id ' . $product->id . ' deleted successfully.');
    }
}
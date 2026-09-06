<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('stock', '>', 0);

        if($request->search) {
            // blue....
            // ....blue
            // blue
            // ...blue...
            $products->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if($request->category) {
            $products->where('product_category_id', $request->input('category'));
        }

        // order by price
        if($request->input('sort') === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif($request->input('sort') === 'price_desc') {
            $products->orderBy('price', 'desc');
        }
        
        $products = $products->paginate(8); // Fetch products with pagination (8 per page)
        $categories = ProductCategory::all();
        return view('home',
            compact('products', 'categories')
        );
    }

    // public function finalSkor(Request $request)
    // {
    //     $score = $request->input('score');

    //     // Validate the score input
    //     if (!is_numeric($score) || $score < 0 || $score > 100) {
    //         return redirect()->back()->withErrors(['score' => 'Please enter a valid score between 0 and 100.']);
    //     }

    //     // Determine the grade based on the score
    //     if($score < 50) {
    //         $score = 'E';
    //     } elseif($score < 60) {
    //         $score = 'D';
    //     } elseif($score < 70) {
    //         $score = 'C';
    //     } elseif($score < 80) {
    //         $score = 'B';
    //     } else {
    //         $score = 'A';
    //     }

    //     return $score;
    // }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->paginate(10);
        $categories = Category::all();

        return view('category.index', compact('categories', 'products', 'category'));
    }

    public function filter(Request $request, $slug)
    {
        // Get the category using the slug
        $category = Category::where('slug', $slug)->firstOrFail();
    
        // Always include the main category in filtering
        $selectedCategories = $request->has('categories') ? $request->categories : [];
        $selectedCategories[] = $category->id; // Include main category
    
        // Fetch filtered products
        $products = Product::whereIn('category_id', $selectedCategories)->paginate(10);
    
        return response()->json([
            'products' => $products->items(), // Only product data
            'pagination' => (string) $products->links() // Pagination links
        ]);
    }
    
    
    
}

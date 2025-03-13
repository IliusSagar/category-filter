<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{

    // public function index($slug)
//     {
//         $category = Category::where('slug', $slug)->firstOrFail();
//         $categories = Category::all();
    
//         // ✅ Create an empty paginator to avoid errors
//         $products = new LengthAwarePaginator([], 0, 10);
    
//         return view('category.index', compact('categories', 'products', 'category'));
//     }


    public function index($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $products = Product::where('category_id', $category->id)->paginate(10);
    $categories = Category::all();

    return view('category.index', compact('categories', 'products', 'category'));
}


public function filter(Request $request, $slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();

    // Get selected categories from the request
    $selectedCategories = $request->input('categories', []);

    // ✅ If no category is selected, show nothing (do not auto-add the main category)
    if (empty($selectedCategories)) {
        return response()->json([
            'products' => [],
            'pagination' => ''
        ]);
    }

    // Fetch filtered products
    $products = Product::whereIn('category_id', $selectedCategories)->paginate(10);

    return response()->json([
        'products' => $products->items(), // Only product data
        'pagination' => (string) $products->links(), // Pagination links
    ]);
}


    
    
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $categories = Category::all();
        $products = Product::paginate(10);

        return view('category.index', compact('categories', 'products'));
    }

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        $products = $query->get();

        return response()->json(['products' => $products]);
    }
}

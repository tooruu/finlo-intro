<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProductRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(IndexProductRequest $request)
    {
        $search = $request->getSearch();
        $sort = $request->getSortOrder();

        $products = Product::orderBy('created_at', $sort)
            ->when($search, fn ($query, $search) => $query->where('title', 'like', "%$search%"))
            ->paginate(10)
            ->fragment('products')
            ->withQueryString();

        return view('products.index', compact('products', 'search', 'sort'));
    }

    public function store(ProductStoreRequest $request)
    {
        Product::create([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
        ]);

        return to_route('products.index')->with('success', 'Product added successfully!');
    }
}

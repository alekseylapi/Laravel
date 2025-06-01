<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\Products\UpdateAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController
{
    public function index(): View
    {
        $products = Product::withTrashed()->with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request, UpdateAction $action): RedirectResponse
    {
        $data = $request->validated();
        $product = $action->update(new Product(), $data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product, UpdateAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->update($product, $data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function restore($id): RedirectResponse
    {
        Product::withTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product restored successfully.');
    }
}

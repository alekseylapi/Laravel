<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;

class CategoryController
{
    public function index()
    {
        /** @var Category[] $category */
        $category = Category::all();
        return CategoryResource::collection($category);
    }
    public function view(Product $product)
    {
        return new CategoryResource($product);
    }

    public function store(StoreCategoryRequest $request)
    {
        $productData = $request->all();

        $Category = new Product();
        $Category->name = $productData['name'];
        $Category->price = $productData['price'];
        $Category->save();

        return new CategoryResource($Category);
    }

    public function update(string $category_id)
    {
        return "Product update {$category_id}";
    }

    public function delete(string $product_id)
    {
        return "Product delete {$product_id}";
    }
}

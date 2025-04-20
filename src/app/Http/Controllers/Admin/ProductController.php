<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController
{
    public function index()
    {
        /** @var Product[] $products */
        $products = Product::all();

        return ProductResource::collection($products);
    }

    public function view(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $productData = $request->all();

        $product = new Product();
        $product->name = $productData['name'];
        $product->price = $productData['price'];
        $product->save();

        return new ProductResource($product);
    }

    public function update(string $product_id)
    {
        return "Product update {$product_id}";
    }

    public function delete(string $product_id)
    {
        return "Product delete {$product_id}";
    }
}

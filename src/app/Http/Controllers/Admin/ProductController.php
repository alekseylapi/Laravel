<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SuccessResource;
use App\Models\Product;

class ProductController
{
    public function index()
    {
        /** @var Product[] $products */
        $products = Product::withTrashed()->get();

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

    public function update(Product $product, UpdateProductRequest $request)
    {
        $productData = $request->all();

        $product->name = $productData['name'];
        $product->price = $productData['price'];
        $product->save();

        return new ProductResource($product);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return SuccessResource::make([]);
    }

    public function restore(Product $product)
    {
        $product->restore();

        return new ProductResource($product);
    }
}

<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\SuccessResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductController
{
    public function index()
    {
        /** @var Collection|Product[] $products */
        $products = Product::withTrashed()->with(['category'])->get();

        $products->load('category'); // аналогично ->with('category')

        return ProductResource::collection($products);
    }

    public function view(Product $product)
    {
//        return view('product_view', [
//            'product' => $product,
//        ]);
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $productData = $request->all();

        $category = Category::find($productData['category_id']);

        $product = new Product();
        $product->name = $productData['name'];
        $product->price = $productData['price'];
        $product->category()->associate($category);

        $product->save();

        return new ProductResource($product);
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
        $productData = $request->all();

        $category = Category::find($productData['category_id']);

        $product->name = $productData['name'];
        $product->price = $productData['price'];
        $product->category()->associate($category);

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

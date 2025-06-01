<?php

namespace App\Services\Products;

use App\Models\Product;

readonly class UpdateAction
{
    public function update(Product $product, array $data): Product
    {
        // Название продукта
        $product->name = $data['name'] . ' from action';

        // Цена продукта
        $product->price = $data['price'];

        // Если передан category_id, связываем продукт с категорией
        if (isset($data['category_id'])) {
            $category = Category::findOrFail($data['category_id']);
            $product->category()->associate($category);
        }

        $product->save();
        return $product;
    }

}

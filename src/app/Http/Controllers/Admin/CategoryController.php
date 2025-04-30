<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController
{
    public function index()
    {
        /** @var Category[] $category */
        $category = Category::all();
        return CategoryResource::collection($category);
    }
    public function view(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $categoryData = $request->all();

        $Category = new Category();
        $Category->id = $categoryData['id'];
        $Category->category_name = $categoryData['category_name'];
        $Category->save();

        return new CategoryResource($Category);
    }

    public function update(string $category_id)
    {
        return "Category update {$category_id}";
    }

    public function delete(string $categoy_id)
    {
        return "Category delete {$categoy_id}";
    }
}
